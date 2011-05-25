<div class="rules form">
<?php echo $form->create('Rule');?>
	<fieldset>
 		<legend><?php __('Edit Rule');?></legend>
	<?php
      
		echo $form->input('id');
		echo $form->input('sitename');
		echo $form->input('protocol', array('options' => array('*'=>'*','HTTP'=>'HTTP','SSL'=>'SSL')));
      if ($godmode == 1) {
         $MIN_NUM=0;
         $MAX_NUM=60;
      } else {
         $MIN_NUM=20;
         $MAX_NUM=40;
      }
      for ($i=$MIN_NUM; $i<=$MAX_NUM; $i++) { $numbers[$i] = $i; }
      echo $form->input('priority', array('options' => $numbers));
		echo $form->input('policy', array('options' => $policy->getPolicies($godmode)));
      echo $form->input('starttime', array('type' => 'time', 'timeFormat' => 24, 'interval' => 15));
		echo $form->input('endtime', array('type' => 'time', 'timeFormat' => 24, 'interval' => 15));
		echo $form->input('description');
      echo $form->hidden('location_id');
      echo $form->hidden('group_id');

	?>
   <?php echo $form->end('Submit');?>
   <?php echo $this->element('back_btn');?> 
	</fieldset>
</div>
