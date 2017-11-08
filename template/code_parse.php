<?php
function code_parse($content)
{
    $pattern = array(
		     "<",
		     ">",
		     );
    $replacement = array(
			 "&lt;",
			 "&gt;",
			 );

    $content = str_replace($pattern, $replacement, $content);

    return $content;
}
?>