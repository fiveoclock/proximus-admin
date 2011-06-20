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
      $allowedActions = array('index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }



   function index() {
      $this->GlobalSetting->recursive = 0;
      $this->set('global_settings', $this->paginate());
   }

   function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!empty($this->data)) {
         $this->GlobalSetting->create();
         if ($this->GlobalSetting->save($this->data)) {
            $this->Session->setFlash(__('The setting was saved', true));
            $this->log( $this->MyAuth-->user('username') . "; $this->name ; add: " . $this->data['GlobalSetting']['id'], 'activity');
            $this->redirect($this->Tracker->loadLastPos());
         }
         else {
            $this->Session->setFlash(__('The setting could not be saved. Please, try again.', true));
            $this->redirect($this->Tracker->loadLastPos());
         }
      }
   }

   function edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid setting', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!empty($this->data)) {
         if ($this->GlobalSetting->save($this->data)) {
            $this->Session->setFlash(__('The setting was saved', true));
            $this->log( $this->MyAuth-->user('username') . "; $this->name ; edit: " . $this->data['GlobalSetting']['id'], 'activity');
            $this->redirect(array('action'=>'index'));
         } else {
            $this->Session->setFlash(__('The setting not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->GlobalSetting->read(null, $id);
      }
   }

   function delete($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid id', true));
         $this->redirect(array('action'=>'index'));
      }
      if ($this->GlobalSetting->del($id)) {
         $this->Session->setFlash(__('Setting deleted', true));
         $this->log( $this->MyAuth-->user('username') . "; $this->name ; delete: " . $this->data['GlobalSetting']['id'], 'activity');
         $this->redirect(array('action'=>'index'));
      }
   }


}

?>
