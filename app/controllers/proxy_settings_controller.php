<?php
class ProxySettingsController extends AppController {

	var $name = 'ProxySettings';
	var $helpers = array('Html', 'Form');
   var $paginate = array('limit' => 100);
   #var $uses = array('ProxySetting', 'Location');

   function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allowedActions = array('*');
   }

   function afterFilter() {
      $allowedActions = array('index','delete','add','edit');
      if (in_array($this->params['action'],$allowedActions)) {
         $this->Tracker->savePosition($this->params['controller'],$this->params['action'], $this->params['pass'][0]);
      }   
   }   

	function index() {
      $this->set('proxy_settings', $this->paginate());
	}

	function add() {
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!empty($this->data)) {
         $this->ProxySetting->create();
         if ($this->ProxySetting->save($this->data)) {
            $this->Session->setFlash(__('The proxy has been saved', true));
            $this->redirect(array('action'=>'index'));
         } else {
            $this->Session->setFlash(__('The proxy could not be saved. Please, try again.', true));
         }
      }

      # show location code + name 
      $locations_all = $this->ProxySetting->Location->find('all',array(
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
      if (!$id && empty($this->data)) {
         $this->Session->setFlash(__('Invalid proxy', true));
         $this->redirect(array('action'=>'index'));
      }
      if (array_key_exists('cancel', $this->params['form'])) {
         $this->Session->setFlash(__('Canceled', true));
         $this->redirect($this->Tracker->loadLastPos());
      }
      if (!empty($this->data)) {
         if ($this->ProxySetting->save($this->data)) {
            $this->Session->setFlash(__('The proxy has been saved', true));
            $this->redirect(array('action'=>'index'));
         } else {
            $this->Session->setFlash(__('The proxy could not be saved. Please, try again.', true));
         }
      }
      if (empty($this->data)) {
         $this->data = $this->ProxySetting->read(null, $id);
      }

      # show location code + name 
      $locations_all = $this->ProxySetting->Location->find('all',array(
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
			$this->Session->setFlash(__('Invalid id for proxy', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
		if ($this->ProxySetting->del($id)) {
			$this->Session->setFlash(__('Proxy deleted', true));
			$this->redirect($this->Tracker->loadLastPos());
		}
	}

}
?>
