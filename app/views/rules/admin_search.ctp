<div class="rules form">
<?php echo $form->create(null, array('url' => '/admin/rules/search')); ?>
	<fieldset>
      <legend><?php __('Check rules');?></legend>
	<?php
      echo $form->input('locations');
      echo $form->input('pattern',array('label'=>'Search pattern (site or part of the site name)'));
	?>
   <?php echo $form->end('Search');?>
	</fieldset>
   <?php if (!empty($results)):?>
      <table cellpadding = "0" cellspacing = "0">
   	<?php
      echo "Results: ";    
      ?>
      <tr>
         <th><?php __('Site'); ?></th>
         <th><?php __('Protocol'); ?></th>
         <th><?php __('Priority'); ?></th>
         <th><?php __('Policy'); ?></th>
         <th><?php __('Starttime'); ?></th>
         <th><?php __('Endtime'); ?></th>
         <th><?php __('Description'); ?></th>
         <th><?php __('Location'); ?></th>
         <th><?php __('Group'); ?></th>
      </tr>
      <?php foreach ($results as $result): ?>
         <tr>
            <td><?php echo $result['rules']['sitename'];?></td>
            <td><?php echo $result['rules']['protocol'];?></td>
            <td><?php echo $result['rules']['priority'];?></td>
            <td><?php echo $result['rules']['policy'];?></td>
            <td><?php echo $result['rules']['starttime'];?></td>
            <td><?php echo $result['rules']['endtime'];?></td>
            <td><?php echo $result['rules']['description'];?></td>
            <td><?php echo $html->link(__($result['loc1']['code'], true), array('controller'=> 'locations', 'action'=>'view', $result['loc1']['id'])); ?></td>
            <td><?php echo $html->link(__($result['groups']['name'], true), array('controller'=> 'groups', 'action'=>'view', $result['groups']['id'])); ?></td>
         </tr>
      <?php endforeach; ?> 
      </table>
   <?php endif; ?>
</div>
