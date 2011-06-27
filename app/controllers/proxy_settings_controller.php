<?php
class ProxySettingsController extends AppController {

	var $name = 'ProxySettings';
	var $helpers = array('Html', 'Form', 'Timezone');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
   }

   function afterFilter() {
      $allowedActions = array('admin_index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }   

	function admin_index() {
      $this->set('proxy_settings', $this->paginate());
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         $this->ProxySetting->create();
         if ($this->ProxySetting->save($this->data)) {
            $this->Session->setFlash(__('The proxy has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['ProxySetting']['id'], 'activity');
            $this->Tracker->back();
         } else {
            $this->Session->setFlash(__('The proxy could not be saved. Please, try again.', true));
         }
      }

      $this->CommonTasks->setLocationsList(true);
   }

   function admin_edit($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid proxy', true));
         $this->Tracker->back();
      }
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         if ($this->ProxySetting->save($this->data)) {
            $this->Session->setFlash(__('The proxy has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['ProxySetting']['id'], 'activity');
            $this->Tracker->back();
         } else {
            $this->Session->setFlash(__('The proxy could not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->ProxySetting->read(null, $id);
      }

      $this->CommonTasks->setLocationsList(true);
   }

   function admin_editdb($id = null) {
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid proxy', true));
         $this->Tracker->back();
      }
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
      if (!empty($this->data)) {
         if ($this->ProxySetting->save($this->data)) {
            $this->Session->setFlash(__('The proxy has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit database: " . $this->data['ProxySetting']['id'], 'activity');
            $this->Tracker->back();
         } else {
            $this->Session->setFlash(__('The proxy could not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->ProxySetting->read(null, $id);
      }
   }

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for proxy', true));
         $this->Tracker->back();
		}
		if ($this->ProxySetting->delete($id)) {
			$this->Session->setFlash(__('Proxy deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['ProxySetting']['id'], 'activity');
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
