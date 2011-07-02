<div class="profiles form">
<?php echo $form->create(null, array('url' => $this->Html->url(array('user' => true, 'controller'=>'profiles', 'action'=>'logs'), true)) ); ?>
	<fieldset>
      <legend><?php __('Search for your logs');?></legend>
	<?php
      echo $form->hidden('location');
      echo $form->input('site', array('label'=>'Site (search pattern - part of hostname or IP)'));
      echo $form->input('status', array('options' => array(''=>'All', 'USER'=>'Confirmed by user','REDIRECT'=>'Not confirmed yet', 'LEARN'=>'Automatically learned')));
      echo $form->input('type', array('options' => array(''=>'All sites', 'null'=>'Only parent sites','NOT null'=>'Only subsites')));
	?>
   <?php echo $form->submit('Show',array('name'=>'search'));?>
   <?php echo $form->submit('Delete all', array('name'=>'deleteMatching'));?>
	</fieldset>
</div>

<br>
<div class="related">
   <h3><?php __('Logs and dynamically created rules');?></h3>
   <?php if (!empty($logs)):?>
   <table cellpadding = "0" cellspacing = "0">
   <tr>
      <th><?php __('Site'); ?></th>
      <th><?php __('Hits'); ?></th>
      <th><?php __('Protocol'); ?></th>
      <th><?php __('Client IP'); ?></th>
      <th><?php __('Source'); ?></th>
      <th><?php __('Created'); ?></th>
      <th class="actions"><?php __('Actions');?></th>
   </tr>
   <?php 
      foreach ($logs as $log):
         # if the log contains a parent, print this first
         if (!empty($log['Parent']['id'])) {
            $parent = $log;
            $parent['Log'] = $log['Parent'];
            printLog($proxy, $html, $parent);
         }
         
         # print the actual log
         printLog($proxy, $html, $log);
         //pr($log);
         
         # if the log contains children, print all of them
         if (!empty($log['Child'])):
            for ( $i=0; $i < sizeof($log['Child']); $i++ ) {
               printLog($proxy, $html, $log, $i);
            }
         endif;
      endforeach; ?>

</table>
<?php endif; ?>

</div>


<?php 

   function printLog($proxy, &$html, $log, $childIndex=null) {
      if ( is_null($childIndex) ) {
         $class = "parent";
         $l = $log['Log'];
         if ( !empty($log['Log']['parent_id'])) {
            $class = "child";
         } 
      }
      else {
         $class = "child";
         $l = $log['Child'][$childIndex];
      }

      echo "
         <tr>
            <td class=\"$class\">". $l['sitename'] ."</td>
            <td>". $l['hitcount'] ."</td>
            <td>". $l['protocol'] ."</td>
            <td>". $l['ipaddress'] ."</td>
            <td>". $l['source'] ."</td>
            <td>". $l['created'] ."</td>
            <td class=\"actions\">" .
               $html->link(__('Confirm', true), array('controller'=> 'profiles', 'action'=>'confirmlog', $l['id'], $proxy['ProxySetting']['id'])) . " " .
               $html->link(__('Delete', true), array('controller'=> 'profiles', 'action'=>'deletelog', $l['id'], $proxy['ProxySetting']['id'] ), null, sprintf(__('Are you sure you want to delete # %s?', true), $l['id'])) .
               "
            </td>
         </tr>";
   }

?>


