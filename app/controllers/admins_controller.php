<?php
class AdminsController extends AppController {

	var $name = 'Admins';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_index', 'admin_view');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }

   function admin_login() { 
      if ($this->MyAuth->user()) {
         $userModel = $this->MyAuth->getModel();
         $user = $userModel->read( null, $this->MyAuth->user('id') );
         $this->Session->write('role', $user['Role'] );
      }
      else {
         $this->Session->destroy();
      }
   }
 
   function admin_logout() {
      $this->Session->setFlash('Good-Bye');
      $this->log( $this->MyAuth->user('username') . "; $this->name; logout: " . $this->data['Admin']['username'], 'activity');
      $this->redirect($this->MyAuth->logout());
   }

	function admin_index() {
		$this->Admin->recursive = 0;
		$this->set('admins', $this->paginate());
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!empty($this->data)) {
         if ($this->data['Admin']['password'] == $this->MyAuth->password($this->data['Admin']['password_confirm'])) {
			   $this->Admin->create() && $this->Admin->validates();
   			if ($this->Admin->save($this->data)) {
	   			$this->Session->setFlash(__('The Admin has been saved', true));
               $this->log( $this->MyAuth->user('username') . "; $this->name; add: " . $this->data['Admin']['username'], 'activity');
               $this->Tracker->back();
   			} else {
	   			$this->Session->setFlash(__('The Admin could not be saved. Please, try again.', true));
			   }
         }
		}

      $locations_all = $this->Admin->Location->find('all',array(
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

		$roles = $this->Admin->Role->find('list');
		$this->set(compact('locations', 'roles'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Admin', true));
         $this->Tracker->back();
		}
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!empty($this->data)) {
			if ($this->Admin->save($this->data)) {
				$this->Session->setFlash(__('The Admin has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['Admin']['username'], 'activity');
            $this->Tracker->back();
			} else {
				$this->Session->setFlash(__('The Admin could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Admin->read(null, $id);
		}

		$locations_all = $this->Admin->Location->find('all',array(
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

      $roles = $this->Admin->Role->find('list');
		$this->set(compact('locations','roles'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Admin', true));
         $this->Tracker->back();
		}
		if ($this->Admin->delete($id)) {
			$this->Session->setFlash(__('Admin deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['Admin']['username'], 'activity');
         $this->Tracker->back();
		}
	}


   function admin_view($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid admin.', true));
         $this->Tracker->back();
      }
      $admin = $this->Admin->read(null, $id);
      $this->set('admin', $admin);
   }

   // set password for other users
   function admin_setPassword($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid Admin', true));
         $this->Tracker->back();
      }

      if (!empty($this->data)) {
         $this->Admin->id = $id;
         $user = $this->Admin->read();

         $password1 = $this->data['Admin']['password'];
         $password2 = $this->data['Admin']['password_confirm'];

         // check if the new password was typed in correctly
         if ( $password1 != $password2 ) {
            $this->Session->setFlash(__('New password mismatch. Please, retype the password again.', true));
            return;
         }

         // set password in array and do validation
         $user['Admin']['password'] = $this->MyAuth->password( $password1 );
         $user['Admin']['password_confirm'] = $password2;
         $this->Admin->set($user) && $this->Admin->validates();

         // save the password
         $user['Admin']['password'] = $this->MyAuth->password( $password1 );
         if ($this->Admin->save($user)) {
            $this->Session->setFlash(__('New password was set', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; set password for: " . $this->data['Admin']['username'], 'activity');
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('Password could not be set. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->Admin->read(null, $id);
      }
   }

   // change own password
   function admin_changePassword() {
      $this->Admin->recursive = -1;
      $this->Admin->id = $this->MyAuth->user('id');
      $user = $this->Admin->read();

      if (!empty($this->data)) {
         $password1 = $this->data['Admin']['password'];
         $password2 = $this->data['Admin']['password_confirm'];

         // check if old password is correct
         if ( $user['Admin']['password'] != $this->MyAuth->password($this->data['Admin']['password_old']) ) {
            $this->Session->setFlash(__('Your current password is incorrect.', true));
            return;
         }

         // check if the new password was typed in correctly
         if ( $password1 != $password2 ) {
            $this->Session->setFlash(__('New password mismatch. Please, retype the password again.', true));
            return;
         }

         // set password in array and do validation
         $user['Admin']['password'] = $this->MyAuth->password( $password1 );
         $user['Admin']['password_confirm'] = $password2;
         $this->Admin->set($user) && $this->Admin->validates();

         // save the password
         $user['Admin']['password'] = $this->MyAuth->password( $password1 );
         if ($this->Admin->save($user)) {
            $this->Session->setFlash(__('New password was set', true));
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('Password could not be set. Please, try again.', true));
         }
      }
   }

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      if ( in_array($this->action, array('admin_login', 'admin_logout', 'admin_changePassword') )) {
         return true;
      }

      if ($this->action == 'admin_view') {
         return true;
      }
      return false;
   }

}
?>
