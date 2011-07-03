<div class="logs form">
<?php echo $form->create(null, array('url' => '/admin/logs/searchlist')); ?>
	<fieldset>
      <legend><?php __('View Logs');?></legend>
	<?php
      echo $form->input('location');
      echo $form->input('users', array('label'=>'User (search pattern - part of username or real name)'));
      echo $form->input('site', array('label'=>'Site (search pattern - part of hostname or ip)'));
      echo $form->input('status', array('options' => array(''=>'All', 'USER'=>'Confirmed by user','REDIRECT'=>'Not confirmed yet', 'LEARN'=>'Automatically learned')));
      echo $form->input('type', array('options' => array(''=>'All sites', 'null'=>'Only parent sites','NOT null'=>'Only subsites')));
      echo $form->input('onlyThisLoc', array('label'=>'Show only users from this location', 'type'=>'checkbox'));
	?>
   <?php echo $form->submit('Search',array('name'=>'search'));?>
   <?php echo $form->submit('Delete all', array('name'=>'deleteMatching'));?>
	</fieldset>
</div>

<div class="related">
   <h3><?php __('Logs and dynamically created rules');?></h3>
   <br>
   <?php if (!empty($logs)):?>
   <table>
   <tr>
      <th><?php __('Site'); ?></th>
      <th><?php __('Hits'); ?></th>
      <th><?php __('Protocol'); ?></th>
      <th><?php __('Client IP'); ?></th>
      <th><?php __('Source'); ?></th>
      <th><?php __('User'); ?></th>
      <th><?php __('Created'); ?></th>
      <th class="actions"><?php __('Actions');?></th>
   </tr>
   <?php 
      foreach ($logs as $log):
         # if the log contains a parent, print this first
         if (!empty($log['Parent']['id'])) {
            $parent = $log;
            $parent['Log'] = $log['Parent'];
            printLog($this, $html, $parent);
         }
         
         # print the actual log
         printLog($this, $html, $log);
         //pr($log);
         
         # if the log contains children, print all of them
         if (!empty($log['Child'])):
            for ( $i=0; $i < sizeof($log['Child']); $i++ ) {
               printLog($this, $html, $log, $i);
            }
         endif;
      endforeach; ?>

</table>
<?php endif; ?>

</div>


<?php 

   function printLog($view, &$html, $log, $childIndex=null) {
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
            <td>". $log['User']['username'] ."</td>
            <td>". $l['created'] ."</td>
            <td class=\"actions\">" .
               $html->link(__('Create rule', true), array('controller'=> 'rules', 'action'=>'createFromLog', $l['id'], $view->data['Log']['location'])) . " " .
               $html->link(__('Delete', true), array('controller'=> 'logs', 'action'=>'delete', $l['id'], $view->data['Log']['location']), null, sprintf(__('Are you sure you want to delete # %s?', true), $l['id'])) .
               "
            </td>
         </tr>";
   }

?>


