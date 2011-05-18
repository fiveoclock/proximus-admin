<?php

# not logged in
if (!$auth['Admin']['role_id']) {
   #echo $html->link('Login','/',null,null,false);
}

# admin logged in
if ($auth['Admin']['role_id'] >= 1) {
   echo $html->link('Locations','/',null,null,false);
   echo $html->link('Logs','/logs/searchlist',null,null,false);
   echo $html->link('Rule Tester','/rules/search',null,null,false);
}

# global admin is logged in 
if ($auth['Admin']['role_id'] == 1) {
   echo " | ";
   echo $html->link('No Auth.','/noauth_rules/index',null,null,false);
   echo $html->link('B. Networks','/blockednetworks/index',null,null,false);
#   echo $html->link('Users','/users/index',null,null,false);
   echo $html->link('Admins','/admins/index',null,null,false);
}

# admin logged in
if ($auth['Admin']['role_id'] >= 1) {
   $user = $auth['Admin']['username'];
   echo " | ";
   echo $html->link($user.'\'s '.'Profile',array('controller'=>'admins','action'=>'changePassword',$auth['Admin']['id']));
   echo $html->link('Logout','/admins/logout',null,null,false);
   #echo " | ";
   #echo $auth['Admin']['username'];
}
#echo $html->link('About','#',null,null,false);
#echo $auth['Admin']['role_id'];

#pr($auth);
?>
