<div class="locations view">	
<h2>
	<?php 
	  echo "Location: "; echo $html->link(__($location[0]['Location']['code'], true), array('controller'=> 'locations', 'action'=>'edit', $location[0]['Location']['id'])); echo " - "; echo $location[0]['Location']['name']; 
	?>
</h2>
</div>
<div class="related">
	<h3><?php __('Location Groups');?></h3>
   <li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add', $location[0]['Location']['id']));?> </li>
   <br>
	<?php if (!empty($groups)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Location'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		foreach ($groups as $group):
		?>
		<tr>
			<td><?php echo $group['Group']['name'];?></td>
			<td><?php echo $group['Location']['code'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Manage', true), array('controller'=> 'groups', 'action'=>'view', $group['Group']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'groups', 'action'=>'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['Group']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Location-wide Rules');?></h3>
	<li><?php echo $html->link(__('Create new Location Rule', true), array('controller'=> 'rules', 'action'=>'add', $location[0]['Location']['id']));?> </li>
   <br>
	<?php if (!empty($rules)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Sitename'); ?></th>
		<th><?php __('Protocol'); ?></th>
		<th><?php __('Priority'); ?></th>
		<th><?php __('Policy'); ?></th>
		<th><?php __('Starttime'); ?></th>
		<th><?php __('Endtime'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php foreach ($rules as $rule): ?>
		<tr>
			<td><?php echo $rule['Rule']['sitename'];?></td>
			<td><?php echo $rule['Rule']['protocol'];?></td>
			<td><?php echo $rule['Rule']['priority'];?></td>
			<td><?php echo $rule['Rule']['policy'];?></td>
			<td><?php echo $rule['Rule']['starttime'];?></td>
			<td><?php echo $rule['Rule']['endtime'];?></td>
			<td><?php echo $rule['Rule']['description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('controller'=> 'rules', 'action'=>'edit', $rule['Rule']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'rules', 'action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['Rule']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Not assigned users');?></h3>
	<?php if (!empty($users)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Username'); ?></th>
		<th><?php __('Realname'); ?></th>
		<th><?php __('Emailaddress'); ?></th>
		<th><?php __('Location'); ?></th>
	</tr>
	<?php
		foreach ($users as $user):
		?>
		<tr>
			<td><?php echo $user['User']['username'];?></td>
			<td><?php echo $user['User']['realname'];?></td>
			<td><?php echo $user['User']['emailaddress'];?></td>
			<td><?php echo $user['Location']['code'];?></td>	
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
