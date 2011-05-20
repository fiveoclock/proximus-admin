<div class="users index">
<h2><?php __('Users');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new user', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<br>

<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('username');?></th>
	<th><?php echo $paginator->sort('realname');?></th>
	<th><?php echo $paginator->sort('emailaddress');?></th>
	<th><?php echo $paginator->sort('Location','Location.code');?></th>
	<th><?php echo $paginator->sort('Group','Group.name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['realname']; ?>
		</td>
		<td>
			<?php echo $user['User']['emailaddress']; ?>
		</td>
		<td>
			<?php echo $user['Location']['code']; ?>
		</td>
		<td>
			<?php echo $user['Group']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
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

