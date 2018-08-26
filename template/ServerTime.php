<?php
 echo "<div class=\"panel panel-default\">\n";
 /* echo "<div class=\"panel panel-primary\">"; */
 echo "<div class=\"panel panel-heading\">\n";
 echo "Server Time";
 echo "</div>\n";
 echo "<ul class=\"list-group\">";
 /* $date = date('d/m/Y H:i:s', time()); */
 $date = date('D d F Y', time());
 echo "<li class=\"list-group-item\"> $date </li>";
 $time = date('H:i:s', time());
 echo "<li class=\"list-group-item\"> $time </li>";
 $timezone = date_default_timezone_get();
 echo "<li class=\"list-group-item\"> Timezone: $timezone </li>";
 echo "</ul>";
 echo "</div>\n";        
?>