<?php
class LogsController extends AppController {
   var $name = 'Logs';
   var $helpers = array('Html', 'Form');
   var $uses = array('Log','Location','User','ProxySetting');

   function beforeFilter() {
      parent::beforeFilter();
   }

   function searchlist() {
      # retrieve data for form fields

      /* # don't really know.......
      if ($this->Session->read('Auth.godmode') != 1) {
         $this->Session->setFlash(__('You are not allowed to access this search method', true));
         $this->redirect(array('action'=>'searchlist'));
      }
      */

      # get proxys / locations
      if($this->Session->read('Auth.godmode') !=1) {
         $allowed_locations = $this->Session->read('Auth.locations');
         $find_conditions = array('Location.id'=>$allowed_locations,
                                 'Location.id NOT' => "1");
      }
      elseif($this->Session->read('Auth.godmode') == 1) {
         $find_conditions = array("Location.id NOT" => "1");
      }

      $locations_list = $this->ProxySetting->find('all',
            array(
               'fields'=>array(
                  'Location.id','Location.code','Location.name','ProxySetting.fqdn_proxy_hostname', 'ProxySetting.id'
                  ),
               'conditions'=>$find_conditions,
               'order'=>array('Location.code')
            )
         );

      $locations = Set::combine(
         $locations_list,
         '{n}.ProxySetting.id',
         array('%s - %s','{n}.Location.code','{n}.ProxySetting.fqdn_proxy_hostname')
      );
      $this->set(compact('locations'));


      ##################
      # If form was submitted
      if (!empty($this->data) && isset($this->data['Log']['location'])) {
         $proxy = $this->ProxySetting->findById($this->data['Log']['location']);
         $this->setDataSource($proxy);


         # build up conditions for query
         if( !empty($this->data['Log']['site'])) {
            $conditions['Log.sitename LIKE'] = '%'.$this->data['Log']['site'].'%';
         }
         if ( !empty($this->data['Log']['onlyThisLoc'])) {
            $conditions['Log.location_id'] = $proxy['ProxySetting']['location_id'];
         }
         if ( !empty($this->data['Log']['users'])) {
            # first get the ids of the matching users
            $user_ids = $this->User->find('all',array('fields'=>'id','conditions'=>array(
                                          'or'=>array(
                                             'User.realname LIKE'=>'%'.$this->data['Log']['users'].'%',
                                             'User.username LIKE'=>'%'.$this->data['Log']['users'].'%'))));
            $user_ids = Set::extract('/User/id', $user_ids);

            $conditions['Log.user_id'] = $user_ids;
         }
         if( empty($this->data['Log']['users']) && empty($this->data['Log']['site']) ) {
            $conditions['Log.parent_id'] = null;
         }

         $tree = $this->Log->find('all',array('conditions'=>$conditions ));
         $this->set('logs',$tree);

         $this->log( $this->Auth->user('username') . "; $this->name; search logs", "activity");
         #pr($conditions);    # debug
      }
   }

   function setDataSource($proxy) {
      //pr($proxy);  # debug
      if ( $proxy['ProxySetting']['db_default'] != 1 ) {
         $serverConfig = array(
            'host' => $proxy['ProxySetting']['db_host'],
            'database' => $proxy['ProxySetting']['db_name'],
            'login' => $proxy['ProxySetting']['db_user'],
            'password' => $proxy['ProxySetting']['db_pass'],
            'datasource' => "default",
         );

         $newDbConfig = $this->dbConnect($serverConfig);
         //pr($newDbConfig);  ## debug
         if ( ! $newDbConfig ) {
            return;
         }
         else {
            //return $newDbConfig['name'];
            $this->Log->useDbConfig = $newDbConfig['name'];
            $this->Log->cacheQueries = false;
            #pr($newDbConfig);
         }
      }
   }

   /**
    * Connects to specified database
    *
    * @param array $config Server config to use {datasource:?, database:?}
    * @return array db->config on success, false on failure
    * @access public
    */
   function dbConnect($config = array()) {
      ClassRegistry::init('ConnectionManager');

      $nds = $config['datasource'] . '_' . $config['host'];
      $db =& ConnectionManager::getDataSource($config['datasource']);
      #$db->setConfig(array('name' => $nds, 'database' => $config['database'], 'persistent' => false));
      $db->setConfig(array('name' => $nds, 
         'host' => $config['host'], 
         'database' => $config['database'], 
         'login' => $config['login'], 
         'password' => $config['password'], 
         'persistent' => false
      ));
      if ( ( $ds = ConnectionManager::create($nds, $db->config) ) && $db->connect() ) return $db->config;
      return false;
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

	function delete($id = null, $proxy_id = null) {
		if (!$id || !$proxy_id) {
			$this->Session->setFlash(__('Invalid id for Log', true));
			$this->redirect(array('action'=>'searchlist'));
      }
      $proxy = $this->ProxySetting->findById($proxy_id);
      pr($proxy);
      $this->setDataSource($proxy);

      $log = $this->Log->read(null, $id);
      if ($this->Session->read('Auth.godmode') != 1) {
         if (!in_array($log['Log']['location_id'],$this->Session->read('Auth.locations'))) {
            $this->Session->setFlash(__('You are not allowed to access this Log', true));
			   $this->redirect(array('action'=>'searchlist'));
         }
      }

		if ($this->Log->delete($id)) {
         $this->log( $this->Auth->user('username') . "; $this->name; delete: " . $this->data['Log']['id'], 'activity');
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
         $this->log( $this->Auth->user('username') . "; $this->name; delete with subsites: " . $this->data['Log']['id'], 'activity');
         $this->Log->deleteAll($condition);
      }
		if ($this->Log->del($id)) {
			$this->Session->setFlash(__('Log deleted', true));
         $this->log( $this->Auth->user('username') . "; $this->name; delete with subsites: " . $this->data['Log']['id'], 'activity');
			$this->redirect(array('action'=>'searchlist'));
		}
      else {
         $this->Session->setFlash(__('Log or Log children could not be deleted, please inform your admin', true));
      }
   }
}
?>
