<?php
class User extends AppModel {

	var $name = 'User';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


  var $validate = array( 
    'username' => array( 
      'notEmpty' => array(
        'rule' => 'notEmpty',
        'message' => 'The username cannot be empty'
      ),
      'isUnique' => array(
        'rule' => 'isUnique',
        'message' => 'The username is already taken.'
      )
    ),
    'password_confirm' => array(
                        'notEmpty',
                        'alphanumeric' => array(
                                'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
                                'message' => 'Only alphabets and numbers allowed'
                        ),
                        'between' => array(
                                'rule' => array('between', 4, 20),
                                'message' => 'Password must be between 4 and 20 characters long.'
                        ),
       )
   );

   function confirmPassword($data) {
      $valid = false;
      if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['User']['password_confirm'])) {
         $valid = true;
      }
      return $valid;
   }

}
?>
