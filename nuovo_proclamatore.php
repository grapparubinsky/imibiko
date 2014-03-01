<?php
$page="nuovo_proclamatore";
$title="Rapporti > nuovo proclamatore";
$thead="Nuovo proclamatore";
include('include/config.php');
include('include/general.php');

if(!isset($_POST['nome'])) {

  $Body=<<<EOD

    <div id="content-wrapper">
      <section>
	  <h3>Informazioni personali</h3>
	  <form method="POST" action="">
	    <input name="nome" required type="text" value="" placeholder="Nome">
	    <input name="cognome" required type="text" value="" placeholder="Cognome">
	    </br>
	    <label for="d_nascita">Data di nascita</label>
	    <input id="d_nascita" name="d_nascita" type="date" value="">
	    </br>
	    <label for="d_battesimo">Data di battesimo</label>
	    <input id="d_battesimo" name="d_battesimo" type="date" value="">
	    </br>
	    <input name="unto" type="checkbox" value="unto"/>Unto
	    <input name="anziano" type="checkbox" value="anziano"/>Anziano
	    <input name="servitore" type="checkbox" value="servitore"/>Servitore
	    </br>
	    <label for="pioniere">Pioniere</label>
	    <select id="pioniere" name="pioniere">
		<option value="0">No</option>
		<option value="1">Ausiliario tempo ind.</option>
		<option value="2">Regolare</option>
		<option value="3">Speciale</option>
	    </select>
      </section>
      <section>
		<h3>Recapiti</h3>
		<label for="comune">Comune</label>
		<input id="comune" name="comune" value="">
		</br>
		<label for="address">Indirizzo</label>
		<input id="address" name="address" value="">
		</br>
		<label for="n_casa">Numero di casa</label>
		<input id="n_casa" name="n_casa" value="">
		</br>
		<label for="n_cell">Numero di cell.</label>
		<input id="n_cell" name="n_cell" value="">
		</br>
      </section>
      <section>
      	<h3>Gruppo di servizio</h3>
      	<label for="gruppo">Assegna al gruppo</label>
      	<input type="text" id="gruppo" name="gruppo" value="">
      	<input type="hidden" id="gruppo_id" name="gruppo_id" value="">
      </section>
    <input type="submit" value="Registra">
    </form>
    </div>
<script type="text/javascript">
	var options = {
		script:"proc_ajax.php?json=true&",
		varname:"gruppo",
		json:true,
		callback: function (obj) { document.getElementById('gruppo_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('gruppo', options);
</script>
EOD;
} else {

  if(isset($_POST['unto'])) $unto="1"; else $unto="0";
  if(isset($_POST['anziano'])) $anziano="1"; else $anziano="0";
  if(isset($_POST['servitore'])) $servitore="1"; else $servitore="0";
  
$ins_proc=mysqli_query($mysqli, "INSERT INTO proclamatori (gruppo_id, nome, cognome, d_nascita, d_battesimo, unto, anziano, servitore, pioniere) 
VALUES ('{$_POST['gruppo_id']}', '{$_POST['nome']}', '{$_POST['cognome']}', '{$_POST['d_nascita']}', '{$_POST['d_battesimo']}', '$unto', '$anziano', '$servitore', '{$_POST['pioniere']}')") or die(mysqli_error($mysqli));

$ins_cont=mysqli_query($mysqli, "INSERT INTO contatti (id_p, comune, address, n_casa, n_cell) 
VALUES ('{$mysqli->insert_id}', '{$_POST['comune']}', '{$_POST['address']}', '{$_POST['n_casa']}', '{$_POST['n_cell']}')");

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