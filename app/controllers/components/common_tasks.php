<?php

class CommonTasksComponent extends Object {

   var $components = array('Session');

   function initialize(&$controller, $settings = array()) {
      // saving the controller reference for later use
      $this->controller =& $controller;
   }
 
   function setLocationsList($loc1=false, $all=false ) {
      $user =  $this->Session->read('User');

      $conditions = array();
      if ( ! $loc1 ) $conditions['Location.id NOT'] = "1";

      # get proxys / locations
      if( ! in_array($user['Role']['name'], $this->controller->priv_roles) ) {
         $allowed_locations = $this->controller->getAdminLocationIds();
         $conditions['Location.id'] = $allowed_locations;
      }
      
      $this->controller->loadModel('Location');
      $Location =& new Location();
      
      $locations_all = $Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>$conditions,
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->controller->set(compact('locations'));
   }
 

   function getGlobalSettings() {
      $Setting  = ClassRegistry::init('GlobalSetting');
      foreach( $Setting->find('all') as $key=>$value ){
         $content = $value['GlobalSetting'];
         $settings[ $content['name'] ] = $content['value'] ; 
      }
      return $settings;
   }


   function setDataSource($proxy) {
      //pr($proxy);  # debug
      $Setting  = ClassRegistry::init('ProxySetting');
      if ( $proxy['ProxySetting']['db_default'] != 1 ) {
         // if db_host is not defined use the fqdn of the proxy
         if ( empty( $proxy['ProxySetting']['db_host'] ) ) {
            $proxy['ProxySetting']['db_host'] = $proxy['ProxySetting']['fqdn_proxy_hostname'];
         }

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
            $this->controller->ModelName->useDbConfig = $newDbConfig['name'];
            $this->controller->ModelName->cacheQueries = false;
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

}
?>
