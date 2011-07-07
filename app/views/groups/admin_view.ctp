<div class="groups view">
	<h2>
		<?php 
		  echo $html->link('Locations','/admin/locations/start',null,null,false);
        echo " / ";
        echo $html->link($group['Location']['code'] . " - " . $group['Location']['name'], array('controller'=> 'locations', 'action'=>'view', $group['Location']['id']));
        echo " / ";
        echo $group['Group']['name'];
		?>
	</h2>
</div>
<div class="related">
	<h3><?php __('Defined Rules');?></h3>
   <li><?php echo $html->link(__('Add Rule', true), array('controller'=> 'rules', 'action'=>'add', $group['Location']['id'], $group['Group']['id']));?> </li>
   <br>
	<?php if (!empty($group['Rule'])):?>
	<table>
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
	<?php foreach ($group['Rule'] as $rule): ?>
		<tr>
			<td><?php echo $rule['sitename'];?></td>
			<td><?php echo $rule['protocol'];?></td>
			<td><?php echo $rule['priority'];?></td>
			<td><?php echo $rule['policy'];?></td>
			<td><?php echo $rule['starttime'];?></td>
			<td><?php echo $rule['endtime'];?></td>
			<td><?php echo $rule['description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('controller'=> 'rules', 'action'=>'edit', $rule['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'rules', 'action'=>'delete', $rule['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Assigned Users');?></h3>
   <li> <?php echo $html->link(__('Add or remove users', true), array('controller'=> 'groups', 'action'=>'edit', $group['Group']['id'])); ?> </li>
   <br>
	<?php if (!empty($group['User'])):?>
	<table>
	<tr>
		<th><?php __('Username'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('E-Mail'); ?></th>
		<th><?php __('Location'); ?></th>
	</tr>
	<?php foreach ($group['User'] as $user): ?>
		<tr>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['realname'];?></td>
			<td><?php echo $user['emailaddress'];?></td>
			<td><?php echo $group['Location']['code'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
