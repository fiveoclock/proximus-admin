<?php
class AppModel extends Model 
{

   function checkUnique($data, $fields)
   {
      // check if the param contains multiple columns or a single one
      if (!is_array($fields))
      {
         $fields = array($fields);
      }

      // go trough all columns and get their values from the parameters
      foreach($fields as $key)
      {
         $unique[$key] = $this->data[$this->name][$key];
      }

      // primary key value must be different from the posted value
      if (isset($this->data[$this->name][$this->primaryKey]))
      {
         $unique[$this->primaryKey] = "<>" . $this->data[$this->name][$this->primaryKey];
      }

      // use the model's isUnique function to check the unique rule
      return $this->isUnique($unique, false);
   }

}
?>
