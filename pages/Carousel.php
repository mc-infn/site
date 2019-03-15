<?php
$config = parse_ini_file('config.ini');

#include($config['carousel']);

if (isset($config['short_description']))
  {
    echo $config['short_description'];
  }

$files = array();
$dir = new DirectoryIterator("./carousel-images/");
foreach ($dir as $fileinfo) 
  {
   if (!$fileinfo->isDot() && 
     strpos($fileinfo->GetFilename(),'~') === false &&
     strpos($fileinfo->GetFilename(),'#') === false &&
     !( strpos($fileinfo->getFilename(),".jpeg" ) === false &&
      	strpos($fileinfo->getFilename(),".jpg" ) === false &&
	strpos($fileinfo->getFilename(),".png" ) === false )
	)
   {
    $files[$fileinfo->getMTime()][] = $fileinfo->getFilename();
   }
  }
if(sizeof($files)>0)
  {
    ksort($files);
    $files= array_reverse ($files);
    $files = call_user_func_array('array_merge', $files);
  }

echo "<div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\">";
echo "<ol class=\"carousel-indicators\">";
echo "<li data-target=\"#carouselIndicators\" data-slide-to=\"0\" class=\"active\"></li>";
for($i=1; $i<sizeof($files); $i++)
  {
    echo "<li data-target=\"#carouselIndicators\" data-slide-to=\"".$i."\"></li>";
  }
echo "</ol>";
echo "<div class=\"carousel-inner\">";
for($i=0; $i<sizeof($files); $i++)
  {  
    $thisfile = $files[$i];
    $filename = "./carousel-images/".$thisfile;
    if($i==0)
    {
      echo "<div class=\"item active\">";
    }
    else
    {
      echo "<div class=\"item\">";
    }    
    echo "<img class=\"d-block w-100\" src=\"".$filename."\" >";
    echo "</div>";
  }
echo "</div>";

echo "<a class=\"carousel-control left\" href=\"#myCarousel\" data-slide=\"prev\">";
echo "<span class=\"glyphicon glyphicon-chevron-left\"></span>";
echo "</a>";
echo "<a class=\"carousel-control right\" href=\"#myCarousel\" data-slide=\"next\">";
echo "<span class=\"glyphicon glyphicon-chevron-right\"></span>";
echo "</a>";
echo "</div>";

?>