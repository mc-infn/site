<?php 
/* function bb_parse($string) {  */
  /* $tags = 'b|i|size|color|center|quote|code|url|img';  */
  /* while (preg_match_all('`\[('.$tags.')=?(.*?)\](.+?)\[/\1\]`', $string, $matches)) foreach ($matches[0] as $key => $match) {  */
  /*     list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]);  */
  /*     switch ($tag) {  */
  /*     case 'b': $replacement = "<strong>$innertext</strong>"; break;  */
  /*     case 'i': $replacement = "<em>$innertext</em>"; break;  */
  /*     case 'size': $replacement = "<span style=\"font-size: $param;\">$innertext</span>"; break;  */
  /*     case 'color': $replacement = "<span style=\"color: $param;\">$innertext</span>"; break;  */
  /*     case 'center': $replacement = "<div class=\"centered\">$innertext</div>"; break;  */
  /*     case 'quote': $replacement = "<blockquote>$innertext</blockquote>" . $param? "<cite>$param</cite>" : ''; break;      case 'code': $replacement = "<code><pre>$innertext</code></pre>"; break;  */

  /*     case 'url': $replacement = '<a href="' . ($param? $param : $innertext) . "\">$innertext</a>"; break;  */
  /*     case 'img':  */
  /* 	list($width, $height) = preg_split('`[Xx]`', $param);  */
  /* 	$replacement = "<img src=\"$innertext\" " . (is_numeric($width)? "width=\"$width\" " : '') . (is_numeric($height)? "height=\"$height\" " : '') . '/>';  */
  /* 	break;  */
  /*     case 'video':  */
  /* 	$videourl = parse_url($innertext);  */
  /* 	parse_str($videourl['query'], $videoquery);  */
  /* 	if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>';  */
  /* 	if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>';  */
  /* 	break;  */
  /*     }  */
  /*     $string = str_replace($match, $replacement, $string);  */
  /*   }  */
  /* return $string;  */
  /* }  */

function bb_parse($content, $nl2br = true) 
{
    $pattern = array(
        "/\[b\](.*)\[\/b\]/is",
        "/\[u\](.*)\[\/u\]/is",
        "/\[i\](.*)\[\/i\]/is",
        "/\[quote\](.*)\[\/quote\]/is",
        "/\[code\](.*)\[\/code\]/is",
        "/\[color=([^\[\<]+?)\](.*)\[\/color\]/is",
        "/\[font=([^\[\<]+?)\](.*)\[\/font\]/is",
        "/\[size=(\d+?)\](.*)\[\/size\]/is",
        "/\[url\](.*)\[\/url\]/i",
        "/\[url=(.*)\](.*)\[\/url\]/i",
        "/\[flash=(\d+),(\d+)\]\s*([^\[\<\r\n]+?)\s*\[\/flash\]/i",
        "/\[swf\]\s*([^\[\<\r\n]+?)\s*\[\/swf\]/i",
        "/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/i",
    );
    
    $replacement = array(
        "<b>\\1</b>",
        "<u>\\1</u>",
        "<i>\\1</i>",
        "<blockquote>\\1</blockquote>",
	"<pre><code>\\1</code></pre>",
        "<font color=\"\\1\">\\2</font>",
        "<font face=\"\\1\">\\2</font>",
        "<font size=\"\\1\">\\2</font>",
        "<a href=\"\\1\" target=\"_blank\">\\1</a>",
        "<a href=\"\\1\" target=\"_blank\">\\2</a>",
        "<p><embed width=\"\\1\" height=\"\\2\" src=\"\\3\"></embed></p>",
        "<p><embed width=\"500\" height=\"400\" src=\"\\1\"></embed></p>",
        "<a href=\"\\1\" target=\"_blank\"><img src=\"\\1\" alt=\"\\1\" border=\"0\" /></a>",
    );
    
    $content = preg_replace($pattern, $replacement, $content);
    
    $content = $nl2br === true ? nl2br($content) : $content;
    
    return $content;
}

?> 