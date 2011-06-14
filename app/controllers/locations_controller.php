<?php
class LocationsController extends AppController {

	var $name = 'Locations';
	var $helpers = array('Html', 'Form');
	var $actsAs = array('Containable');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('view','index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }  

# Not in use
	function index() {
		$this->Location->recursive = 0;
		$this->set('locations', $this->paginate());
      #$this->set('locations', $this->paginate(null, array('Location.id'=>$this->Session->read('Auth.locations'))));
	}
	
	function start() {
      $loggeduser = $this->Auth->user();
      $priv_roles = array(1, 3); # global- and read-only admins
      $allowed_locations = $this->Session->read('Auth.locations');

      if( in_array($this->Session->read('Auth.Admin.role_id'), $priv_roles) ) {
         $find_condition = array('fields' => array('Location.*'),
                              'order'=>'Location.code'
                               );
      }
      else {
         $find_condition = array('fields' => array('Location.*'),
                              'conditions'=>array('Location.id'=>$allowed_locations),
                              'order'=>'Location.code'
                               );
      }

      $locations = $this->Location->find('all',$find_condition);
      $this->set('locations', $locations);
   }

	function view($id = null) {
      $loggeduser = $this->Auth->user();
      $priv_roles = array(1, 3); # global- and read-only admins

      if (!$id) {
			$this->Session->setFlash(__('Invalid Location.', true));
			$this->redirect(array('action'=>'start'));
		}
      if( ! in_array($this->Session->read('Auth.Admin.role_id'), $priv_roles) ) {
         if (!in_array($id,$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this location', true));
            $this->redirect(array('action'=>'start'));
         }
      }
      $this->Location->recursive = 0;
      $find_condition = array('fields' => array('Location.*'),
                                'conditions'=>array('Location.id'=>$id),
                                'order'=>'Location.code'
                                );
      $location = $this->Location->find('all',$find_condition);
		$groups = $this->Location->Group->find('all',array('conditions'=>array('Group.location_id'=>$id)));
		$rules = $this->Location->Rule->find('all',array(
			'conditions'=>array(
						'AND'=>array(
							'Rule.location_id'=>$id,
							'Rule.group_id'=>0
									)
								),
			'order'=>array(
				'Rule.sitename','Rule.priority'
						  )
		));
		$users = $this->Location->User->find('all',array('conditions'=>array('AND'=>array('User.location_id'=>$id,'User.group_id'=>0))));
		
		$this->set(compact('location','groups','users','rules'));
		
		$this->Session->write("Location",$id);
      
	}

	function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
			$this->Location->create();
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash(__('The Location has been saved', true));
            $this->log( $this->Auth->user('username') . "; $this->name ; add: " . $this->data['Location']['id'], 'activity');
            $this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Location could not be saved. Please, try again.', true));
            $this->redirect($this->Tracker->loadLastPos());
			}
		}
	}

	function edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Location', true));
			$this->redirect(array('action'=>'start'));
		}
		if (!empty($this->data)) {
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash(__('The Location has been saved', true));
            $this->log( $this->Auth->user('username') . "; $this->name ; edit: " . $this->data['Location']['id'], 'activity');
            $this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Location could not be saved. Please, try again.', true));
            $this->redirect($this->Tracker->loadLastPos());
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Location->read(null, $id);
		}
	}

# implement authentification
# test out if child objects are being deleted
   function delete($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid id for Location', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if ($id == 1) {
         $this->Session->setFlash(__('Location with id 1 is a special location and cannot be deleted.', true));
         $this->log( $this->Auth->user('username') . "; $this->name ; delete: " . $this->data['Location']['id'], 'activity');
         $this->redirect($this->Tracker->loadLastPos());
      }
      if ( $this->Location->User->findCount(array('User.location_id'=>$id)) > 0 ) {
         $this->Session->setFlash(__('Cannot delete; please remove users from this location before', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if ($this->Location->del($id, true)) {
         $this->Session->setFlash(__('Location deleted', true));
         $this->redirect($this->Tracker->loadLastPos());
      }  
   }


}
?>
