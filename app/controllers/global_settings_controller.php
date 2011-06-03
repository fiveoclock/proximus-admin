<?php
class GlobalSettingsController extends AppController {
   var $name = 'GlobalSettings';
   var $helpers = array('Html', 'Form');
   /*
    * Lockdown all access to admins
 (this uses my custom method for security,
    *  you'll need to use auth or whatever you prefer to prevent guest or lowly users from access
    */   
   function beforeFilter(){
      parent::beforeFilter();
   }
   function afterFilter() {
      $allowedActions = array('index','edit');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }



   function index() {
      $this->GlobalSetting->recursive = 0;
      $this->set('global_settings', $this->paginate());
   }
   
   function edit($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid seettings', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!empty($this->data)) {
         if ($this->GlobalSetting->save($this->data)) {
            $this->Session->setFlash(__('The setting has been saved', true));
            $this->redirect($this->Tracker->loadLastPos());
         } else {
            $this->Session->setFlash(__('The settings could not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->GlobalSetting->read(null, $id);
      }
   }
}

?>
