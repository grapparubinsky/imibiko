<?php
$page="nuovo_gruppo";
$title="Rapporti > modifica gruppo";
$thead="Modifica Gruppo di servizio";
include('include/config.php');
include('include/general.php');
include('include/functions.php');

if(!isset($_POST['nome_gruppo']) && !empty($_GET['id'])) {
		
	$sel=mysqli_query($mysqli, "SELECT * FROM gruppi WHERE id = '{$_GET['id']}'") or die(mysqli_error($mysqli));
   	$r=mysqli_fetch_assoc($sel);
	
	$sor=mysqli_query($mysqli, "SELECT g.id, g.sorvegliante_id, p.nome, p.cognome FROM gruppi AS g JOIN proclamatori AS p ON g.sorvegliante_id = p.id WHERE g.id = '{$_GET['id']}'") or die(mysqli_error($mysqli));
   	$r_sor=mysqli_fetch_assoc($sor);
	
	$ass=mysqli_query($mysqli, "SELECT g.id, g.assistente_id, p.nome, p.cognome FROM gruppi AS g JOIN proclamatori AS p ON g.assistente_id = p.id WHERE g.id = '{$_GET['id']}'") or die(mysqli_error($mysqli));
   	$r_ass=mysqli_fetch_assoc($ass);
  //print_r($r);
  $Body=<<<EOD
    <div id="content-wrapper">
	      <section>
		  <h3>Informazioni personali</h3>
		  <form method="POST" action="">
		    <input name="nome_gruppo" required type="text" value="{$r['nome_gruppo']}" placeholder="Nome Gruppo">
		 	<input type="hidden" name="gruppo_id" value="{$_GET['id']}">
		    </br>
		    <label for="sorvegliante">Sorvegliante del gruppo</label>
		    <input required type="text" id="sorvegliante" placeholder="Inserisci il nome" value="{$r_sor['nome']} {$r_sor['cognome']}"/>
		    <input type="hidden" id="sorvegliante_id" name="sorvegliante_id" value="{$r_sor['sorvegliante_id']}"/>
		    </br>
		    <label for="assistente">Assistente</label>
		    <input required id="assistente" name="assistente" type="text" value="{$r_ass['nome']} {$r_ass['cognome']}">
		    <input type="hidden" id="assistente_id" name="assistente_id" value="{$r_ass['assistente_id']}"/>
		    </br>
	      </section>
	    <input type="submit" value="Registra">
	    </form>
    </div>
<script type="text/javascript">
	var options_sorvegliante = {
		script:"ajax/proc.php?json=true&",
		varname:"nominati",
		json:true,
		callback: function (obj) { document.getElementById('sorvegliante_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('sorvegliante', options_sorvegliante);
	
	var options_assistente = {
		script:"ajax/proc.php?json=true&",
		varname:"nominati",
		json:true,
		callback: function (obj) { document.getElementById('assistente_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('assistente', options_assistente);

</script>
EOD;
}  elseif(!empty($_POST['nome_gruppo'])) {
	$edit_gruppo=mysqli_query($mysqli, "UPDATE gruppi
	      SET nome_gruppo	= '{$_POST['nome_gruppo']}', 
		  sorvegliante_id	= '{$_POST['sorvegliante_id']}', 
		  assistente_id		= '{$_POST['assistente_id']}'
	      WHERE id			= '{$_POST['gruppo_id']}'") or die(mysqli_error($mysqli));
	      
$Body=<<<EOD
<div id="content-wrapper">
      <section>
	  <h3>Dati inseriti correttamente</h3>
      </section>
</div>
EOD;
} else {
	$Body=<<<EOD
	<div id="content-wrapper">
      <section>
	  <h3>Seleziona il gruppo da modificare</h3>
	  <form method="GET" action="">
	  	<input required type="text" id="gruppo" placeholder="Inserisci il gruppo"/>
	  	 <input type="hidden" id="gruppo_id" name="id"/>
	  	<input type="submit" value="Modifica">
	  </form>
      </section>
</div>
<script type="text/javascript">
	var options_gruppo = {
		script:"ajax/proc.php?json=true&",
		varname:"gruppo",
		json:true,
		callback: function (obj) { document.getElementById('gruppo_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('gruppo', options_gruppo);

</script>
EOD;
}

echo $Header;
echo $Body;
echo $Footer;