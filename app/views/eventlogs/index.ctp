<div class="eventlog index">
<h2><?php __('Eventlog');?></h2>
<table cellpadding="0" cellspacing="0">
<br>
<tr>
   <th>Date</th>
   <th>User</th>
   <th>Controller</th>
   <th>Message</th>
</tr>

<?php
$i = 0;
foreach ($eventlogs as $log):
   $class = null;
   if ($i++ % 2 == 0) {
      $class = ' class="altrow"';
   }
   echo "<tr $class>";
   echo "<td>".$log['date']."</td>";
   echo "<td>".$log['user']."</td>";
   echo "<td>".$log['controller']."</td>";
   echo "<td>".$log['message']."</td>";
   echo "</tr>";

endforeach; ?>
</table>
</div>

<p>


