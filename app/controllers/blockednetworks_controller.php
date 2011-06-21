<?php
class BlockednetworksController extends AppController {

	var $name = 'Blockednetworks';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->MyAuth-->allowedActions = array('*');
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
            $this->log( $this->MyAuth-->user('username') . "; $this->name ; add: " . $this->data['Blockednetwork']['id'], 'activity');
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
            $this->log( $this->MyAuth-->user('username') . "; $this->name ; edit: " . $this->data['Blockednetwork']['id'], 'activity');
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

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Blockednetwork', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Blockednetwork->delete($id)) {
			$this->Session->setFlash(__('Blockednetwork deleted', true));
         $this->log( $this->MyAuth-->user('username') . "; $this->name ; delete: " . $this->data['Blockednetwork']['id'], 'activity');
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
