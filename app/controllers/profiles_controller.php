<?php
class ProfilesController extends AppController {

	var $name = 'Profiles';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);
   var $uses = array('User', 'GlobalSetting');

   function beforeFilter() {
      //parent::beforeFilter();
      #$this->MyAuth->allowedActions = array('*');
      $this->MyAuth->userModel = 'User';
      //$this->MyAuth->authorize = 'controller';
      //$this->MyAuth->actionPath = 'controllers/';
      $this->MyAuth->loginAction = array('user' => true, 'controller' => 'profiles', 'action' => 'login');
      $this->MyAuth->loginRedirect = array('user' => true, 'controller' => 'profiles', 'action' => 'index');
   }

   function afterFilter() {
      $allowedActions = array('view', 'index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }   
   }   

   function user_login() {

   }

   function user_logout() {
      $this->Session->setFlash('Good-Bye');
      $this->log( $this->MyAuth->user('username') . "; $this->name; logout: " . $this->data['User']['username'], 'activity');
      $this->redirect($this->MyAuth->logout());
   }


	function user_index() {
      # get global settings
      $Setting  = ClassRegistry::init('GlobalSetting');
      foreach( $Setting->find('all') as $key=>$value ){
         $content = $value['GlobalSetting'];
         $settings[ $content['name'] ] = $content['value'] ; 
      }
      $this->set('settings', $settings);

      # If form has been submitted
      if (!empty($this->data) && isset($this->data['User']['searchstring'])) {
         $this->NoauthRules->recursive = 0;
         $string = $this->data['User']['searchstring'];
         $this->set('users', $this->paginate('User',array("User.username LIKE '%$string%' OR User.realname LIKE '%$string%'")));
      }
      else {
         $this->User->recursive = 0;
         $this->set('users', $this->paginate());
      }

   }

   function user_view($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid user.', true));
         $this->redirect(array('controller'=>'profiles','action'=>'index'));
      }
      $user= $this->User->read(null, $id);
      $this->set('user', $user);
   }

	function user_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
         $this->redirect($this->Tracker->loadLastPos());
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['User']['username'], 'activity');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
		
      # show location code + name 
      $locations_all = $this->User->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>array("Location.id NOT" => "1"),
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );

		$groups = $this->User->Group->find('list');
		$this->set(compact('locations','groups'));
	}

   // password validation doesn't work right now
   function user_setPassword($id = null) {
      $this->User->recursive = -1;
      $this->User->id = $this->MyAuth->user('id');
      $user = $this->User->read();
      $this->set('user', $user );

      if (!empty($this->data)) {
         $password1 = $this->data['User']['password'];
         $password2 = $this->data['User']['password_confirm'];

         // check if old password is correct
         if ( $user['User']['password'] != $this->MyAuth->password($this->data['User']['password_old']) ) {
            $this->Session->setFlash(__('Your current password is incorrect.', true));
            return;
         }

         // check if the new password was typed in correctly
         if ( $password1 != $password2 ) {
            $this->Session->setFlash(__('New password mismatch. Please, retype the password again.', true));
            return;
         }

         // set password in array and do validation
         $user['User']['password'] = $this->MyAuth->password( $password1 );
         $user['User']['password_confirm'] = $password2;
         $this->User->set($user) && $this->User->validates();

         // save the password
         $user['User']['password'] = $this->MyAuth->password( $password1 );
         if ($this->User->save($user)) {
            $this->Session->setFlash(__('New password was set', true));
            $this->redirect(array('action'=>'start'));
         }
         else {
            $this->Session->setFlash(__('Password could not be saved. Please, try again.', true));
         }
      }
   }
}

?>
