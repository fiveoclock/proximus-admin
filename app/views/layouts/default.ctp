<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Proximus Admin :: <?php echo $title_for_layout?></title>
<?php echo $html->charset('UTF-8')?>
<?php echo $html->css('cake.forms', 'stylesheet', array("media"=>"all" ));?>
<?php echo $html->css('contented1', 'stylesheet', array("media"=>"all" ));?>
</head>
<body>
<div id="header">

<?php echo $html->image('logo.png', array("id"=>"logo") ); ?>
<div id="title"><a href="/">ProXimus</a></div>


<div id="slogan">Administration Interface</div>

</div>

<div id="nav">
<?php 
   echo $this->element('menu'); 
?>
</div>


<div id="content">
<div id="maincontent">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Session->flash('auth'); ?>
<?php echo $content_for_layout?>

</div>


<div id="footer">
<div id="copyrightdesign">
ProXimus-Admin
</div>

<div id="footercontact">
<a href="http://proximus.5-o-clock.net">Proximus Website</a>
</div>

</div>


<br>
<br>
<?php echo $this->element('sql_dump');?>
</body>
</html>
