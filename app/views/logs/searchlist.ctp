<div class="logs form">
<?php echo $form->create(null, array('url' => '/logs/searchlist')); ?>
	<fieldset>
      <legend><?php __('View Logs');?></legend>
	<?php
      echo $form->input('location');
      echo $form->input('users',array('label'=>'User (search pattern - part of username or real name)'));
	?>
   <?php echo $form->end('Search');?>
	</fieldset>
</div>

<div class="related">
   <h3><?php __('Logs and dynamically user created rules');?></h3>
   <br>
   <?php if (!empty($logs)):?>
   <table cellpadding = "0" cellspacing = "0">
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
         printLog($this, $html, $log);
         if (!empty($log['Child'])):
            foreach ($log['Child'] as $child): 
               printLog($this, $html, $child, $log);
            endforeach;
         endif;
      endforeach; ?>

</table>
<?php endif; ?>

</div>


<?php 

   function printLog($view, &$html, $log, $parent=null) {
      if (!empty($log['Childlog'])) {
         $class = "parent";
         $l = $log['Log'];
      }
      if (!empty($log['parent_id'])) {
         $class = "child";
         $l = $log;
         $log = $parent;
      } 
      else {
         $class = "parent";
         $l = $log['Log'];
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
               $html->link(__('Delete', true), array('controller'=> 'logs', 'action'=>'delete', $l['id'], $view->data['Log']['location']), null, sprintf(__('Are you sure you want to delete # %s?', true), $l['id'])) . "
            </td>
         </tr>";
   }

?>


