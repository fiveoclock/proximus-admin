<?php
class LocationsController extends AppController {

	var $name = 'Locations';
	var $helpers = array('Html', 'Form');
	var $actsAs = array('Containable');

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('view');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }  

# Not in use
#	function index() {
#		$this->Location->recursive = 0;
#		$this->set('locations', $this->paginate());
#      $this->set('locations', $this->paginate(null, array('Location.id'=>$this->Session->read('Auth.locations'))));
#	}
	
	function start() {
      $loggeduser = $this->Auth->user();
      $allowed_locations = $this->Session->read('Auth.locations');
      
      if($this->Session->read('Auth.godmode') !=1) {
         $find_condition = array('fields' => array('Location.*'),
                              'conditions'=>array('Location.id'=>$allowed_locations),
                              'order'=>'Location.code'
                               );
      }
      elseif($this->Session->read('Auth.godmode') == 1) {
         $find_condition = array('fields' => array('Location.*'),
                              'order'=>'Location.code'
                               );
      }

      $locations = $this->Location->find('all',$find_condition);
      $this->set('locations', $locations);
   }

	function view($id = null) {
      $loggeduser = $this->Auth->user();

      if (!$id) {
			$this->Session->setFlash(__('Invalid Location.', true));
			$this->redirect(array('action'=>'start'));
		}
      if ($this->Session->read('Auth.godmode') != 1) {
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
				#$this->redirect(array('action'=>'index'));
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
#	function delete($id = null) {
#		if (!$id) {
#			$this->Session->setFlash(__('Invalid id for Location', true));
#         #$this->redirect(array('action'=>'view',$this->data['Location']['id']));
#         $this->redirect($this->Tracker->loadLastPos());
#		}
#		if ($this->Location->del($id)) {
#			$this->Session->setFlash(__('Location deleted', true));
#         #$this->redirect(array('action'=>'view',$this->data['Location']['id']));
#         $this->redirect($this->Tracker->loadLastPos());
#		}
#	}

}
?>
