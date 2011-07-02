<?php

class TrackerComponent extends Object {

   var $components = array('Session');

   function initialize(&$controller, $settings = array()) {
      // saving the controller reference for later use
      $this->controller =& $controller;
   }
 
   function savePosition($controller = null, $action = null, $params = null) {
      #let only numeric values into session
      $id = null;
      if( isset($params[0]) ) {
         $id = $params[0];
      }
      if(!is_numeric($id)) {
         $id = null;
      }

      $this->Session->write('Auth.prevController',$controller);
      $this->Session->write('Auth.prevAction',$action);
      $this->Session->write('Auth.prevId',$id);
      $this->log( "$controller/$action/$id", 'debug');
   }

   function lastPos() {
      $redirectURL = array();
      $redirectURL['controller'] = $this->Session->read('Auth.prevController');
      $redirectURL['action'] = $this->Session->read('Auth.prevAction');
      if(!is_null($this->Session->read('Auth.prevId'))) {
         $redirectURL['0'] = $this->Session->read('Auth.prevId');
      }
      return $redirectURL;
   }
   
   function back() {
      $this->controller->redirect( $this->lastPos() ); 
   }

}
?>
