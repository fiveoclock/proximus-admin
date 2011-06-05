<?php
class AdminsController extends AppController {

	var $name = 'Admins';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter(); 
      $this->Auth->allowedActions = array('login','logout');
   }

   function afterFilter() {
      $allowedActions = array('display');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }

   #use this function to add/update permissions for roles
   function initDB() {
      $role =& $this->Admin->Role;
      //Rights for Global Admin role
       $role->id = 1;     
       $this->Acl->allow($role, 'controllers');
    
       //Rights for Location Admin role
       $role->id = 2;
       $this->Acl->deny($role, 'controllers');

       $this->Acl->allow($role, 'controllers/Groups/view');
       $this->Acl->allow($role, 'controllers/Groups/add');
       $this->Acl->allow($role, 'controllers/Groups/edit');
       $this->Acl->allow($role, 'controllers/Groups/delete');
       
       $this->Acl->allow($role, 'controllers/Locations/start');
       $this->Acl->allow($role, 'controllers/Locations/view');
       $this->Acl->allow($role, 'controllers/Locations/edit');
       
       $this->Acl->allow($role, 'controllers/Rules/search');
       $this->Acl->allow($role, 'controllers/Rules/view');
       $this->Acl->allow($role, 'controllers/Rules/add');
       $this->Acl->allow($role, 'controllers/Rules/edit');
       $this->Acl->allow($role, 'controllers/Rules/delete');
       $this->Acl->allow($role, 'controllers/Rules/createFromLog');
         
       $this->Acl->allow($role, 'controllers/Admins/changePassword');
       $this->Acl->allow($role, 'controllers/Admins/view');

       $this->Acl->allow($role, 'controllers/Logs/searchlist');
       $this->Acl->allow($role, 'controllers/Logs/searchstring');
       $this->Acl->allow($role, 'controllers/Logs/deleteWithChildren');
       $this->Acl->allow($role, 'controllers/Logs/delete');


       $role->id = 3;
       $this->Acl->deny($role, 'controllers');
   }


   function login() {
      //Auth Magic
   }
 
   function logout() {
      $this->Session->setFlash('Good-Bye');
      $this->redirect($this->Auth->logout());
   }

	function index() {
		$this->Admin->recursive = 0;
		$this->set('admins', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Admin.', true));
			$this->redirect(array('action'=>'index'));
		}

      if ($this->Session->read('Auth.godmode') != 1) {
         if ($id != $this->Session->read('Auth.Admin.id')) {
            $this->Session->setFlash(__('Access denied.', true));
            $this->redirect(array('controller'=>'locations','action'=>'start'));
         }
      }
      
		$this->set('admin', $this->Admin->read(null, $id));
	}

	function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
         if ($this->data['Admin']['password'] == $this->Auth->password($this->data['Admin']['password_confirm'])) {
			   $this->Admin->create() && $this->Admin->validates();
   			if ($this->Admin->save($this->data)) {
	   			$this->Session->setFlash(__('The Admin has been saved', true));
		   		$this->redirect(array('action'=>'index'));
   			} else {
	   			$this->Session->setFlash(__('The Admin could not be saved. Please, try again.', true));
			   }
         }
		}
      $locations_all = $this->Admin->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
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

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Admin', true));
			$this->redirect(array('action'=>'index'));
		}
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
			if ($this->Admin->save($this->data)) {
				$this->Session->setFlash(__('The Admin has been saved', true));
				$this->redirect(array('action'=>'index'));
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

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Admin', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Admin->del($id)) {
			$this->Session->setFlash(__('Admin deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
   
   function changePassword($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid Admin', true));
         $this->redirect(array('action'=>'index'));
      }

      if ($this->Session->read('Auth.godmode') != 1) {
         if ($id != $this->Session->read('Auth.Admin.id')) {
            $this->Session->setFlash(__('You may change only your own password', true));
            $this->redirect(array('controller'=>'locations','action'=>'start'));
         }
      }

      if (!empty($this->data)) {
         if ($this->Auth->password($this->data['Admin']['password']) == $this->Auth->password($this->data['Admin']['password_confirm'])) {
            $temp_password = $this->Auth->password($this->data['Admin']['password']);   
            $temp_password_confirm = $this->data['Admin']['password_confirm'];
            $this->Admin->recursive = -1;
            $admin = $this->Admin->findById($id);
            $this->data['Admin'] = $admin['Admin'];
            $this->data['Admin']['password'] = $temp_password;
            $this->data['Admin']['password_confirm'] = $temp_password_confirm;
            $this->Admin->set($this->data) && $this->Admin->validates();
            if ($this->Admin->save($this->data)) {
               $this->Session->setFlash(__('New password has been set', true));
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
}
?>