<?php
class AdminsController extends AppController {

	var $name = 'Admins';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      //$this->MyAuth->allowedActions = array('admin_login');
   }

   function afterFilter() {
      $allowedActions = array('admin_index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }

   function admin_login() { }
 
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
      $this->Session->write("Admin",$id);
   }

   function admin_changePassword($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid Admin', true));
         $this->Tracker->back();
      }

      if (!empty($this->data)) {
         if ($this->MyAuth->password($this->data['Admin']['password']) == $this->MyAuth->password($this->data['Admin']['password_confirm'])) {
            $temp_password = $this->MyAuth->password($this->data['Admin']['password']);   
            $temp_password_confirm = $this->data['Admin']['password_confirm'];
            $this->Admin->recursive = -1;
            $admin = $this->Admin->findById($id);
            $this->data['Admin'] = $admin['Admin'];
            $this->data['Admin']['password'] = $temp_password;
            $this->data['Admin']['password_confirm'] = $temp_password_confirm;
            $this->Admin->set($this->data) && $this->Admin->validates();
            if ($this->Admin->save($this->data)) {
               $this->Session->setFlash(__('New password has been set', true));
               $this->log( $this->MyAuth->user('username') . "; $this->name ; set password for: " . $this->data['Admin']['username'], 'activity');
               $this->redirect(array('action'=>'index'));
            } else {
               $this->Session->setFlash(__('Password could not be saved. Please, try again.', true));
            }
         } else {
            $this->Session->setFlash(__('New password mismatch. Please, retype the password again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->Admin->read(null, $id);
      }
   }


   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      if ( in_array($this->action, array('admin_login', 'admin_logout') )) {
         return true;
      }

      if ($this->action == 'admin_view') {
         return true;
      }

      if ($this->action == 'admin_changePassword') {
         $admin = $this->Admin->read(null, $this->passedArgs['0'] );
         if ( $admin['Admin']['id'] == $this->Session->read('Auth.Admin.id') ) return true;

         $this->Session->setFlash(__('You can only set your own password', true));
      }

      return false;
   }

}
?>
