<div class="rules form">
<?php echo $form->create('Rule');?>
	<fieldset>
 		<legend><?php __('Add Rule');?></legend>
	<?php
		echo $form->input('sitename', array( 'label'=> 'Hostname or IP address - regex (eg. .example.com / 10.1.1.1)' ) );
		echo $form->input('protocol', array('options' => array('*'=>'*','HTTP'=>'HTTP','SSL'=>'SSL')));

      for ($i=$auth['Role']['minprio']; $i<=$auth['Role']['maxprio']; $i++) { $numbers[$i] = $i; }
		echo $form->input('priority', array('options' => $numbers, 'label'=> 'Priority (higher means more important)' ));
		echo $form->input('policy', array('options' => $policy->getPolicies($auth['Role']['name']), 'label'=> 'Policy (What to do if rule matches)' ));
		echo $form->input('starttime', array('type' => 'time', 'timeFormat' => 24, 'interval' => 15, 'selected' => '00:00:00', 'label'=> 'Starttime (leave both at 0:00 for no time)'));
      echo $form->input('endtime', array('type' => 'time', 'timeFormat' => 24, 'interval' => 15, 'selected' => '00:00:00', 'label'=> 'Endtime' ) );
      echo $form->input('description');
      echo $form->hidden('location_id');
      echo $form->hidden('group_id');
	?>

   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?>
	</fieldset>
</div>
