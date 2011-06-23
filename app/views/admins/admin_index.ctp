<div class="admins index">
<h2><?php __('Admins');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new admin account', true), array('action'=>'add')); ?></li>
	</ul>
   <br>
</div>

<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('username');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('Role','Role.name');?></th>
	<th><?php echo $paginator->sort('active');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($admins as $admin):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $admin['Admin']['username']; ?>
		</td>
		<td>
			<?php echo $admin['Admin']['name']; ?>
		</td>
		<td>
			<?php echo $admin['Role']['name']; ?>
		</td>
		<td>
			<?php echo $admin['Admin']['active']; ?>
		</td>
		<td>
			<?php echo $admin['Admin']['created']; ?>
		</td>
		<td>
			<?php echo $admin['Admin']['modified']; ?>
		</td>

		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $admin['Admin']['id'])); ?>
			<?php echo $html->link(__('/ Set Password', true), array('action'=>'changePassword', $admin['Admin']['id'])); ?>
			<?php echo $html->link(__('/ Delete', true), array('action'=>'delete', $admin['Admin']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $admin['Admin']['id'])); ?>
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

