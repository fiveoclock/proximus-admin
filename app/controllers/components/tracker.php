<?php

class TrackerComponent extends Object {

   var $components = array('Session');

   function initialize(&$controller, $settings = array()) {
      // saving the controller reference for later use
      $this->controller =& $controller;
   }
  
 
   function savePosition($controller = null, $action = null, $id = null) {
      #let only numeric values into session
      if(!is_numeric($id)) {
         $id = null;
      }
      $this->Session->write('Auth.prevController',$controller);
      $this->Session->write('Auth.prevAction',$action);
      $this->Session->write('Auth.prevId',$id);
   }

# does not work   
#   function redirectBack() {
#      if(is_null($this->Session->read('Auth.prevId'))) {
#         $this->redirect(array('controller'=>$this->Session->read('Auth.prevController'),
#                            'action'=>$this->Session->read('Auth.prevAction')));
#      } else {
#         $this->redirect(array('controller'=>$this->Session->read('Auth.prevController'),
#                            'action'=>$this->Session->read('Auth.prevAction'),
#                            $this->Session->read('PrevPos.Id')));
#      }
#   }
   
   function loadLastPos() {
      $redirectURL = array();
      $redirectURL['controller'] = $this->Session->read('Auth.prevController');
      $redirectURL['action'] = $this->Session->read('Auth.prevAction');
      if(!is_null($this->Session->read('Auth.prevId'))) {
         $redirectURL['0'] = $this->Session->read('Auth.prevId');
      }
      return $redirectURL;
   }
}
?>
