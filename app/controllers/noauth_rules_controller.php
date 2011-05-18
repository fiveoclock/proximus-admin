<?php
class NoauthRulesController extends AppController {

	var $name = 'NoauthRules';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('index');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }   
   }   

	function index() {

      # If form submit has been done
      if (!empty($this->data) && isset($this->data['NoauthRule']['searchstring'])) {

		   $this->NoauthRules->recursive = 0;
		   $this->set('noauth_rules', $this->paginate('NoauthRule',array('NoauthRule.sitename LIKE'=>'%'.$this->data['NoauthRule']['searchstring'].'%')));
      } 
      else {
         $this->set('noauth_rules', $this->paginate());
      }
	}

	function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!empty($this->data)) {
			$this->NoauthRule->create();
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
				$this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Noauth rule', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
		if (!empty($this->data)) {
			if ($this->NoauthRule->save($this->data)) {
				$this->Session->setFlash(__('The Noauth rule has been saved', true));
				$this->redirect($this->Tracker->loadLastPos());
			} else {
				$this->Session->setFlash(__('The Noauth rule could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NoauthRule->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Noauth rule', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
		if ($this->NoauthRule->del($id)) {
			$this->Session->setFlash(__('Noauth rule deleted', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
	}

}
?>
