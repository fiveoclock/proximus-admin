<?php
class LogsController extends AppController {
   var $name = 'Logs';
   var $helpers = array('Html', 'Form');
   var $uses = array('Log','Location','User','ProxySetting');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_searchlist');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }

   function admin_searchlist() {
      /* # don't really know.......
      if ($this->Session->read('Auth.godmode') != 1) {
         $this->Session->setFlash(__('You are not allowed to access this search method', true));
         $this->Tracker->back();
      }
      */
      $user = parent::getUser();

      # get proxys / locations
      if( $user['Role']['name'] == "admin_global" ) {
         $find_conditions = array("Location.id NOT" => "1");
      }
      else {
         $allowed_locations = parent::getAdminLocationIds();
         $find_conditions = array('Location.id'=>$allowed_locations,
                                 'Location.id NOT' => "1");
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

         // check permissions
         if ( ! parent::checkSecurity( $proxy['ProxySetting']['location_id'] ) ) $this->Tracker->back();

         // use correct datasource
         $this->setDataSource($proxy);

         # build up conditions for query
         $conditions = array();
         if( !empty($this->data['Log']['site'])) {
            $conditions['Log.sitename LIKE'] = '%'.$this->data['Log']['site'].'%';
         }
         if ( !empty($this->data['Log']['onlyThisLoc'])) {
            $conditions['Log.location_id'] = $proxy['ProxySetting']['location_id'];
         }
         if ( !empty($this->data['Log']['status'])) {
            $conditions['Log.source'] = $this->data['Log']['status'];
         }
         if ( !empty($this->data['Log']['type'])) {
            if ( $this->data['Log']['type'] == "NOT null" ) array_push($conditions, array("not" => array ( "Log.parent_id" => null) ) );
            if ( $this->data['Log']['type'] == "null" ) $conditions['Log.parent_id'] = null;
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
         // set parrent id to avoid double entries...
         if( empty($this->data['Log']['users']) && empty($this->data['Log']['site']) && empty($this->data['Log']['type']) ) {
            $conditions['Log.parent_id'] = null;
         }

         // delete if requested...
         if ( isset($this->params['form']['deleteMatching']) ) {
            $this->Log->deleteAll($conditions);
         }

         // do a search 
         $tree = $this->Log->find('all',array('conditions'=>$conditions ));
         $this->set('logs',$tree);

         $this->log( $this->MyAuth->user('username') . "; $this->name; search logs", "activity");
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

	function admin_index() {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Log.', true));
			$this->Tracker->back();
		}
		$this->set('log', $this->Log->read(null, $id));
	}

	function admin_delete($id = null, $proxy_id = null) {
		if (!$id || !$proxy_id) {
			$this->Session->setFlash(__('Invalid id for Log', true));
			$this->Tracker->back();
      }
      $proxy = $this->ProxySetting->findById($proxy_id);
      //pr($proxy);
      $this->setDataSource($proxy);

		if ($this->Log->delete($id)) {
         $this->log( $this->MyAuth->user('username') . "; $this->name; delete: " . $this->data['Log']['id'], 'activity');
			$this->Session->setFlash(__('Log deleted', true));
		   $this->Tracker->back();
		}
	}


   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      $locs = parent::getAdminLocationIds();

      if ( in_array($this->action, array('admin_delete', 'admin_view' ) )) {
         $log = $this->Log->read(null, $this->passedArgs['0'] );
         $locId = $log['Location']['id'];

         if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         return true;
      }

      if ( in_array($this->action, array('admin_searchlist' ) )) {
         if ( isset($this->data) ) {
            $proxy = $this->ProxySetting->read(null, $this->data['Log']['location'] );
            $locId = $proxy['Location']['id'];

            if ( ! parent::checkSecurity( $locId)) $this->Tracker->back();
         }
         return true;
      }

      return false;
   }

}
?>
