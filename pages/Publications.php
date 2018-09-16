<?php
$config = parse_ini_file('config.ini');
require_once("./template/bibtex2html.php");         

if (isset($config['scopus_id']))
  {
    echo "<p>For a summary of my bibliometric index you could visit ";
    echo "<a href=\"https://www.scopus.com/authid/detail.uri?authorId=";
    echo $config['scopus_id'];
    echo "\" target=\"blank\">SCOPUS</a>";
    echo ".</p>";
  }

if (isset($config['orcid_id']))
  {
    echo "<p>For a summary of my bibliometric index you could visit ";
    echo "<a href=\"https://orcid.org/";
    echo $config['orcid_id'];
    echo "\" target=\"blank\">ORCID</a>";
    echo ".</p>";
  }

if (isset($config['mark_if_im_corr']))
  {
    echo "<p>The ";
    echo $config['mark_if_im_corr'];
    echo " indicates I am the corresponding author.</p>";
  }
  
if (isset($config['bibliography']))
  {
    echo bibfile2html($config['bibliography'],  /*     bibfile2html($filename,      // string                                  */
		      NULL,				 /*                  $displayTypes,  // array(string => string)                 */
		      false,				 /*                  $groupType,     // bool                                    */
		      true,				 /*                  $groupYear,     // bool                                    */
		      NULL,				 /*                  $bibLink,       // string                                  */
		      "Mancini-Terracciano",		 /*                  $highlightName, // string                                  */
		      false,				 /*                  $numbersDesc,   // bool                                    */
		      NULL,				 /*                  $sorting,       // string or array(string)                 */
		      3);					 /*                  $authorLimit,   // int                                     */
    /*                  $abstractLink,  // string                                  */            
    
    /*bibtex2html interprets several non-standard BibTeX fields:
      
     *) url: The content of this field is assumed to be the url of the venue. It is used on the "in" part of the citation. If there is no "in" part, a "more..." link is displayed at the end.
     
     *) webpdf: This is assumed to be a link to the pdf file of the given publication (the title becomes clickable and a "pdf..." link is displayed).
     
     *) publisherurl: The url of the publisher, used on the "publisher" part of the citation. If there is none, a "publisher..." link is displayed at the end.
     
     *) citeseerurl: The citeseer url (displayed as "citeseer...").
     doi: This is supposed to be DOI name from dx.doi.org (displayed as "doi...").
     
    */
  }
else
  {
    echo "<p>Copy a bib file in yout home directory and set the filename in the config.ini file</p> \n";
  }

?>
