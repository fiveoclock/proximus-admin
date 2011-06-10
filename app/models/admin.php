<?php
class Admin extends AppModel {

	var $name = 'Admin';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

   var $actsAs = array('Acl' => array('requester'));

	var $hasAndBelongsToMany = array(
		'Location' => array(
			'className' => 'Location',
			'joinTable' => 'admins_locations',
			'foreignKey' => 'admin_id',
			'associationForeignKey' => 'location_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
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
    'password' => array( 
                        'passwordConfirm' => array( 
                        'rule' => array('confirmPassword', 'password'), 
                        'message' => 'passwords don\'t match up, please verify and submit again!' 
                        ) 
    ),
    'confirm_password' => array( 
                       VALID_NOT_EMPTY, 
                        'alphanumeric' => array( 
                                'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
                                'message' => 'Only alphabets and numbers allowed' 
                        ), 
                        'between' => array( 
                                'rule' => array('between', 4, 20), 
                                'message' => 'Password must be between 4 and 20 characters long.' 
                        ), 
                        'required' => array( 
                                'rule' => array('required' => true), 
                                'message' => 'Did you think you\'d get away with a blank password?'
                        )
    )
  );

   function confirmPassword($data) { 
      $valid = false; 
      if ($data['password'] == Security::hash(Configure::read('Security.salt') . $this->data['Admin'] ['password_confirm'])) { 
         $valid = true; 
      } 
      return $valid; 
   }
   /**    
    * After save callback
    *
    * Update the aro for the user.
    *
    * @access public
    * @return void
    */
   function afterSave($created) {
      if (!$created) {
         $parent = $this->parentNode();
         $parent = $this->node($parent);
         $node = $this->node();
         $aro = $node[0];
         $aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
         $this->Aro->save($aro);
      }
   }
   
   function parentNode() {
      if (!$this->id && empty($this->data)) {
         return null;
      }
      $data = $this->data;
      if (empty($this->data)) {
         $data = $this->read();
      }
      if (!$data['Admin']['role_id']) {
         return null;
      } else {
         return array('Role' => array('id' => $data['Admin']['role_id']));
      }
   }

}
?>
