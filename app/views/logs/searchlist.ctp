<div id="nav">
<?php
   echo $html->link('List Search','/logs/searchlist',null,null,false);
   if ($godmode == 1) {
      echo " | ";
      echo $html->link('String Search','/logs/searchstring',null,null,false);
   }
?>
</div>
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
	<fieldset>
	<?php
      #echo "Results: ";    
      #pr($logs);
   ?>
	</fieldset>
</div>
<div class="related">
   <h3><?php __('Temporary created user-based Rules(Logs)');?></h3>
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
   <?php $i=0; ?>
   <?php foreach ($logs as $log): ?>
   <?php if ($i % 2) { $color="#EEEEEE";} 
         else { $color="#DDDDDD";} ?>
      <tr bgcolor=<?php echo $color; ?>>
         <td class="parent"><?php echo $log['Log']['sitename'];?></td>
         <td><?php echo $log['Log']['hitcount'];?></td>
         <td><?php echo $log['Log']['protocol'];?></td>
         <td><?php echo $log['Log']['ipaddress'];?></td>
         <td><?php echo $log['Log']['source'];?></td>
         <td><?php echo $log['User']['username'];?></td>
         <td><?php echo $log['Log']['created'];?></td>
         <td class="actions">
            <?php echo $html->link(__('Create rule', true), array('controller'=> 'rules', 'action'=>'createFromLog', $log['Log']['id'],$this->data['Log']['locations'])); ?>
            <?php echo $html->link(__('Delete', true), array('controller'=> 'logs', 'action'=>'deleteWithChildren', $log['Log']['id'],$this->data['Log']['locations']), null, sprintf(__('Are you sure you want to delete # %s?', true), $log['Log']['id'])); ?>
         </td>
      </tr>
      <?php if (!empty($log['Childlog'])):?>
      <?php foreach ($log['Childlog'] as $childlog): ?>
         <tr bgcolor=<?php echo $color; ?>>
            <td class="child"><?php echo $childlog['sitename'];?></td>
            <td><?php echo $childlog['hitcount'];?></td>
            <td><?php echo $childlog['protocol'];?></td>
            <td><?php echo $childlog['ipaddress'];?></td>
            <td><?php echo $childlog['source'];?></td>
            <td><?php echo $log['User']['username'];?></td>
            <td><?php echo $childlog['created'];?></td>
            <td class="actions">
               <?php echo $html->link(__('Create rule', true), array('controller'=> 'rules', 'action'=>'createFromLog', $childlog['id'],$this->data['Log']['locations'])); ?>
               <?php echo $html->link(__('Delete', true), array('controller'=> 'logs', 'action'=>'delete', $childlog['id'], $this->data['Log']['locations']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childlog['id'])); ?>
               <?php echo $html->link('Rule','/rules/createFromLog/log_id:'.$childlog['id'].'/loc_id:'.$childlog['id'],null,null,false);?>
            </td>
         </tr>
      <?php endforeach; ?>
      <?php endif; ?>
   <?php $i++; ?>
   <?php endforeach; ?>
</table>
<?php endif; ?>

</div>

