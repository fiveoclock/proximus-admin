<?php
App::import('Component', 'Auth');

class MyAuthComponent extends AuthComponent {
	var $ldap = null;
   var $components = array('Session', 'CommonTasks', 'RequestHandler');

	/**
	 * Main execution method.  Handles redirecting of invalid users, and processing
	 * of login form data.
	 *
	 * @param object $controller A reference to the instantiating controller object
	 * @return boolean
	 * @access public
	 */
	function startup(&$controller) {
		$methods = array_flip($controller->methods);
		$isErrorOrTests = (
			strtolower($controller->name) == 'cakeerror' ||
			(strtolower($controller->name) == 'tests' && Configure::read() > 0)
		);
		if ($isErrorOrTests) {
			return true;
		}

		$isMissingAction = (
			$controller->scaffold === false &&
			!isset($methods[strtolower($controller->params['action'])])
		);

		if ($isMissingAction) {
			return true;
		}

		if (!$this->__setDefaults()) {
			return false;
		}
       
		$url = '';

		if (isset($controller->params['url']['url'])) {
			$url = $controller->params['url']['url'];
		}
		$url = Router::normalize($url);
		$loginAction = Router::normalize($this->loginAction);

		$isAllowed = (
			$this->allowedActions == array('*') ||
			in_array($controller->params['action'], $this->allowedActions)
		);

		if ($loginAction != $url && $isAllowed) {
			return true;
		}

		//get model registered
		$this->ldap = $this->getModel($this->userModel);

      # get global settings
      $settings = $this->CommonTasks->getGlobalSettings();

		if ($loginAction == $url) {
			if (empty($controller->data) || !isset($controller->data[$this->userModel])) {
				if (!$this->Session->check('Auth.redirect') && env('HTTP_REFERER')) {
					$this->Session->write('Auth.redirect', $controller->referer(null, true));
				}
				return false;
			}

			$isValid = !empty($controller->data[$this->userModel][$this->fields['username']]) &&
				!empty($controller->data[$this->userModel][$this->fields['password']]);

			if ($isValid) {
				$username = $controller->data[$this->userModel][$this->fields['username']];
				$password = $controller->data[$this->userModel][$this->fields['password']];


            if ( $settings['auth_method_' . $this->userModel] == "ldap" ) {
               $this->log("Using ldap auth", "debug");
               //pr("Using ldap auth...");
               if ($this->login($username, $password)) {
                  if ($this->autoRedirect) {
                     $controller->redirect($this->redirect(), null, true);
                  }
                  return true;
               }
            }
            else {
               $this->log("Using internal auth", "debug");
               //pr("Using internal auth...");
               //pr($controller->data);

               // hash password
               $data = $this->hashPasswords($controller->data);

               $username = $data[$this->userModel]['username'];
               $password = $data[$this->userModel]['password'];

               $data = array(
                  $this->userModel . '.' . $this->fields['username'] => $username,
                  $this->userModel . '.' . $this->fields['password'] => $password
               );

               //pr($data);
               if (parent::login($data)) {
                  if ($this->autoRedirect) {
                     $controller->redirect($this->redirect(), null, true);
                  }
                  return true;
               }
            }
			}
			$this->Session->setFlash($this->loginError, 'default', array(), 'auth');
			$controller->data[$this->userModel][$this->fields['password']] = null;
			return false;
		} else {
			if (!$this->user()) {
				if (!$this->RequestHandler->isAjax()) {
					$this->Session->setFlash($this->authError, 'default', array(), 'auth');
					$this->Session->write('Auth.redirect', $url);
					$controller->redirect($loginAction);
					return false;
				} elseif (!empty($this->ajaxLogin)) {
					$controller->viewPath = 'elements';
					echo $controller->render($this->ajaxLogin, $this->RequestHandler->ajaxLayout);
					$this->_stop();
					return false;
				} else {
					$controller->redirect(null, 403);
				}
			}
		}


		if (!$this->authorize) {
			return true;
		}

		extract($this->__authType());
		switch ($type) {
			case 'controller':
				$this->object =& $controller;
			break;
			case 'crud':
			case 'actions':
				if (isset($controller->Acl)) {
					$this->Acl =& $controller->Acl;
				} else {
					$err = 'Could not find AclComponent. Please include Acl in ';
					$err .= 'Controller::$components.';
					trigger_error(__($err, true), E_USER_WARNING);
				}
			break;
			case 'model':
				if (!isset($object)) {
					$hasModel = (
						isset($controller->{$controller->modelClass}) &&
						is_object($controller->{$controller->modelClass})
					);
					$isUses = (
						!empty($controller->uses) && isset($controller->{$controller->uses[0]}) &&
						is_object($controller->{$controller->uses[0]})
					);

					if ($hasModel) {
						$object = $controller->modelClass;
					} elseif ($isUses) {
						$object = $controller->uses[0];
					}
				}
				$type = array('model' => $object);
			break;
		}

		if ($this->isAuthorized($type)) {
			return true;
		}

		$this->Session->setFlash($this->authError, 'default', array(), 'auth');
		$controller->redirect($controller->referer(), null, true);
		return false;
	}

	function login($uid, $password){
		$this->__setDefaults();
		$this->_loggedIn = false;

      // check if the user exists in the database; otherwise fail
      $user = $this->ldap->find("first", array(
         'conditions' => array(
            'username' => $uid,
         )
      ));
      if ( empty($user[$this->userModel]) ) {
         $this->log("User was not found in the database: $uid", "debug");
			return $this->_loggedIn;
      }

      // change database model to ldap
      $this->ldap->useDbConfig = "ldap";
      // remember the table and change it for the ldap query
      $table = $this->ldap->useTable;
      $this->ldap->useTable = false;

      // search the user in ldap
      $dn = $this->getDn('samaccountname', $uid);
      $this->log($dn, "debug");

      // check auth against ldap
      $loginResult = $this->ldapauth($dn, $password); 
      if( $loginResult == 1){
         $this->_loggedIn = true;

         $ldapUser = $this->ldap->find('all', array('scope'=>'base', 'targetDn'=>$dn));

         $user_data = $user[$this->userModel];
         $user_data['bindDN'] = $dn;
         //$user_data['bindPasswd'] = $password;
         $this->Session->write($this->sessionKey, $user_data);
      }
      else{
         $this->loginError =  $loginResult;
      }

      // change database and table back to default
      $this->ldap->useDbConfig = "default";
      $this->ldap->useTable = $table;

      return $this->_loggedIn;
	}

	function ldapauth($dn, $password){
		$authResult =  $this->ldap->auth( array('dn'=>$dn, 'password'=>$password));
		return $authResult;
	}

	function getDn( $attr, $query){
		$userObj = $this->ldap->find('all', array('conditions'=>"$attr=$query", 'scope'=>'sub', 'recursive' => 1 ));
      //pr($userObj);
      //$this->log("1" . print_r($userObj,true), "debug");
		//$this->log("auth lookup found: ".print_r($userObj,true)." with the following conditions: ".print_r(array('conditions'=>"$attr=$query", 'scope'=>'one'),true),'debug');
		return($userObj[0][$this->userModel]['dn']);
	}
}
?>
