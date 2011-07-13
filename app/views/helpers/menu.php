<?php
class MenuHelper extends Helper {
   
   var $helpers = array('Html');

   function start() {
      return '<ul class="sf-menu">
               <li class="current">
               ';
   }

   function end() {
      return "</li>
            </ul>\n";
   }

   function item($name, $url, $val1=null, $val2=null, $val3=null) { 
      return "\t<li>" . $this->Html->link($name, $url, $val1, $val2, $val3) . "</li>\n"; 
   }

   function superItem($name, $url, $val1=null, $val2=null, $val3=null) { 
      return "\t<li>" . $this->Html->link($name, $url, $val1, $val2, $val3) . "<ul>\n"; 
   }

   function superItemText($text) {
      return "\t<li>" . $text . "</li>";
   }


   function superItemEnd() {
      return "\t</ul>";
   }

   function text($text) {
      return "\t<li>" . $text . "</li>\n"; 
   }

}
?>
