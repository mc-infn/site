<?php 
ini_set('display_errors', 'On');

function directoryToList($dirname, $disallowed_paths, $action)
{
  $dir = new DirectoryIterator($dirname);

  include("./template/navhead.htm");
  foreach ($dir as $fileinfo) 
    {
      if (!$fileinfo->isDot()) 
	{
	  /* var_dump($fileinfo->getFilename()); */
	  $filename = $fileinfo->getFilename();
	  if ((strpos($filename, '~') === false) && 
	      (strpos($filename, '#') === false) &&
	      (strpos($filename, 'Home') === false) &&
	      (!in_array($filename, $disallowed_paths)))
	    {
	      if($fileinfo->isDir())
	      	{
	      	  //
		  $subdirname = $filename;
		  echo "<li class=\"dropdown\">";
		  echo "<a href=\"?action=\"";
		  echo $filename+"/index.htm";
		  echo "class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">";
		  echo preg_replace('/^\d/', '', $filename);
		  echo "<span class=\"caret\"></span></a>";
		  echo "<ul class=\"dropdown-menu\">";
		  $subdir = new DirectoryIterator("./pages/".$filename);
		  foreach ($subdir as $subfileinfo)
		    {
		      if (!$subfileinfo->isDot())
			{
			  $filename = $subfileinfo->getFilename();
			  if ((strpos($filename, '~') === false) &&
			      (strpos($filename, '#') === false))
			    {
			      $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
			      $withoutNum = preg_replace('/^\d/', '', $withoutExt);
			      $withoutUnder = str_replace('_', ' ', $withoutNum);
			      echo "<li><a href=?action=";
			      echo $subdirname."/".$withoutExt;
			      echo ">";
			      echo $withoutUnder;
			      echo "</a>";
			      echo "</li>";
			    }
			}
		    }
		  echo "</ul>";
		  echo "</li>";
		}
	      else
		{
		  $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		  $withoutNum = preg_replace('/^\d/', '', $withoutExt);
		  $withoutUnder = str_replace('_', ' ', $withoutNum);
		  if ($withoutExt == $action)
		    {
		      echo "<li class=\"active\">";
		    }
		  else
		    {
		      echo "<li>";
		    }
		  echo "<a href=?action=";
		  echo $withoutExt;
		  echo ">";
		  echo $withoutUnder;
		  echo "</a>";
		  echo "</li>";
		}
	    }
	}
    }
  /* include("template/dropdown.htm"); */
  
  echo "</ul>";
  echo "</div>\n";
  echo "</div>\n"; 
  echo "</nav>";

  return $action;  
}

include("./template/header.htm");
// Set the default name 
$action = 'Home'; 
// Specify some disallowed paths 
$disallowed_paths = array('header', 'footer'); 
if (!empty($_GET['action'])) 
  { 
    //$tmp_action = basename($_GET['action']); 
    $tmp_action = $_GET['action'];
     /* echo "./pages/".$tmp_action.".htm"; */

    // If it's not a disallowed path, and if the file exists, update $action 
    if (!in_array($tmp_action, $disallowed_paths) && file_exists("./pages/".$tmp_action.".htm"))
      $action = $tmp_action; 
  } 


$action = directoryToList("./pages",$disallowed_paths, $action);
//////////////////////////////////////

echo "<div class=\"container-fluid\">\n";
echo "<div class=\"container theme-showcase\" role=\"main\">\n";

echo "<div class=\"row\">\n";
/* echo "<div class=\"jumbotron\">"; */
echo "<div class=\"page-header\">\n";
echo "<h1>";
$withoutNum = preg_replace('/^\d/', '', basename($action));
$withoutUnder = str_replace('_', ' ', $withoutNum);
echo $withoutUnder;
echo "</h1>";
echo "</div>\n"; 
echo "</div>\n"; //row

echo "<div class=\"row\">\n";
$noSidebar = array('Outreach');
if(!in_array($withoutUnder, $noSidebar))
  {
    echo "<div class=\"col-sm-8\">\n";
    /* echo "<div class=\"well\">";  */
    // Include $action 
    include("./pages/".$action.".htm"); 
    /* echo "</div>\n"; */
    echo "</div>\n";

    echo "<div class=\"col-sm-4\">\n";
    /* echo "<div class=\"panel panel-primary\">"; */
    echo "<div class=\"panel panel-default\">\n";
    echo "<div class=\"panel panel-heading\">\n";
    echo "Links";
    echo "</div>\n";
    include("template/sidebar.htm"); 
    echo "</div>\n";
    echo "</div>\n";
  }
else
  {
    include("./pages/".$action.".htm"); 
  }
echo "</div>\n"; //row

echo "</div>\n";
echo "</div>\n";

include("template/footer.htm");

?>


