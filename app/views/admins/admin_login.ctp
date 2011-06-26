<h2>Admin Login</h2>
<?php
echo $form->create('Admin', array('url' => array('controller' => 'admins', 'action' =>'login')));
echo $form->input('Admin.username');
echo $form->input('Admin.password');
echo $form->end('Login');
?>
