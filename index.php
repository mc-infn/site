<?php 
ini_set('display_errors', 'On');

function directoryToList($dirname, $disallowed_paths, $action)
{
    $dir = new DirectoryIterator($dirname);
    
    include("./template/navhead.htm");
    include_once("./template/bb_parse.php");
    include_once("./template/code_parse.php");
    include_once("./template/close_tags.php");
    /* require_once './htmlpurifier/HTMLPurifier.auto.php'; */
    /* $config_htmlpurifier = HTMLPurifier_Config::createDefault(); */
    /* $config_htmlpurifier->set('Cache.DefinitionImpl', null); */
    /* $purifier = new HTMLPurifier($config_htmlpurifier); */
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
                                    echo "<a href=";
                                    if(! array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
                                        {
                                            echo "\"?action=\"";
                                        }
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
                                                            echo "<li><a href=";
                                                            if(! array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
                                                                {
                                                                    echo "?action=";
                                                                    
                                                                }
                                                            
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
                                    echo "<a href=";
                                    if(! array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
                                        {
                                            echo "?action=";
                                        }
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
if (isset($config['disable_pages']))
  {
    $disallowed_paths = array_merge($disallowed_paths,  $config['disable_pages'] );
  }

if (!empty($_GET['action'])) 
    { 
        //$tmp_action = basename($_GET['action']); 
        $tmp_action = $_GET['action'];
        /* echo "./pages/".$tmp_action.".htm"; */
        
        // If it's not a disallowed path, and if the file exists, update $action 
        if (!in_array($tmp_action, $disallowed_paths) 
	    && (file_exists("./pages/".$tmp_action.".php")
		|| file_exists("./pages/".$tmp_action.".htm") 
		|| file_exists("./pages/".$tmp_action.".txt") ))
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
$noSidebar = array();
if (isset($config['no_sidebar_pages']))
  {
    $noSidebar = $config['no_sidebar_pages'];
  }
if(!in_array($withoutUnder, $noSidebar))
    {
        echo "<div class=\"col-sm-9\">\n";
        /* echo "<div class=\"well\">";  */
        // Include $action 
	if (file_exists("./pages/".$action.".php"))
	  {
	    include("./pages/".$action.".php"); 
	  }
	else if (file_exists("./pages/".$action.".htm"))
	  {
	    include("./pages/".$action.".htm"); 
	  }
	else if (file_exists("./pages/".$tmp_action.".txt"))
	    {
	      $filename="./pages/".$tmp_action.".txt";
	      $file_content = file_get_contents($filename);
	      $file_content = code_parse($file_content);
	      $htmltext = bb_parse($file_content);
	      $words = preg_split('/[\s]+/', $htmltext, -1, PREG_SPLIT_NO_EMPTY);
	      foreach($words as $wordNumber=>$word)
	  	{
	  	  echo $word." ";
	  	}
	    }
        /* echo "</div>\n"; */
        echo "</div>\n";
        
        echo "<div class=\"col-sm-3\">\n";
	include("template/ServerTime.php"); 
	include("template/sidebar.php"); 
        echo "</div>\n";
    }
else
    {
      if (file_exists("./pages/".$action.".htm"))
	{
	  include("./pages/".$action.".htm"); 
	}
      else if (file_exists("./pages/".$tmp_action.".txt"))
	  {
	    $filename="./pages/".$tmp_action.".txt";
	    $file_content = file_get_contents($filename);
	    $file_content = code_parse($file_content);
	    $htmltext = bb_parse($file_content);
	    $words = preg_split('/[\s]+/', $htmltext, -1, PREG_SPLIT_NO_EMPTY);
	    foreach($words as $wordNumber=>$word)
	      {
		echo $word." ";
	      }
	  }
      }
echo "</div>\n"; //row

echo "</div>\n";
echo "</div>\n";

include("template/footer.htm");
//ciao
?>


