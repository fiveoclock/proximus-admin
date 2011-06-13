<div class="admins form">
<h2>Administration</h2>
Below you can find a list of elements you can administer in ProXimus.<br><br>

<div class="actions">

<h3>

<?php
# global admin is logged in 
if ($auth['Admin']['role_id'] == 1) {
   echo 'Basic Objects:';
   echo "<br>";
   echo $html->link('Locations','/locations/index',null,null,false);
   echo "<br>";
   echo $html->link('Users','/users/index',null,null,false);
   echo "<br>";
   echo "<br>";
   echo 'Rules:';
   echo "<br>";
   echo $html->link('No-Auth rules','/noauth_rules/index',null,null,false);
   echo "<br>";
   echo $html->link('Blocked networks','/blockednetworks/index',null,null,false);
   echo "<br>";
   echo "<br>";
   echo 'Settings:';
   echo "<br>";
   echo $html->link('Admin accounts','/admins/index',null,null,false);
   echo "<br>";
   echo $html->link('Proxy settings','/proxy_settings/index',null,null,false);
   echo "<br>";
   echo $html->link('Global settings','/global_settings/index',null,null,false);
   echo "<br>";
   echo "<br>";
   echo 'Other:';
   echo "<br>";
   echo $html->link('View eventlog','/eventlogs/index',null,null,false);
   echo "<br>";
   echo "<br>";
   echo "<br>";
   echo $html->link('About ProXimus / Documentation','/pages/about',null,null,false);
}

?>

</h3>

</div>

</div>

