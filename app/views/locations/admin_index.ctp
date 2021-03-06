<div class="locations index">
<h2><?php __('Locations');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new location', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<br>

<p>
<?php
   echo $paginator->counter(array(
   'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
   ));
?></p>
<table>
   <tr>
      <th><?php echo $paginator->sort('id');?></th>
      <th><?php echo $paginator->sort('code');?></th>
      <th><?php echo $paginator->sort('name');?></th>
      <th class="actions"><?php __('Actions');?></th>
   </tr>
<?php
$i = 0;
foreach ($locations as $location):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $location['Location']['id']; ?>
		</td>
		<td>
			<?php echo $location['Location']['code']; ?>
		</td>
		<td>
			<?php echo $location['Location']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $location['Location']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $location['Location']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $location['Location']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $location['Location']['id'])); ?>
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

