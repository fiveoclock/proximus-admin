<?php
class EventlogsController extends AppController {
   var $name = 'Eventlogs';
   var $useTable = false;
   var $uses = array();
   var $helpers = array('Html', 'Form');
   /*
    * Lockdown all access to admins
 (this uses my custom method for security,
    *  you'll need to use auth or whatever you prefer to prevent guest or lowly users from access
    */   
   function beforeFilter(){
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }

   function admin_index() {
      if ( ! $this->data ) {
         $this->data['lines'] = 50;
      }
      $file = "../tmp/logs/activity.log";
      $kdf = array_reverse( file($file) );

      foreach ( $kdf as $key=>$line ) {
         if ( $key == $this->data['lines'] ) break;
         if ( empty($line) ) continue;

         $val = explode("Activity: ", $line );
         $logs[$key]['date'] = strtotime( $val[0] );
         $logs[$key]['date'] = $val[0];

         $tmp = explode("; ", $val[1] );
         $logs[$key]['user'] = $tmp[0];
         $logs[$key]['controller'] = $tmp[1];
         $logs[$key]['message'] = $tmp[2];
      }

      $this->set('eventlogs', $logs);
   }

   function admin_delete($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid id', true));
         $this->redirect(array('action'=>'index'));
      }
      if ($this->GlobalSetting->delete($id)) {
         $this->Session->setFlash(__('Setting deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['GlobalSetting']['id'], 'activity');
         $this->redirect(array('action'=>'index'));
      }
   }

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      return false;
   }


}

?>
