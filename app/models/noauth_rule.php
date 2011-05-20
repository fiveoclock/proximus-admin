<?php
class NoauthRule extends AppModel {

	var $name = 'NoauthRule';
	var $validate = array(
		'sitename' => array('notempty'),
		'protocol' => array('notempty'),
	);

   function beforeSave()
   {  
      $todays_date = date("Y-m-d");
      $today = strtotime($todays_date);
      $expiration_date = strtotime($this->data['NoauthRule']['valid_until']);

      #debug($expiration_date);
      #debug($today);

      # if date is not set, save null
      if ( $this->data['NoauthRule']['valid_until'] == "" ) {
         unset( $this->data['NoauthRule']['valid_until'] );
         #debug("no date set; saving null");
         return true;
      } 

      # if date is in the past don't save
      if ( ($expiration_date < $today) || ($expiration_date == null) ) {
         #debug("date in the past; not saving");
         return false;
      }

      # finally return true to make saving possible;
      return true;
   }

   //The Associations below have been created with all possible keys, those that are not needed can be removed
   var $belongsTo = array(
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
