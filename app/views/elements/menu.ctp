<?php

if ( !isset($auth) ) {
   echo $html->link('Admin Login', array('admin' => true, 'controller'=>'admins','action'=>'login', null ));
   echo $html->link('User Login', array('user' => true, 'controller'=>'profiles','action'=>'login', null ));
}


if ( isset($auth['Admin']) ) {
   # not logged in
   if (!$auth['Admin']['role_id']) {
      #echo $html->link('Login','/',null,null,false);
   }

   # admin logged in
   if ($auth['Admin']['role_id'] >= 1) {
      echo $html->link('Locations','/admin/locations/start',null,null,false);
      echo $html->link('Logs','/admin/logs/searchlist',null,null,false);
      echo $html->link('Rule Tester','/admin/rules/search',null,null,false);
   }

   # global admin is logged in 
   if ( ($auth['Admin']['role_id'] == 1) or ($auth['Admin']['role_id'] == 3) ) {
      echo " | ";
      echo $html->link('Administration','/pages/admin',null,null,false);
   }

   # admin logged in
   if ($auth['Admin']['role_id'] >= 1) {
      $user = $auth['Admin']['username'];
      echo " | ";
      echo $html->link($user.'s '.'Profile',array('admin' => true, 'controller'=>'admins','action'=>'view',$auth['Admin']['id']));
      echo $html->link('Logout','/admin/admins/logout',null,null,false);
      #echo " | ";
      #echo $auth['Admin']['username'];
   }
   #echo $html->link('About','#',null,null,false);
}

if ( isset($auth['User']) ) {
   # not logged in
   $user = $auth['User']['username'];

   echo $html->link('Home','/pages/userstart',null,null,false);
   echo $html->link('My logs','/user/profiles/logs',null,null,false);
   echo " | ";
   echo $html->link($user.'s '.'Profile',array('user' => true, 'controller'=>'profiles','action'=>'view',$auth['User']['id']));
   echo $html->link('Logout','/user/profiles/logout',null,null,false);

}
?>
