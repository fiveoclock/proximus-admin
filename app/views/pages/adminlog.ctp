<div class="admins form">
<h2>Admin log</h2>
Below you can find a list of elements you can administer in ProXimus.<br><br>

<div class="actions">

<h3>

<?php



# global admin is logged in 
if ($auth['Admin']['role_id'] == 1) {
   echo 'Admin log:';
   echo "<br>";

   $file = "../tmp/logs/activity.log";
   $kdf = file_get_contents($file);
   $kdf = explode("\n", $kdf);
   $logs = array();
   foreach ( array_reverse($kdf, true) as $key=>$line ) {
      if ( empty($line)) continue;

      $val = explode("Activity: ", $line );
      $logs[$key]['date'] = strtotime( $val[0] );
      $logs[$key]['date'] = $val[0];

      $tmp = explode("; ", $val[1] );
      $logs[$key]['user'] = $tmp[0];
      $logs[$key]['controller'] = $tmp[1];
      $logs[$key]['message'] = $tmp[2];
   }
   #pr($logs);
}



?>
<table cellpadding="0" cellspacing="0">
<tr>
   <th>Date</th>
   <th>User</th>
   <th>Controller</th>
   <th>Message</th>
</tr>
<?php

foreach ( $logs as $log) {
   echo "<tr>";
   echo "<td>".$log['date']."</td>";
   echo "<td>".$log['user']."</td>";
   echo "<td>".$log['controller']."</td>";
   echo "<td>".$log['message']."</td>";
   echo "</tr>";
}

?>

</table>
</h3>

</div>

</div>

