<?php
$config = parse_ini_file('config.ini');
require_once("./template/htmlpurifier/HTMLPurifier.auto.php");
include_once("./template/bb_parse.php");

function find_word_infile($to_be_found, $dirname, $filename) 
{
 /* echo "find_word_infile($to_be_found, $filename) <br />"; */
  $contents = strip_tags(file_get_contents($dirname."/".$filename));
  /* $contents_cleaned = $purifier->purify($contents); */
  /* $htmltext = bb_parse($file_content); */
  $words = preg_split('/[\s]+/', $contents, -1, PREG_SPLIT_NO_EMPTY);
  foreach($words as $wordNumber=>$word)
    {
      if (stripos($word, $to_be_found) !== false)
	{
	  $nWordToBeReturned = 12;
	  $selectedWordNumber = $wordNumber-$nWordToBeReturned/2;
	  if($selectedWordNumber<0) $selectedWordNumber=0;
	  return array_slice($words, $selectedWordNumber, $nWordToBeReturned);
	}
    }
  /* $words = preg_split('/[\s]+/', $contents_cleaned, -1, PREG_SPLIT_NO_EMPTY); */
  /* foreach($words as $word) */
  /*   { */
  /*     if */
  /*   } */
  // $input is the word being supplied by the user
  /* $handle = @fopen($file, "r"); */
  /* if ($handle)  */
  /*   { */
  /*     echo "handle"; */
  /*     while (!feof($handle))  */
  /* 	{ */
  /* 	  $entry_array = explode(":",fgets($handle)); */
  /* 	  if ($entry_array[0] == $input)  */
  /* 	    { */
  /* 	      echo "	    return $entry_array[1];	    "; */
  /* 	      return $entry_array[1];	     */
  /* 	    } */
  /* 	} */
  /*     fclose($handle); */
  /*   } */
  /* echo "NULL"; */
  return NULL;
}

function list_all_files_indir($dirname)
{
  $config = parse_ini_file('config.ini');
  $disallowed_paths = $config['disable_pages'];
  $results = array();
  $dir = new DirectoryIterator($dirname);
  foreach ($dir as $fileinfo) 
    if (!$fileinfo->isDot())
      {
	$filename = $fileinfo->getFilename();
	if ((strpos($filename, '~') === false) && 
	    (strpos($filename, '#') === false) &&
	    (!in_array($filename, $disallowed_paths)))
	  {
	    if($fileinfo->isDir())
	      {
		$tmp = list_all_files_indir($dirname.$filename);
		foreach ($tmp as &$value)
		  {
		    $value = $filename."/".$value;
		  }
		$merged = array_merge($results, $tmp);
		$results = $merged;
	      }
	    else
	      {
		$results[] = $filename;
	      }
	  }
      }
  return $results;
}

function find_word_indir($input, $dir)
{
  $results = array();
  $allfiles = list_all_files_indir($dir);
  foreach ($allfiles as $file)
    {
      $founds = find_word_infile($input, $dir, $file);
      if($founds)
	{
	  /* echo "<h2>Found</h2>"; */
	  /* echo $file; */
	  /* print_r($founds); */
	  $results[] = array_merge( array($file), $founds);
	}
      /* echo "<br />"; */
	  
    }
  return $results;
}

/* echo "<h1>search</h1>"; */
/* $toBeFound = "Geniale"; */
/* find_word_indir($toBeFound, "../pages/"); */
/* find_word_indir($toBeFound, "../posts/"); */

?>