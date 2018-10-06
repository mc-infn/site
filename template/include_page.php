<?php
include_once("./template/bb_parse.php");
include_once("./template/code_parse.php");

function include_page($filename, $directory="./pages")
{
  if (file_exists("./pages/".$filename.".php"))
    {
      include("./pages/".$filename.".php"); 
    }
  else if (file_exists("./pages/".$filename.".htm"))
    {
      include("./pages/".$filename.".htm"); 
    }
  else if (file_exists("./pages/".$filename.".txt"))
    {
      $filename="./pages/".$filename.".txt";
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

?>