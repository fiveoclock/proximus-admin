<?php
class GlobalSettingsController extends AppController {
   var $name = 'GlobalSettings';
   var $helpers = array('Html', 'Form');

   function beforeFilter(){
      parent::beforeFilter();
   }
   function afterFilter() {
      $allowedActions = array('index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }
   }

   function admin_index() {
      $this->GlobalSetting->recursive = 0;
      $this->set('global_settings', $this->paginate());
   }

   function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         $this->GlobalSetting->create();
         if ($this->GlobalSetting->save($this->data)) {
            $this->Session->setFlash(__('The setting was saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['GlobalSetting']['id'], 'activity');
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('The setting could not be saved. Please, try again.', true));
            $this->Tracker->back();
         }
      }
   }

   function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid setting', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         if ($this->GlobalSetting->save($this->data)) {
            $this->Session->setFlash(__('The setting was saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['GlobalSetting']['id'], 'activity');
            $this->Tracker->back();
         }
         else {
            $this->Session->setFlash(__('The setting not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->GlobalSetting->read(null, $id);
      }
   }

   function admin_delete($id = null) {
      if (!$id) {
         $this->Session->setFlash(__('Invalid id', true));
         $this->Tracker->back();
      }
      if ($this->GlobalSetting->delete($id)) {
         $this->Session->setFlash(__('Setting deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['GlobalSetting']['id'], 'activity');
         $this->Tracker->back();
      }
   }


   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      return false;
   }

}

?>
