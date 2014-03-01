<?php
$page="nuovo_gruppo";
$title="Rapporti > nuovo gruppo";
$thead="Nuovo Gruppo di servizio";
include('include/config.php');
include('include/general.php');
if(!isset($_POST['nome_gruppo'])) {
$_js="\$";
  $Body=<<<EOD
    <div id="content-wrapper">
	      <section>
		  <h3>Informazioni personali</h3>
		  <form method="POST" action="">
		    <input name="nome_gruppo" required type="text" value="" placeholder="Nome Gruppo">
		 
		    </br>
		    <label for="sorvegliante">Sorvegliante del gruppo</label>
		    <input required type="text" id="sorvegliante" placeholder="Inserisci il nome" />
		    <input type="hidden" id="sorvegliante_id" name="sorvegliante_id" value=""/>
		    </br>
		    <label for="assistente">Assistente</label>
		    <input required id="assistente" name="assistente" type="text" value="">
		    <input type="hidden" id="assistente_id" name="assistente_id" value=""/>
		    </br>
	      </section>
	    <input type="submit" value="Registra">
	    </form>
    </div>
<script type="text/javascript">
	var options_sorvegliante = {
		script:"proc_ajax.php?json=true&",
		varname:"nominati",
		json:true,
		callback: function (obj) { document.getElementById('sorvegliante_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('sorvegliante', options_sorvegliante);
	
	var options_assistente = {
		script:"proc_ajax.php?json=true&",
		varname:"nominati",
		json:true,
		callback: function (obj) { document.getElementById('assistente_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('assistente', options_assistente);

</script>
EOD;
} else {
  
$ins_gruppo=mysqli_query($mysqli, "INSERT INTO gruppi (nome_gruppo, sorvegliante_id, assistente_id) 
VALUES ('{$_POST['nome_gruppo']}', '{$_POST['sorvegliante_id']}', '{$_POST['assistente_id']}')") or die(mysqli_error($mysqli));

$Body=<<<EOD
<div id="content-wrapper">
      <section>
	  <h3>Dati inseriti correttamente</h3>
      </section>
</div>
EOD;
}

echo $Header;
echo $Body;
echo $Footer;