<?php
class AdminsLocation extends AppModel {

	var $name = 'AdminsLocation';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Admin' => array(
			'className' => 'Admin',
			'foreignKey' => 'admin_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>