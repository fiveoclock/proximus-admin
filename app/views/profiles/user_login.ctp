<h2>User Login</h2>
<?php
echo $form->create('User', array('url' => array('controller' => 'profiles', 'action' =>'login')));
echo $form->input('User.username');
echo $form->input('User.password');
echo $form->end('Login');
?>
