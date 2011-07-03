<div class="locations index">
<h2><?php __('Your Locations');?></h2>

<table>
<tr>
	<th>Location</th>
	<th>Full Name</th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
foreach ($locations as $location):
?>
	<tr>
		<td>
			<?php echo $location['Location']['code']; ?>
		</td>
		<td>
			<?php echo $location['Location']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Manage', true), array('action'=>'view', $location['Location']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
