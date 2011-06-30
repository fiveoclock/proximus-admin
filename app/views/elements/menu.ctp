<?php

// if nobody is logged in
if ( empty($auth) ) {
   echo $html->link('Admin Login', array('admin' => true, 'controller'=>'admins','action'=>'login', null ));
   echo $html->link('User Login', array('user' => true, 'controller'=>'profiles','action'=>'login', null ));
}

// admin is logged in
if ( isset($auth['Admin']) ) {
   $user = $auth['Admin']['username'];

   echo $html->link('Locations','/admin/locations/start',null,null,false);
   echo $html->link('Logs','/admin/logs/searchlist',null,null,false);
   echo $html->link('Rule Tester','/admin/rules/search',null,null,false);

   echo " | ";
   echo $html->link('Administration','/pages/admin',null,null,false);

   echo " | ";
   echo $html->link($user.'s '.'Profile',array('admin' => true, 'controller'=>'admins','action'=>'view',$auth['Admin']['id']));
   echo $html->link('Logout','/admin/admins/logout',null,null,false);
}

// user is logged in
if ( isset($auth['User']) ) {
   $user = $auth['User']['username'];

   echo $html->link('Home','/user/profiles/start',null,null,false);
   echo $html->link('My logs','/user/profiles/logs',null,null,false);
   echo " | ";
   echo $html->link($user.'s '.'Profile',array('user' => true, 'controller'=>'profiles','action'=>'view',$auth['User']['id']));
   echo $html->link('Logout','/user/profiles/logout',null,null,false);
}
?>
