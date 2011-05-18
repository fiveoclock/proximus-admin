<div class="locations view_new">
<?php
?>		
<h2>
	<?php 
	  echo "Location: "; echo $locations[0]['Location']['code']; echo " - "; echo $locations[0]['Location']['name']; 	
	?>
</h2>

</div>
<div class="related">
	<h3><?php __('Related Groups');?></h3>
	<?php if (!empty($rules['Rule'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Name'); ?></th>
		<th><?php __('Location'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		foreach ($rules['Rule'] as $rule):
		?>
		<tr>
			<td><?php echo $rule['sitename'];?></td>
			<td><?php echo $rule['siteport']?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'groups', 'action'=>'view', $group['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'groups', 'action'=>'delete', $group['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>

<div class="related">
	<h3><?php __('Available Users');?></h3>
	<?php if (!empty($location['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Realname'); ?></th>
		<th><?php __('Emailaddress'); ?></th>
		<th><?php __('Location Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		foreach ($location['User'] as $user):
		?>
		<tr>
			<td><?php echo $user['id'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['realname'];?></td>
			<td><?php echo $user['emailaddress'];?></td>
			<td><?php echo $location['Location']['code'];?></td>	
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'users', 'action'=>'view', $user['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'users', 'action'=>'edit', $user['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'users', 'action'=>'delete', $user['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<div class="related">
	<h3><?php __('Location-wide Rules');?></h3>
	<?php if (!empty($rules)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Sitename'); ?></th>
		<th><?php __('Protocol'); ?></th>
		<th><?php __('Priority'); ?></th>
		<th><?php __('Policy'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php foreach ($rules as $rule): ?>
		<tr>
			<td><?php echo $rule['Rule']['sitename'];?></td>
			<td><?php echo $rule['Rule']['protocol'];?></td>
			<td><?php echo $rule['Rule']['priority'];?></td>
			<td><?php echo $rule['Rule']['policy'];?></td>
			<td><?php echo $rule['Rule']['description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('controller'=> 'rules', 'action'=>'edit', $rule['Rule']['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'rules', 'action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['Rule']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('Create new Location Rule', true), array('controller'=> 'rules', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
