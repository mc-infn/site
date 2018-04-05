<?php 
$config = parse_ini_file('config.ini');
echo "<div class=\"row\">";
echo "<div class=\"col-sm-5\" >";
echo "<img class=\"img-responsive max-width: 80%; height: auto;\" src=\"logo_INFN.png\">";

if (isset($config['short_description']))
  {
    echo $config['short_description'];
  }

echo "</div>";

echo "<div class=\"col-sm-7\" >";

if (isset($config['home_img']))
  {
    echo "<img class=\"img-thumbnail\" src=\"";
    echo $config['home_img'];
    echo"\"> \n";
  }

echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-sm-12\" >";
echo "<h3>Contacts:</h3>";
echo "<p>";
echo "<ul class=\"icon\">";
if (isset($config['email']))
  {
    echo "<li class=\"envelope\"> ";
    echo "email: <a href=\"mailto:";
    echo $config['email'];			 
    echo " rel=\"nofollow\">";
    echo $config['email'];			 
    echo"</a></li>";
  }
if (isset($config['skype']))
  {
    echo "<li class=\"comment\"> ";
    echo "skype: ";
    echo $config['skype'];			 
    echo"</li>";
  }
if (isset($config['telephone']))
  {
    echo "<li class=\"phone-alt\"> ";
    echo "telephone: ";
    echo $config['telephone'];			 
    echo"</li>";
  }

if (isset($config['address']))
  {
    echo "<li class=\"map-marker\"> "; 
    echo "address: ";
    echo $config['address'];
    echo "</li>";
  }

echo "</li>";
echo "</ul>";
echo "</p>";
echo "</div>";
echo "</div>";

?>
