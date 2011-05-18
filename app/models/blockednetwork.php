<?php
class Blockednetwork extends AppModel {

	var $name = 'Blockednetwork';
	var $validate = array(
		'network' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Location' => array('className' => 'Location',
								'foreignKey' => 'location_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>