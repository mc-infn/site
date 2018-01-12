<?php
function close_tags($html)
{
  /* $doc = new DOMDocument(); */
  /* $doc->loadHTML('<post>'. */
  /* 		 $html. */
  /* 		 '</post>'); */
  /* $cleaned_html = mb_substr( */
  /* 			    $doc->saveXML($doc->getElementsByTagName('body')->item(0)),  */
  /* 			    strlen('<post>'),  */
  /* 			    -strlen('</post>') */
  /* 			    ); */
  $cleaned_html = $html;
  return $cleaned_html;
}

  /* preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result); */

  /* var_dump($result); */

  /* $openedtags = $result[1]; */
  /* preg_match_all('#</([a-z]+)>#iU', $html, $result); */
  /* $closedtags = $result[1]; */
  /*   $len_opened = count($openedtags); */
  /*   if (count($closedtags) == $len_opened) { */
  /*     return $html; */
  /*   } */
  /*   $openedtags = array_reverse($openedtags); */
  /*   for ($i=0; $i < $len_opened; $i++) { */
  /*     if (!in_array($openedtags[$i], $closedtags)) { */
  /* 	$html .= '</'.$openedtags[$i].'>'; */
  /*     } else { */
  /* 	unset($closedtags[array_search($openedtags[$i], $closedtags)]); */
  /*     } */
  /*   } */
  /*   return $html; */

    /* preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result); */
    /* $openedtags = $result[1]; */
    /* preg_match_all('#</([a-z]+)>#iU', $html, $result); */
    /* $closedtags = $result[1]; */
    /* $len_opened = count($openedtags); */
    /* if (count($closedtags) == $len_opened) { */
    /*   return $html; */
    /* } */
    /* $openedtags = array_reverse($openedtags); */
    /* for ($i=0; $i < $len_opened; $i++) { */
    /*   if (!in_array($openedtags[$i], $closedtags)) { */
    /* 	$html .= '</'.$openedtags[$i].'>'; */
    /*   } else { */
    /* 	unset($closedtags[array_search($openedtags[$i], $closedtags)]); */
    /*   } */
    /* } */
    /* return $html; */
/* } */



?>