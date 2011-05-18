<?php
class BlockednetworksController extends AppController {

	var $name = 'Blockednetworks';
	var $helpers = array('Html', 'Form');

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }

	function index() {
		$this->Blockednetwork->recursive = 0;
		$this->set('blockednetworks', $this->paginate());
      $this->savePos();
	}

   function savePos() {
      #pr($this->params['controller']);
      #pr($this->params['action']);
      #pr($this->params['pass'][0]);
      if (!empty($this->params['controller'])) {$this->Session->write('PrevPos.Controller',$this->params['controller']);}
      if (!empty($this->params['action'])) {$this->Session->write('PrevPos.Action',$this->params['action']);}
      if (!empty($this->params['pass'][0])) {$this->Session->write('PrevPos.Id',$this->params['pass'][0]);}
   }

   function redirectBack() {
      $this->redirect(array('controller'=>$this->Session->read('PrevPos.Controller'),
         'action'=>$this->Session->read('PrevPos.Action'),
         $this->Session->read('PrevPos.Id')
         )
      );
   }

	function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirectBack();
      }
		if (!empty($this->data)) {
			$this->Blockednetwork->create();
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}
		$locations = $this->Blockednetwork->Location->find('list');
		$this->set(compact('locations'));
	}

	function edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirectBack();
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Blockednetwork', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Blockednetwork->save($this->data)) {
				$this->Session->setFlash(__('The Blockednetwork has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Blockednetwork could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Blockednetwork->read(null, $id);
		}
		$locations = $this->Blockednetwork->Location->find('list');
		$this->set(compact('locations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Blockednetwork', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Blockednetwork->del($id)) {
			$this->Session->setFlash(__('Blockednetwork deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
