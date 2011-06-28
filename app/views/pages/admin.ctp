<div class="admins form">
<h2>Administration</h2>
Below you can find a list of elements you can administer in ProXimus.<br><br>

<div class="actions">
<h3>

<?php
$role = $auth['Role']['name'];

# global admin is logged in 
if ( isset($auth['Admin']) ) {

   if ( $settings['locadmin_manage_users'] == "true" || in_array($role, $priv_roles) ) {
      echo 'Basic Objects:';
      echo "<br>";
      echo $html->link('Users','/admin/users/index',null,null,false);
      echo "<br>";
   }
   if ( in_array($role, $priv_roles) ) {
      echo $html->link('Locations','/admin/locations/index',null,null,false);
      echo "<br>";
   }

   if ( $settings['locadmin_manage_noauth'] == "true" || in_array($role, $priv_roles) ) {
      echo "<br>";
      echo 'Rules:';
      echo "<br>";
      echo $html->link('No-Auth rules','/admin/noauth_rules/index',null,null,false);
      echo "<br>";
   }

   if ( in_array($role, $priv_roles) ) {
      echo $html->link('Blocked networks','/admin/blockednetworks/index',null,null,false);
      echo "<br>";
      echo "<br>";
      echo 'Settings:';
      echo "<br>";
      echo $html->link('Admin accounts','/admin/admins/index',null,null,false);
      echo "<br>";
      echo $html->link('Proxy settings','/admin/proxy_settings/index',null,null,false);
      echo "<br>";
      echo $html->link('Global settings','/admin/global_settings/index',null,null,false);
      echo "<br>";
      echo "<br>";
      echo 'Other:';
      echo "<br>";
      echo $html->link('View eventlog','/admin/eventlogs/index',null,null,false);
      echo "<br>";
   }

   echo "<br>";
   echo "<br>";
   echo $html->link('About ProXimus / Documentation','/pages/about',null,null,false);
}

?>

</h3>
</div>

</div>

