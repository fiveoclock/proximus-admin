<div class="eventlog index">
<h2><?php __('Eventlog');?></h2>

<div class="eventlogs form">
<?php echo $form->create(null, array('url' => '/eventlogs/index')); ?>
   <fieldset>
      <legend><?php __('View Logs');?></legend>
   <?php
      echo $form->input('lines', array('label' => 'Lines to show', 'options' => array('50' => '50', '100'=>'100','200'=>'200','-1'=>'All')));
   ?>
   <?php echo $form->end('Show');?>
   </fieldset>
</div>

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


