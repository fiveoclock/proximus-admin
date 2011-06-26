<?php
class GroupsController extends AppController {

	var $name = 'Groups';
	var $helpers = array('Html', 'Form');

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_view');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }  

	function admin_view($id = null) {
      if (!$id) {
			$this->Session->setFlash(__('Invalid Group.', true));
         $this->Tracker->back();
		}
      $group = $this->Group->read(null, $id);
		$this->set('group', $group);
		$this->Session->write("Group",$id);
	}

	function admin_add($location_id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      // form was submitted
		if (!empty($this->data)) {
         // check security
         if ( ! parent::checkSecurity( $this->data[ $this->modelClass ][ 'location_id' ] )) $this->Tracker->back();

			$this->Group->create();
			if ($this->Group->save($this->data)) {
				$this->Session->setFlash(__('The Group has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['Group']['id'], 'activity');
			}
         else {
				$this->Session->setFlash(__('The Group could not be saved. Please, try again.', true));
			}
         $this->Tracker->back();
		}
      // form was not submitted yet
      if(!is_null($location_id)) {
         if ( ! parent::checkSecurity( $location_id )) $this->Tracker->back();
         $this->data['Group']['location_id'] = $location_id;
      }
      else {
         $this->Session->setFlash(__('Unknown location_id, please choose valid location!', true));
         $this->Tracker->back();
      }
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Group', true));
         $this->Tracker->back();
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
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['Group']['id'], 'activity');
				
            $this->Tracker->back();
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
	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Group', true));
         $this->Tracker->back();
      }
      if ( $this->Group->User->find('count', array('conditions'=>array('User.group_id'=>$id))) > 0 ) {
         $this->Session->setFlash(__('Group is not empty, cannot delete', true));
         $this->Tracker->back();
      }
		if ($this->Group->delete($id, true)) {
			$this->Session->setFlash(__('Group deleted', true));
         $this->Tracker->back();
		}
	}


   function isAuthorized($id = null) {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      if ( in_array($this->action, array('admin_view', 'admin_edit', 'admin_delete') )) {
         $group = $this->Group->read(null, $this->passedArgs['0'] );
         $locId = $group['Location']['id'];

         if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         return true;
      }

      if ( in_array($this->action, array('admin_add') )) {
         // security check in function
         return true;
      }

      return false;
   }

}
?>
