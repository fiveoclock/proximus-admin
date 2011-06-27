<?php
class BlockednetworksController extends AppController {

	var $name = 'Blockednetworks';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->MyAuth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('admin_index', );
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass']);
      }
   }

	function admin_index() {
		$this->Blockednetwork->recursive = 0;
		$this->set('blockednetworks', $this->paginate());
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!empty($this->data)) {
			$this->Blockednetwork->create();
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['Blockednetwork']['id'], 'activity');
            $this->Tracker->back();
			} 
         else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}

      $this->CommonTasks->setLocationsList(true);
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->Tracker->back();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Blockednetwork', true));
         $this->Tracker->back();
		}
		if (!empty($this->data)) {
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['Blockednetwork']['id'], 'activity');
            $this->Tracker->back();
			} 
         else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Blockednetwork->read(null, $id);
		}

      $this->CommonTasks->setLocationsList(true);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Blockednetwork', true));
         $this->Tracker->back();
		}
		if ($this->Blockednetwork->delete($id)) {
			$this->Session->setFlash(__('Blockednetwork deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['Blockednetwork']['id'], 'activity');
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
