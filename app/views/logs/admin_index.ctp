<div class="logs index">
<h2><?php __('Logs');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table>
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('sitename');?></th>
	<th><?php echo $paginator->sort('ipaddress');?></th>
	<th><?php echo $paginator->sort('protocol');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('location_id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('source');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($logs as $log):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $log['Log']['id']; ?>
		</td>
		<td>
			<?php echo $log['Log']['sitename']; ?>
		</td>
		<td>
			<?php echo $log['Log']['ipaddress']; ?>
		</td>
		<td>
			<?php echo $log['Log']['protocol']; ?>
		</td>
		<td>
			<?php echo $log['Log']['created']; ?>
		</td>
		<td>
			<?php echo $log['User']['username']; ?>
		</td>
		<td>
			<?php echo $log['Location']['code']; ?>
		</td>
		<td>
			<?php echo $log['Log']['parent_id']; ?>
		</td>
		<td>
			<?php echo $log['Log']['source']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $log['Log']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $log['Log']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $log['Log']['id'])); ?>
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
		<li><?php echo $html->link(__('New Log', true), array('action'=>'add')); ?></li>
	</ul>
</div>
