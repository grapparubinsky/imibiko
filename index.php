<?php
$page="index";
$title="Rapporti > Imibiko";
$thead="Home";
include('include/config.php');
include('include/general.php');

  $Body=<<<EOD

    <div id="content-wrapper">
      <section>
		  <h3>Naviga nel sito</h3>
		  <br/>
		  <input type="button" value="Totali" ONCLICK="window.location.href='totali.php'">
		  <input type="button" value="Inserimento Rapporti" ONCLICK="window.location.href='inserimento_rapporti.php'"></br>
		  <input type="button" value="Nuovo Proclamatore" ONCLICK="window.location.href='nuovo_proclamatore.php'">
		  <input type="button" value="Nuovo Gruppo" ONCLICK="window.location.href='nuovo_gruppo.php'">
		  <input type="button" value="Modifica Gruppo" ONCLICK="window.location.href='modifica_gruppo.php'">
		  <input type="button" value="Modifica Proclamatore" ONCLICK="window.location.href='modifica_proclamatore.php'">
	  </section>
	</div>
EOD;


echo $Header;
echo $Body;
echo $Footer;