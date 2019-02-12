<?php

$config = parse_ini_file('config.ini');
include_once("./template/bb_parse.php");
include_once("./template/code_parse.php");
include_once("./template/close_tags.php");
require_once("./template/htmlpurifier/HTMLPurifier.auto.php");
$config_htmlpurifier = HTMLPurifier_Config::createDefault();
$config_htmlpurifier->set('Cache.DefinitionImpl', null);
$purifier = new HTMLPurifier($config_htmlpurifier);

/* $tidy = new Tidy(); */

if(!empty($_GET['blogaction']))
    {
        $tmp_action = $_GET['blogaction'];
        $filename = "./posts/".$tmp_action;
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
        $file_parts = pathinfo($filename);
        $postTitle = str_replace('_', ' ', $withoutExt);
        echo "<div class=\"well\">";
        echo "<h2>".$postTitle."</h2>";
        echo "<h4><small>".date("F d Y H:i:s.", filectime($filename)) ."</small></h4>";
        switch($file_parts['extension'])
            {
            case "htm":
                include($filename);
                break;
            case "php":
	include($filename);
	break;
            case "txt":
                $file_content = file_get_contents($filename);
                $file_content = code_parse($file_content);
                $htmltext = bb_parse($file_content);
                $words = preg_split('/[\s]+/', $htmltext, -1, PREG_SPLIT_NO_EMPTY);
                foreach($words as $wordNumber=>$word) 
                    {
                        echo $word." ";
                    }
                break;
            }
        echo "</div>"; //well
  }
else
    {
        //     <!-- $files = glob('posts/*.htm', GLOB_BRACE); -->
        
        $files = array();
        $dir = new DirectoryIterator("./posts/");
//    $dir = new RecursiveDirectoryIterator("./posts/");
        foreach ($dir as $fileinfo) 
	  { 
                if (!$fileinfo->isDot() && 
		    strpos($fileinfo->GetFilename(),'~') === false &&
		    strpos($fileinfo->GetFilename(),'#') === false &&
		    !( strpos($fileinfo->getFilename(),".htm" ) === false &&
		       /* strpos($fileinfo->getFilename(),".php" ) === false && */
		       strpos($fileinfo->getFilename(),".txt" ) === false ) &&
		    strpos($fileinfo->getFilename(),"index.htm" ) === false  &&
		    strpos($fileinfo->getFilename(),"index.htm" ) === false  )
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
        $postsPerPage = $config['postsPerPage'];
        $iStartingPost = 0;
        $iPostLimit = $postsPerPage;
        if(!empty($_GET['firstpost']))
	  {
	    $iStartingPost = $_GET['firstpost'];
	    $iPostLimit = $iStartingPost + $postsPerPage;
	  }
        if ( $iPostLimit > sizeof($files) )
	  {
                $iPostLimit = sizeof($files);
	  }
        
        for ($iPost=$iStartingPost; $iPost<$iPostLimit; $iPost++)
	  {
	    $thisfile = $files[$iPost];
	    $filename = "./posts/".$thisfile;
	    $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
	    $file_parts = pathinfo($filename);
	    $postTitle = str_replace('_', ' ', $withoutExt);
	    echo "<div class=\"well\">";
	    echo "<h2>";
	    if(array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
	      {
		echo "<a href=post/".$thisfile.">";
	      }
                else
		  {
		    echo "<a href=?action=Blog&blogaction=".$thisfile.">";
		  }
	    echo $postTitle;
	    echo "</a></h2>";
	    echo "<h4><small>".date("d F Y", filectime($filename)) ."</small></h4>";
	    echo "<hr />";
            
	    /* echo "<p>"; */
	    $thereIsMore = FALSE;
	    /* $thisfile = fopen($filename,"r"); */
	    /* for ($iPostLine=0; $iPostLine<600; $iPostLine++) */
	    /*   { */
	    /*     if(feof($thisfile)) */
	    /*       { */
	    /* 	break; */
	    /* 	$thereIsMore = FALSE; */
	    /* 				 echo "test <br />"; */
	    /*       } */
	    /*     echo fgetc($thisfile); */
	    /*   } */
	    $contents = file_get_contents($filename);
	    if($file_parts['extension']=="txt")
	      {
		$contents = code_parse($contents);
		$contents = bb_parse($contents);
	      }
	    
	    /* $contents = $tidy->repairString($contents, array( */
	    /* 					 'output-xml' => true, */
	    /* 					 'input-xml' => true */
	    /* 					 )); */
	    /* $lines = explode("\n", $contents); */
	    /* $contents_cleaned = close_tags($contents); */
	    /* $contents_cleaned = $contents; */
	    $contents_cleaned = $purifier->purify($contents);
            
	    $words = preg_split('/[\s]+/', $contents_cleaned, -1, PREG_SPLIT_NO_EMPTY);
            
	    $final_content = "";
	    foreach($words as $wordNumber=>$word) 
	      {
		$final_content.=$word;
		if($wordNumber>$config['nWordsBlogPreview']) 
		  {
		    $thereIsMore = TRUE;
		    break;
		  }
		else
		  {
		    /* echo " "; */
		    $final_content.=" ";
		  }
	      }
	    $final_content = $purifier->purify($final_content);
	    if($thereIsMore)
	      {				   
		/* echo "...<br /><a href=?action=Blog&blogaction=".$withoutExt.">"; */
		/* echo "Read more</a>"; */
		if(array_key_exists('HTTP_MOD_REWRITE', $_SERVER))
		  {
		    $final_content.="<br /><a href=post/".$thisfile.">";
		  }
		else
		  {
		    $final_content.="<br /><a href=?action=Blog&blogaction=".$thisfile.">";
		  }
		$final_content.="Read more</a>";		  
	      }
	    /* echo "</p>"; */
	    echo $final_content;
            
	    echo "</div>\n"; //well
	  }
        
        echo"<div>\n";
        
        echo "<nav aria-label=\"...\"> \n";
        echo "  <ul class=\"pager\"> \n";
        if ($config['debug'])
	  {
	    echo "first post: ";
	    echo $iStartingPost;
	    echo " number of files: ";
	    echo sizeof($files);
	    echo "<br /> post per page: ";
	    echo $postsPerPage;
	    echo " differece: ";
	    echo  ($postsPerPage-$iStartingPost);
	  }
        if( sizeof($files)>$postsPerPage && ($postsPerPage-$iStartingPost)>0 )
	  {
	    echo "<li class=\"previous\">";
	    $tmp = $iStartingPost + $postsPerPage;
	    echo "<a href=\"?action=Blog&firstpost=";
	    echo $tmp;
	    echo"\">";
	  }
        else
	  {
	    echo "<li class=\"previous disabled\">";
	    echo "<a ";//href=\"?action=Blog&firstpost=";
	    echo $iStartingPost;
	    echo "\">";
	  }
        echo "<span aria-hidden=\"true\">&larr;</span> \n";
        echo "Older posts \n";
        echo "</a></li> \n";
        
        
        if( $iStartingPost > 0 )
	  {
	    echo "<li class=\"next\">";
	    $tmp = $iStartingPost - $postsPerPage;
	    echo "<a href=\"?action=Blog&firstpost=";
	    echo $tmp;
	    echo "\">";
	  }
        else
	  {
	    echo "<li class=\"next disabled\">";
	    echo "<a ";//href=\"?action=Blog&firstpost=";
	    echo $iStartingPost;
	    echo "\">";
	  }
        echo "Newer posts \n";
        echo "<span aria-hidden=\"true\">&rarr;</span> \n";
        echo "</a></li> \n";
        
        
        echo "</ul> \n";
        echo "</nav> \n";
        echo "<hr />";
        echo "</div>";
        
        
        
	/*    <li class="next"><a href="#">Newer <span aria-hidden="true">&rarr;</span></a></li> */
        
    }
?>
