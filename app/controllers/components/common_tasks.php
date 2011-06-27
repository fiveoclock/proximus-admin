<?php

class CommonTasksComponent extends Object {

   var $components = array('Session');

   function initialize(&$controller, $settings = array()) {
      // saving the controller reference for later use
      $this->controller =& $controller;
   }
 
   function setLocationsList($loc1=false, $all=false ) {
      $conditions = null;
      if ( ! $loc1 ) $conditions = array("Location.id NOT" => "1");
      
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
   
   function back() {
      $this->controller->redirect( $this->loadLastPos() ); 
   }

   function getGlobalSettings() {
      $Setting  = ClassRegistry::init('GlobalSetting');
      foreach( $Setting->find('all') as $key=>$value ){
         $content = $value['GlobalSetting'];
         $settings[ $content['name'] ] = $content['value'] ; 
      }
      return $settings;
   }
}
?>
