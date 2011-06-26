<?php
class EventlogsController extends AppController {
   var $name = 'Eventlogs';
   var $useTable = false;
   var $uses = array();
   var $helpers = array('Html', 'Form');

   function beforeFilter(){
      parent::beforeFilter();
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

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      return false;
   }

}

?>
