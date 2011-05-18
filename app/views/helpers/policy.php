<?php

class PolicyHelper extends AppHelper {

    function getPolicies($god_mode = null) {
      if($god_mode == 2) {    
         $policies =  array('ALLOW'=>'ALLOW','DENY'=>'DENY','LEARN'=>'LEARN','DENY_MAIL'=>'DENY_MAIL');
      } elseif ($god_mode ==1) {
         $policies =  array('ALLOW'=>'ALLOW','DENY'=>'DENY','REDIRECT'=>'REDIRECT','LEARN'=>'LEARN','DENY_MAIL'=>'DENY_MAIL');
      }
         return $policies;
    }
}

?>

