<?php
if($page=="nuovo_gruppo" OR $page=="nuovo_proclamatore") {
	$other_calls=<<<EOD
		<script type="text/javascript" src="{$BASE_URL}/js/bsn.AutoSuggest_c_2.0.js"></script>
		<link rel="stylesheet" href="{$BASE_URL}/css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
EOD;
} else {
	$other_cass="";
}

$Header=<<<EOD
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset='utf-8'>
   <title>$title</title>
  <link rel="stylesheet" href="{$BASE_URL}/css/report.style.css">
  $other_calls
</head>
<body>
  <div id="header-wrapper">
	  <div id="header">
		  <div class="logo">
			  <a href="{$BASE_URL}/"><h3>imibiko.</h3></a>
		  </div>
		  <h1 style="float:left">$thead</h1>
		  <div style="clear:both"></div>
	  </div>
  </div>
EOD;

$Footer=<<<EOD
</body>
</html>
EOD;
