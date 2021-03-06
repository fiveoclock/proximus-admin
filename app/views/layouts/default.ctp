<?php
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>Proximus Admin :: <?php echo $title_for_layout?></title>
   <?php echo $html->charset('UTF-8')?>
   <?php //echo $html->css('cake.forms', 'stylesheet', array("media"=>"all" ));?>
   <?php echo $html->css('contented1', 'stylesheet', array("media"=>"all" ));?>
   <?php echo $html->css('superfish', 'stylesheet', array("media"=>"all" ));?>
   <?php echo $this->Html->script('jquery-1.6.1'); ?> 
   <?php echo $this->Html->script('superfish'); ?> 
   <?php echo $this->Html->script('ani'); ?> 
   <script type="text/javascript"> 
      // initialise plugins
      jQuery(function(){
         jQuery('ul.sf-menu').superfish();
      });
   </script> 
</head>
<body>
<div id="header">
   <?php echo $html->image('logo.png', array("id"=>"logo") ); ?>
   <div id="title">ProXimus</div>
   <div id="slogan">Administration Interface</div>
</div>


<div id="nav">
   <?php echo $this->element('menu'); ?>
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
<br>
<?php echo $this->element('sql_dump');?>
<br>
</body>
   <script type="text/javascript">
      // set focus to first form field
      if (document.forms.length > 0 ) {
         var elements = document.forms[0].elements;
         for (var i = 0; i <= elements.length; i++) {
            if ( elements[i].nodeName in {'INPUT':'', 'SELECT':'','smith':''} )  {
               if ( elements[i].type != "hidden" ) {
                  elements[i].focus();
                  break;
               }
            }
         }
      }  
   </script>
</html>
