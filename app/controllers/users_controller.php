<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);
   var $uses = array('User', 'GlobalSetting');

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_view', 'admin_index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }   
   }   

	function admin_index() {
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

	function admin_add() {
      # get global settings
      $Setting  = ClassRegistry::init('GlobalSetting');
      $settings = array();
      foreach( $Setting->find('all') as $key=>$value){
         $content = $value['GlobalSetting'];
         $settings[ $content['name'] ] = $content['value'] ; 
      }
      $this->set('settings', $settings);


      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         if ( $settings['auth_method_User'] != "internal" ) {
            $this->data['User']['password'] = "notyetset";
            $this->data['User']['password_confirm'] = "notyetset";
         }

         if ($this->MyAuth->password($this->data['User']['password']) == $this->MyAuth->password($this->data['User']['password_confirm'])) {
            $temp_password = $this->MyAuth->password($this->data['User']['password']);
            $temp_password_confirm = $this->data['User']['password_confirm'];
            $this->data['User']['password'] = $temp_password;
            $this->data['User']['password_confirm'] = $temp_password_confirm;

            $this->User->create() && $this->User->validates();
            if ($this->User->save($this->data)) {
               $this->Session->setFlash(__('The User was saved', true));
               $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['User']['username'], 'activity');
               $this->Tracker->back();
            }
            else {
               $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
            }
         }
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
		$this->set(compact('locations', 'groups'));
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
         $this->Tracker->back();
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The User has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['User']['username'], 'activity');
            $this->Tracker->back();
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
   
   // set password function for the admin
   function admin_setPassword($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid User', true));
         $this->Tracker->back();
      }

      if (!empty($this->data)) {
         $this->User->id = $id;
         $user = $this->User->read();

         $password1 = $this->data['User']['password'];
         $password2 = $this->data['User']['password_confirm'];

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
            $this->log( $this->MyAuth->user('username') . "; $this->name ; set password for: " . $this->data['User']['username'], 'activity');
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('Password could not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->User->read(null, $id);
      }
   }

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
         $this->Tracker->back();
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['User']['username'], 'activity');
         $this->Tracker->back();
		}
	}

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      return false;
   }
}
?>
