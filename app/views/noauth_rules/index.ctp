<div class="noauth_rules index">
<h2><?php __('Noauth Rules');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Noauth rule', true), array('action'=>'add')); ?></li>
	</ul>
</div>
<div class="noauth_rules form">
<?php echo $form->create(null, array('url' => '/noauth_rules/index')); ?>
   <fieldset>
   <?php
      echo $form->input('searchstring',array('label'=>'Optionally enter a search pattern (part of sitename)'));
   ?>
   <?php echo $form->end('Search');?>
   </fieldset>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('type');?></th>
	<th><?php echo $paginator->sort('sitename');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($noauth_rules as $noauth_rule):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $noauth_rule['NoauthRule']['type']; ?>
		</td>
		<td>
			<?php echo $noauth_rule['NoauthRule']['sitename']; ?>
		</td>
		<td>
			<?php echo $noauth_rule['NoauthRule']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $noauth_rule['NoauthRule']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $noauth_rule['NoauthRule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $noauth_rule['NoauthRule']['id'])); ?>
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

