<?php
class BlockednetworksController extends AppController {

	var $name = 'Blockednetworks';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->MyAuth->allowedActions = array('*');
   }

	function admin_index() {
		$this->Blockednetwork->recursive = 0;
		$this->set('blockednetworks', $this->paginate());
	}

	function admin_add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect(array('action'=>'index'));
      }
		if (!empty($this->data)) {
			$this->Blockednetwork->create();
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; add: " . $this->data['Blockednetwork']['id'], 'activity');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}
      # show location code + name 
      $locations_all = $this->Blockednetwork->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>array("Location.id NOT" => "1"),
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));
	}

	function admin_edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
			$this->redirect(array('action'=>'index'));
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Blockednetwork', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
            $this->log( $this->MyAuth->user('username') . "; $this->name ; edit: " . $this->data['Blockednetwork']['id'], 'activity');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Blockednetwork->read(null, $id);
		}
      # show location code + name 
      $locations_all = $this->Blockednetwork->Location->find('all',array(
         'fields'=>array('Location.id','Location.code','Location.name'),
         'recursive'=>-1,
         'conditions'=>array("Location.id NOT" => "1"),
         'order'=>array(
            'Location.code',
      )));
      # convert array
      $locations = Set::combine(
         $locations_all,
         '{n}.Location.id',
         array('%s %s','{n}.Location.code','{n}.Location.name')
      );
      $this->set(compact('locations'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Blockednetwork', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Blockednetwork->delete($id)) {
			$this->Session->setFlash(__('Blockednetwork deleted', true));
         $this->log( $this->MyAuth->user('username') . "; $this->name ; delete: " . $this->data['Blockednetwork']['id'], 'activity');
			$this->redirect(array('action'=>'index'));
		}
	}

   function isAuthorized() {
      $parent = parent::isAuthorized();
      if ( !is_null($parent) ) return $parent;

      return false;
   }

}
?>
