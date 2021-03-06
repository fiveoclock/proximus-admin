<div class="locations view">	
<h2>
	<?php 
     echo $html->link('Locations','/admin/locations/start',null,null,false);
     echo " / ";
     echo $location['Location']['code'];
   ?>
</h2>
</div>

<?php if ( $location['Location']['id'] != 1 ):  // dont show groups section for location 1 ?>
   <div class="related">
      <h3><?php __('Groups');?></h3>
      <li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add', $location['Location']['id']));?> </li>
      <br>
      <?php if (!empty($groups)):?>
      <table>
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
<?php endif; ?>

<div class="related">
	<h3><?php __('Location-wide Rules');?></h3>
	<li><?php echo $html->link(__('Create new Location Rule', true), array('controller'=> 'rules', 'action'=>'add', $location['Location']['id']));?> </li>
   <br>
	<?php if (!empty($rules)):?>
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

<?php if ( $location['Location']['id'] != 1 ):  // dont show user section for location 1 ?>
   <div class="related">
      <h3><?php __('Users in this location (which are not assigned to a group)');?></h3>
      <?php if (!empty($users)):?>
      <table>
      <tr>
         <th><?php __('Username'); ?></th>
         <th><?php __('Realname'); ?></th>
         <th><?php __('Emailaddress'); ?></th>
      </tr>
      <?php
         foreach ($users as $user):
         ?>
         <tr>
            <td><?php echo $user['User']['username'];?></td>
            <td><?php echo $user['User']['realname'];?></td>
            <td><?php echo $user['User']['emailaddress'];?></td>
         </tr>
      <?php endforeach; ?>
      </table>
   <?php endif; ?>
<?php endif; ?>
</div>
