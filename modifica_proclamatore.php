<?php
$page="nuovo_proclamatore";
$title="Rapporti > modifica proclamatore";
$thead="Modifica proclamatore";
include('include/config.php');
include('include/general.php');
include('include/functions.php');

if(!isset($_POST['nome']) && !empty($_GET['id'])) {
   $sel=mysqli_query($mysqli, "SELECT * FROM proclamatori AS p LEFT JOIN contatti AS c ON p.id = c.id_p LEFT JOIN gruppi AS g ON p.gruppo_id = g.id WHERE p.id = '{$_GET['id']}'") or die(mysqli_error($mysqli));
   $r=mysqli_fetch_assoc($sel);
  
   /*
   if($r['unto'] == "1") $unto_check="checked"; else $unto_check="";
   if($r['anziano'] == "1") $anziano_check="checked"; else $anziano_check="";
   if($r['servitore'] == "1") $servitore_check="checked"; else $servitore_check="";
   */
   
   
   $unto_check=inputcheck($r['unto'], '1', 'checked');
   $anziano_check=inputcheck($r['anziano'], '1', 'checked');
   $servitore_check=inputcheck($r['servitore'], '1', 'checked');
   
   $pion_check['no']=inputcheck($r['pioniere'], '0', 'selected');
   $pion_check['aus']=inputcheck($r['pioniere'], '2', 'selected');
   $pion_check['reg']=inputcheck($r['pioniere'], '3', 'selected');
   $pion_check['spec']=inputcheck($r['pioniere'], '4', 'selected');
   
    $Body=<<<EOD

      <div id="content-wrapper">
	<section>
	    <h3>Informazioni personali</h3>
	    <form method="POST" action="">
	      <input name="idp" type="hidden" value="{$_GET['id']}">
	      <input name="nome" required type="text" value="{$r['nome']}" placeholder="Nome">
	      <input name="cognome" required type="text" value="{$r['cognome']}" placeholder="Cognome">
	      </br>
	      <label for="d_nascita">Data di nascita</label>
	      <input id="d_nascita" name="d_nascita" type="date" value="{$r['d_nascita']}">
	      </br>
	      <label for="d_battesimo">Data di battesimo</label>
	      <input id="d_battesimo" name="d_battesimo" type="date" value="{$r['d_battesimo']}">
	      </br>
	      <input name="unto" type="checkbox" value="unto" $unto_check/>Unto
	      <input name="anziano" type="checkbox" value="anziano" $anziano_check/>Anziano
	      <input name="servitore" type="checkbox" value="servitore" $servitore_check/>Servitore
	      </br>
	      <label for="pioniere">Pioniere</label>
	      <select id="pioniere" name="pioniere">
		  <option value="0" {$pion_check['no']}>No</option>
		  <option value="2" {$pion_check['aus']}>Ausiliario tempo ind.</option>
		  <option value="3" {$pion_check['reg']}>Regolare</option>
		  <option valuissete="4" {$pion_check['spec']}>Speciale</option>
	      </select>
	</section>
	<section>
	  <h3>Recapiti</h3>
	  <label for="comune">Comune</label>
	  <input id="comune" name="comune" value="{$r['comune']}">
	  </br>
	  <label for="address">Indirizzo</label>
	  <input id="address" name="address" value="{$r['address']}">
	  </br>
	  <label for="n_casa">Numero di casa</label>
	  <input id="n_casa" name="n_casa" value="{$r['n_casa']}">
	  </br>
	  <label for="n_cell">Numero di cell.</label>
	  <input id="n_cell" name="n_cell" value="{$r['n_cell']}">
	  </br>
	</section>
	<section>
      	<h3>Gruppo di servizio</h3>
      	<label for="gruppo">Assegna al gruppo</label>
      	<input type="text" id="gruppo" name="gruppo" value="{$r['nome_gruppo']}">
      	<input type="hidden" id="gruppo_id" name="gruppo_id" value="{$r['gruppo_id']}">
      </section>
    <input type="submit" value="Registra">
    </form>
    </div>
<script type="text/javascript">
	var options = {
		script:"ajax/proc.php?json=true&",
		varname:"gruppo",
		json:true,
		callback: function (obj) { document.getElementById('gruppo_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('gruppo', options);
</script>
EOD;

} elseif(!empty($_POST['nome'])) {
    if(isset($_POST['unto'])) $unto="1"; else $unto="0";
    if(isset($_POST['anziano'])) $anziano="1"; else $anziano="0";
    if(isset($_POST['servitore'])) $servitore="1"; else $servitore="0";
    
  $edit_proc=mysqli_query($mysqli, "UPDATE proclamatori 
      SET gruppo_id 	= '{$_POST['gruppo_id']}', 
      nome 				= '{$_POST['nome']}', 
	  cognome			= '{$_POST['cognome']}', 
	  d_nascita			= '{$_POST['d_nascita']}', 
	  d_battesimo		= '{$_POST['d_battesimo']}', 
	  unto 				= '{$unto}', 
	  anziano			= '{$anziano}', 
	  servitore			= '{$servitore}', 
	  pioniere			= '{$_POST['pioniere']}' 
      WHERE id			= '{$_POST['idp']}'") or die(mysqli_error($mysqli));
      
  $edit_cont=mysqli_query($mysqli, "UPDATE contatti 
      SET comune		= '{$_POST['comune']}', 
	  address			= '{$_POST['address']}', 
	  n_casa			= '{$_POST['n_casa']}', 
	  n_cell			= '{$_POST['n_cell']}'
      WHERE id_p		= '{$_POST['idp']}'") or die(mysqli_error($mysqli));
	

/*
  $ins_cont=mysqli_query($mysqli, "INSERT INTO contatti (id_p, comune, address, n_casa, n_cell) 
  VALUES ('{$mysqli->insert_id}', '{$_POST['comune']}', '{$_POST['address']}', '{$_post['n_casa']}', '{$_POST['n_cell']}')");
*/

  $Body=<<<EOD
  <div id="content-wrapper">
	<section>
	    <h3>Dati aggiornati correttamente</h3>
	</section>
  </div>
EOD;
  
} else {
	$Body=<<<EOD
	<div id="content-wrapper">
      <section>
	  <h3>Seleziona il proclamatore da modificare</h3>
	  <form method="GET" action="">
	  	<input required type="text" id="proclamatore" placeholder="Inserisci il nome"/>
	  	 <input type="hidden" id="proclamatore_id" name="id"/>
	  	<input type="submit" value="Modifica">
	  </form>
      </section>
</div>
<script type="text/javascript">
	var options_gruppo = {
		script:"ajax/proc.php?json=true&",
		varname:"proclamatore",
		json:true,
		callback: function (obj) { document.getElementById('proclamatore_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('proclamatore', options_gruppo);

</script>
EOD;
}

echo $Header;
echo $Body;
echo $Footer;
