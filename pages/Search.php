<?php

$config = parse_ini_file('config.ini');
include_once("./template/search.php");

$disallowed_paths = array('header', 'footer'); 
if (isset($config['disable_pages']))
  {
    $disallowed_paths = array_merge($disallowed_paths,  $config['disable_pages'] );
  }

if(!empty($_GET['search']))
  {
    $word_to_search = $_GET['search'];
    echo "<h2>Results looking for \"$word_to_search\"</h2>";
    $found_pages = find_word_indir($word_to_search, "./pages/"); 
    if(!empty($found_pages))
      {
	echo "<h2>Pages:</h2>";
	foreach ($found_pages as $page)
	  {
	    $filename = $page[0];
	    if ((strpos($filename, '~') === false) && 
		(strpos($filename, '#') === false) &&
		(strpos($filename, 'Home') === false) &&
		(!in_array($filename, $disallowed_paths)))
	      {
		$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		$withoutNum = preg_replace('/^\d/', '', $withoutExt);
		$withoutUnder = str_replace('_', ' ', $withoutNum);
		echo "<div class=\"well\">"; 
		echo "<h3><a href=\"?action=$withoutExt\">".$withoutUnder."</a></h3>";
		echo "<hr />";
		echo "<p>";
		foreach (array_slice($page,1) as $word)
		  {
		    echo " ".$word;
		  }
		echo "... </p>";
		echo"</div>\n";
	      }	    
	  }
      }
    else
      {
	echo "<br />\n";
	echo "<h4> Not found among pages </h4>\n";
	echo "<br />\n";
      }
    
    $found_posts = find_word_indir($word_to_search, "./posts/");
    if(!empty($found_posts))
      {
	echo "<h2>Blog posts:</h2>";
	foreach ($found_posts as $page)
	  {
	    $filename = $page[0];
	    if ((strpos($filename, '~') === false) && 
		(strpos($filename, '#') === false) &&
		(strpos($filename, 'Home') === false) &&
		(!in_array($filename, $disallowed_paths)))
	      {
		$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
		$withoutNum = preg_replace('/^\d/', '', $withoutExt);
		$withoutUnder = str_replace('_', ' ', $withoutNum);
		echo "<div class=\"well\">"; 
		echo "<h3><a href=\"?action=Blog&blogaction=$filename\">$withoutUnder </a></h3>";
		echo "<hr />";
		echo "<p>";		
		foreach (array_slice($page,1) as $word)
		  {
		    echo " ".$word;
		  }
		echo "... </p>";
		echo"</div>\n";
	      }	    
	  }
      }
    else
      {
	echo "<br />\n";
	echo "<h4> Not found among blog posts </h4>";
	echo "<br />\n";
      }
  }
else
  {
    echo "<h2> Search page </h2>";
  }
?>