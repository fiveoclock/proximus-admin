<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');

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

#	function index() {
#		$this->Group->recursive = 0;
#		$this->set('groups', $this->paginate());
#		$this->set('group', $this->Group->read(null, $id));
#	}

	function view($id = null) {
      if (!$id) {
			$this->Session->setFlash(__('Invalid Group.', true));
         $this->redirect(array('controller'=>'locations','action'=>'start'));
		}
      $group = $this->Group->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($group['Group']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Group', true));
            $this->redirect(array('controller'=>'locations','action'=>'start'));
         }
      }
		$this->set('group', $group);
		$this->Session->write("Group",$id);
	}

	function view_old($id = null) {
      if (!$id) {
			$this->Session->setFlash(__('Invalid Group.', true));
         $this->redirect(array('controller'=>'locations','action'=>'start'));
		}
      $group = $this->Group->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($group['Group']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Group', true));
            $this->redirect(array('controller'=>'locations','action'=>'start'));
         }
      }
		$this->set('group', $group);
		$this->Session->write("Group",$id);
	}

	function add($location_id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
			$this->Group->create();
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash(__('The Group has been saved', true));
            $this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.', true));
            $this->redirect($this->Tracker->loadLastPos());
			}
		}
      if(!is_null($location_id)) {
         if ($this->Session->read('Auth.godmode') != 1) {
            if (!in_array($location_id,$this->Session->read('Auth.locations'))) {
               $this->Session->setFlash(__('You are not allowed to add Groups to this Location', true));
               $this->redirect($this->Tracker->loadLastPos());
             }
         }
         $this->data['Group']['location_id'] = $location_id;
      } else {
         $this->Session->setFlash(__('Unknown location_id, please choose valid location!', true));
         $this->redirect(array('controller'=>'locations','action'=>'start'));
      }

	}

	function edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Group', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
      $group = $this->Group->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
          if (!in_array($group['Group']['location_id'],$this->Session->read('Auth.locations'))) {
             $this->Session->setFlash(__('You are not allowed to access this Group', true));
             $this->redirect($this->Tracker->loadLastPos());
          }
      }
		if (!empty($this->data)) {
			if ($this->Group->save($this->data)) {
				
				$group_users = $this->Group->User->find('list',array(
							'conditions'=>array('User.group_id'=>$this->data['Group']['id']),
							'recursive'=>-1,
							));
				foreach ($group_users as $group_user_id) {
					$this->Group->User->id = $group_user_id;
					$this->Group->User->saveField('group_id',0);
				}
				
				$this->Group->User->recursive = -1;
            if(!empty($this->data['Group']['User'])) {
				   foreach ($this->data['Group']['User'] as $user_id ) {
					   $this->Group->User->id = $user_id;
					   $this->Group->User->saveField('group_id',$this->data['Group']['id']);
				   }
				}
				$this->Session->setFlash(__('The Group has been saved', true));
				
				$this->redirect($this->Tracker->loadLastPos());
			} else {
			}
		}
		
		if (empty($this->data)) {
			$this->data = $this->Group->read(null, $id);
		}
		#filter to selected one location, session variable is set in LocationsController->view
		$locations = $this->Group->Location->find('list',array('conditions'=>array('Location.id'=>$this->Session->read("Location"))));

		$users_all = $this->Group->User->find('all',array(
						'fields'=>array('User.id','User.username','User.realname'),
						'recursive'=>-1,
						'conditions'=>array(
								'User.location_id'=>$this->Session->read("Location"),
								'or'=>array(
									'User.group_id'=>array(0,$this->Session->read("Group")))),
						'order'=>array(
							'User.group_id DESC',
							'User.realname')));
		# convert array
		$users = Set::combine(
			$users_all,
			'{n}.User.id',
			array('%s (%s)','{n}.User.realname','{n}.User.username')
			);
		
		$camefrom = $this->Session->read('PrevPos.Controller');
		$this->set(compact('locations','users','camefrom'));
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group', true));
			$this->redirect($this->Tracker->loadLastPos());
      }
      $group = $this->Group->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($group['Group']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Group', true));
            $this->redirect($this->Tracker->loadLastPos());
         }
		}

      if (($this->Group->Rule->findCount(array('Rule.group_id'=>$id))) > 0 || 
          ($this->Group->User->findCount(array('User.group_id'=>$id))) > 0 ) {
            $this->Session->setFlash(__('Group is not empty, cannot delete', true));
            $this->redirect($this->Tracker->loadLastPos());
      }
		if ($this->Group->del($id)) {
			$this->Session->setFlash(__('Group deleted', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
	}
}
?>
