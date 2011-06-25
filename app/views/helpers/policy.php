<?php

class PolicyHelper extends AppHelper {

   function getPolicies($role = null) {
      if($role == "admin_global") {    
         $policies =  array('ALLOW'=>'ALLOW','DENY'=>'DENY','REDIRECT'=>'REDIRECT','LEARN'=>'LEARN','DENY_MAIL'=>'DENY_MAIL');
      } 
      else {
         $policies =  array('ALLOW'=>'ALLOW','DENY'=>'DENY','LEARN'=>'LEARN','DENY_MAIL'=>'DENY_MAIL');
      }
      return $policies;
   }
}

?>

