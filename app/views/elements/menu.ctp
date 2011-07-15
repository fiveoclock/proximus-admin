<?php

echo $menu->start();

// if nobody is logged in
if ( empty($auth) ) {
   echo $menu->item('Admin Login', array('admin' => true, 'controller'=>'admins','action'=>'login', null ));
   echo $menu->item('User Login', array('user' => true, 'controller'=>'profiles','action'=>'login', null ));
}

// admin is logged in
if ( isset($auth['Admin']) ) {
   $user = $auth['Admin']['username'];

   echo $menu->item('Locations','/admin/locations/start',null,null,false);
   echo $menu->item('Logs','/admin/logs/searchlist',null,null,false);
   echo $menu->item('Rule Tester','/admin/rules/search',null,null,false);


   // Administration menu
   echo $menu->superItem('Administration','#',null,null,false);

   $role = $auth['Role']['name'];
   if ( $settings['locadmin_manage_users'] == "true" || in_array($role, $priv_roles) ) {
      echo $menu->text(' > Basic Objects ');
      echo $menu->item('Users','/admin/users/index',null,null,false);
   }
   if ( in_array($role, $priv_roles) ) {
      echo $menu->item('Locations','/admin/locations/index',null,null,false);
   }

   if ( $settings['locadmin_manage_noauth'] == "true" || in_array($role, $priv_roles) ) {
      echo $menu->text(' > Rules ');
      echo $menu->item('No-Auth rules','/admin/noauth_rules/index',null,null,false);
   }

   if ( in_array($role, $priv_roles) ) {
      echo $menu->item('Blocked networks','/admin/blockednetworks/index',null,null,false);
      echo $menu->text(' > Settings ');
      echo $menu->item('Admin accounts','/admin/admins/index',null,null,false);
      echo $menu->item('Proxy settings','/admin/proxy_settings/index',null,null,false);
      echo $menu->item('Global settings','/admin/global_settings/index',null,null,false);
      echo $menu->text(' > Other ');
      echo $menu->item('View eventlog','/admin/eventlogs/index',null,null,false);
   }

   echo $menu->item('About ProXimus','/pages/about',null,null,false);

   echo $menu->superItemEnd();


   echo $menu->item($user.'s '.'Profile',array('admin' => true, 'controller'=>'admins','action'=>'view',$auth['Admin']['id']));
   echo $menu->item('Logout','/admin/admins/logout',null,null,false);

}

// user is logged in
if ( isset($auth['User']) ) {
   $user = $auth['User']['username'];

   echo $menu->item('Home','/user/profiles/start',null,null,false);
   echo $menu->item('My logs','/user/profiles/logs',null,null,false);
   echo $menu->item($user.'s '.'Profile',array('user' => true, 'controller'=>'profiles','action'=>'view',$auth['User']['id']));
   echo $menu->item('Logout','/user/profiles/logout',null,null,false);
}

echo $menu->end();

?>
