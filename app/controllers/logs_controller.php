<?php
class LogsController extends AppController {
   var $name = 'Logs';
   var $helpers = array('Html', 'Form');
   var $uses = array('Log','Location','User','ProxySetting');

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }


   function searchlist() {
      # retrieve data for form fields

      /* # don't really know.......
      if ($this->Session->read('Auth.godmode') != 1) {
         $this->Session->setFlash(__('You are not allowed to access this search method', true));
         $this->redirect(array('action'=>'searchlist'));
      }
      */


      /* # not used right now
      # get users
      if($this->Session->read('Auth.godmode') !=1) {
         $allowed_locations = $this->Session->read('Auth.locations');
         $users = $this->User->find('all',array('fields'=>array('id','username','realname'),
                                   'conditions'=>array('User.location_id'=>$allowed_locations),
                                   'order'=>array('realname')));
      }
      elseif($this->Session->read('Auth.godmode') == 1) {
         $users = $this->User->find('all',array('fields'=>array('id','username','realname'),
                                   'order'=>array('realname')));
      }
      $users_list = Set::combine($users,'{n}.User.id',array('%s (%s)',"{n}.User.realname","{n}.User.username"));
      $this->set('users',$users_list);
      */

      # get locations      
      if($this->Session->read('Auth.godmode') !=1) {
         $allowed_locations = $this->Session->read('Auth.locations');
         $find_condition = array('fields' => array('Location.*'),
                              'conditions'=>array('Location.id'=>$allowed_locations),
                              'order'=>'Location.code' );
      }
      elseif($this->Session->read('Auth.godmode') == 1) {
         $find_condition = array('fields' => array('Location.*'), 'order'=>'Location.code' );
      }

      $locations_list = $this->Location->find('all',$find_condition);
      $locations = Set::combine(
         $locations_list,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));


      ##################
      # If form was submitted
      if (!empty($this->data) && isset($this->data['Log']['location'])) {
         $location = $this->Location->findById($this->data['Log']['location']);

         # test if a datasource for this location exists..
         $dbConnectionObjects = ConnectionManager::enumConnectionObjects();
         $dbSource = $location['Location']['code'];
         if ($dbConnectionObjects[$dbSource] == null ) {
            $this->Session->setFlash(__('This location does not have a datasource defined yet.', true));
            return;
         }

         $this->Log->useDbConfig = $dbSource;

         # If only location in form has been choosen
         if(isset($this->data['Log']['location']) && empty($this->data['Log']['users'])) {
            $user_ids = $this->User->find('all',array('fields'=>'id','conditions'=>array('User.location_id'=>$this->Session->read('Auth.locations'))));
            $user_ids = Set::extract('/User/id', $user_ids);
            $tree = $this->Log->find('all',array('conditions'=>array(
                                                'parent_id'=>null,
                                                'location_id'=>$this->data['Log']['location']
            )));
         }

         # If location and user in form have been choosen
         elseif (isset($this->data['Log']['location']) && isset($this->data['Log']['users'])) {
            # first get the ids of the matching users
            $user_ids = $this->User->find('all',array('fields'=>'id','conditions'=>array(
                                          'or'=>array(
                                             'User.realname LIKE'=>'%'.$this->data['Log']['users'].'%',
                                             'User.username LIKE'=>'%'.$this->data['Log']['users'].'%'))));
            $user_ids = Set::extract('/User/id', $user_ids);

            # then get the the logs
            $tree = $this->Log->find('all',array('conditions'=>array(
                                                'parent_id'=>null,
                                                'user_id'=>$user_ids
            )));
         }
         $this->set('logs',$tree);
      }

      /**
         # get all locations over proxysetting table in order to get only existing locations
         $locations = $this->ProxySetting->find('all',array('fields'=>array('Location.id','Location.code'),
                                      'conditions'=>array('Location.id'=>$this->Session->read('Auth.locations')),
                                      'order'=>array('Location.code')));
         $locations_list = Set::combine($locations,'{n}.Location.id','{n}.Location.code');
      **/
   }

	function index() {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Log.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('log', $this->Log->read(null, $id));
	}

	function delete($id = null, $loc_id = null) {
		if (!$id || !$loc_id) {
			$this->Session->setFlash(__('Invalid id or loc_id for Log', true));
			$this->redirect(array('action'=>'searchlist'));
      }
      $location = $this->Location->findById($loc_id);
      # connect Log model the correct DB
      $this->Log->useDbConfig = $location['Location']['code'];
      $log = $this->Log->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($log['Log']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Log', true));
			   $this->redirect(array('action'=>'searchlist'));
         }
      }

		if ($this->Log->del($id)) {
			$this->Session->setFlash(__('Log deleted', true));
		   $this->redirect(array('action'=>'searchlist'));
		}
   
	}

	function deleteWithChildren($id = null,$loc_id = null) {
		if (!$id || !$loc_id) {
			$this->Session->setFlash(__('Invalid id for Log', true));
			$this->redirect(array('action'=>'searchlist'));
      }
      $location = $this->Location->findById($loc_id);
      # connect Log model the correct DB
      $this->Log->useDbConfig = $location['Location']['code'];

      $log = $this->Log->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($log['Log']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Log', true));
			   $this->redirect(array('action'=>'searchlist'));
         }
      }
		
      $children = $this->Log->findByParentId($id);
      if (!empty($children)) {
         $condition = array('parent_id'=>$id);
         $this->Log->deleteAll($condition);
      }
		if ($this->Log->del($id)) {
			$this->Session->setFlash(__('Log deleted', true));
			$this->redirect(array('action'=>'searchlist'));
		}
      else {
         $this->Session->setFlash(__('Log or Log children could not be deleted, please inform your admin', true));
      }
   }
}
?>
