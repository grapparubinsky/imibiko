<?php
$page="index";
$title="Rapporti > Imibiko";
$thead="Home";
include('include/config.php');
include('include/general.php');

  $Body=<<<EOD

    <div id="content-wrapper">
      <section>
		 
		  
		  <div class="row">
		  <h1>Funzioni principali</h1>
		  	<div class="form-group">
			   <input class="btn btn-lg btn-success" type="button" value="Totali" ONCLICK="window.location.href='totali.php'">
			   <input class="btn btn-lg btn-success" value="Inserimento Rapporti" ONCLICK="window.location.href='inserimento_rapporti.php'">
			   <input class="btn btn-lg btn-success" value="Cartolina" ONCLICK="window.location.href='cartolina.php'">
			</div>
		  </div> <!-- /div .row -->
		  
		  <div class="row">
		  <h2>> Proclamatori</h2>
		  	<div class="form-group">
			  <input class="btn btn-lg btn-primary" type="button" value="Nuovo Proclamatore" ONCLICK="window.location.href='nuovo_proclamatore.php'">
			  <input class="btn btn-lg btn-primary" type="button" value="Modifica Proclamatore" ONCLICK="window.location.href='modifica_proclamatore.php'">
			  </div>
		  </div>
		  <div class="row">
		  <h2>> Gruppi</h2>
		  	<div class="form-group">
			  <input class="btn btn-lg btn-primary" type="button" value="Nuovo Gruppo" ONCLICK="window.location.href='nuovo_gruppo.php'">
			  <input class="btn btn-lg btn-primary" type="button" value="Modifica Gruppo" ONCLICK="window.location.href='modifica_gruppo.php'">
		  	</div>
		  </div>	 
	  </section>
	</div>
EOD;


echo $Header;
echo $Body;
echo $Footer;