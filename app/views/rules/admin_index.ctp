<div class="rules index">
<h2><?php __('Rules');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('sitename');?></th>
	<th><?php echo $paginator->sort('siteport');?></th>
	<th><?php echo $paginator->sort('priority');?></th>
	<th><?php echo $paginator->sort('policy');?></th>
	<th><?php echo $paginator->sort('starttime');?></th>
	<th><?php echo $paginator->sort('endtime');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('sourceip');?></th>
	<th><?php echo $paginator->sort('location_id');?></th>
	<th><?php echo $paginator->sort('group_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($rules as $rule):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $rule['Rule']['id']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['sitename']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['siteport']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['priority']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['policy']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['starttime']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['endtime']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['description']; ?>
		</td>
		<td>
			<?php echo $rule['Rule']['sourceip']; ?>
		</td>
		<td>
			<?php echo $html->link($rule['Location']['name'], array('controller'=> 'locations', 'action'=>'view', $rule['Location']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($rule['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $rule['Group']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $rule['Rule']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $rule['Rule']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $rule['Rule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rule['Rule']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Rule', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Locations', true), array('controller'=> 'locations', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Location', true), array('controller'=> 'locations', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
