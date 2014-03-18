<?php
$page="visualizza_rapporti";
$title="Rapporti > visualizza rapporti";
$thead="Visualizzazione Rapporti";
include('include/config.php');
include('include/functions.php');
$_js="\$";
//echo '<pre>';
//print_r($GLOBALS);
if(empty($_POST['mese']) && empty($_POST['anno'])) {
 date_default_timezone_set('Europe/Rome');
 $currentYear = date('Y');
 $yearoption="";
        foreach (range($currentYear-1, $currentYear+3) as $value) {
        	if($value==$currentYear) $yearselected="selected"; else $yearselected="";
           $yearoption.= "<option value='$value' $yearselected>{$value}</option>";
        }
  $Body=<<<EOD
    <div id="content-wrapper">
	      <section>
		  	<h3>Filtra</h3>
		  	<form method="POST" action="" id="ajaxform">
		  	<label for="mese">Mese</label>
		  	<select name="mese">
		  		<option value="">---</option>
		  		<option value="1">Gennaio</option>
		  		<option value="2">Febbraio</option>
		  		<option value="3">Marzo</option>
		  		<option value="4">Aprile</option>
		  		<option value="5">Maggio</option>
		  		<option value="6">Giugno</option>
		  		<option value="7">Luglio</option>
		  		<option value="8">Agosto</option>
		  		<option value="9">Settembre</option>
		  		<option value="10">Ottobre</option>
		  		<option value="11">Novembre</option>
		  		<option value="12">Dicembre</option>
		  	</select>
		  	<select name="anno">
		  		$yearoption
		  	</select>
		  	</br>
		    <label for="nome_gruppo">Gruppo di servizio </label>
		    <input id="gruppo" name="nome_gruppo" type="text" value="">
		    <input type="hidden" id="gruppo_id" name="gruppo_id" value="">
		    </br>
		    <label for="proclamtore">Proclamatore</label>
		    <input id="proclamatore" name="nome_proclamatore" type="text" value="">
		    <input type="hidden" id="id_p" name="id_p" value="">
		    <input type="submit" value="Filtra">
	   	 </form>
	   	</section>
  	</div>
<script type="text/javascript">
	var options = {
		script:"ajax/proc.php?json=true&",
		varname:"gruppo",
		json:true,
		callback: function (obj) { document.getElementById('gruppo_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('gruppo', options);
	
	var options2 = {
		script:"ajax/proc.php?json=true&",
		varname:"proclamatore",
		json:true,
		callback: function (obj) { document.getElementById('id_p').value = obj.id; }
	};
	var as_json = new AutoSuggest('proclamatore', options2);
</script>
<script>
			function submitForm() {
			    $_js.ajax({type:'GET', url: 'ajax/rapp.php', data:$_js('#ajaxform').serialize(), success: function(response) {
			        $_js('#results').find('.form_result').html(response);
			      
			    }});
			
			    return false;
			}
</script>
EOD;
} else {
	if(empty($_POST['id_p']) || empty($_POST['gruppo_id'])) {
		
		if($_POST['mese'] < 10) {
			$mese="0{$_POST['mese']}";
		}
		$thead="Rapporti {$mese}/{$_POST['anno']}";
		
		$tot_proc=mysqli_query($mysqli, "SELECT COUNT(id) AS proclamatori,
			(SELECT COUNT(unto) FROM proclamatori WHERE unto = '1') AS unti,
			(SELECT COUNT(anziano) FROM proclamatori WHERE anziano = '1') AS anziani,
			(SELECT COUNT(servitore) FROM proclamatori WHERE servitore = '1') AS servitori,
			(SELECT COUNT(pioniere) FROM proclamatori WHERE pioniere = '0') AS n_proc,
			(SELECT COUNT(pioniere) FROM proclamatori WHERE pioniere = '1') AS n_pion_aus_ind,
			(SELECT COUNT(pioniere) FROM proclamatori WHERE pioniere = '2') AS n_pion_reg,
			(SELECT COUNT(pioniere) FROM proclamatori WHERE pioniere = '3') AS n_spec,
			(SELECT COUNT(id) FROM reports WHERE pion_aus = '1' AND mese = '{$_POST['mese']}' AND anno = '{$_POST['anno']}') AS n_pion_aus
		 FROM proclamatori");
		$tp=mysqli_fetch_assoc($tot_proc);
		
		echo '<pre>';
		print_r($tp);
		
		$Body=<<<EOD
    <div id="content-wrapper">
	     	<section>
		  		<h3><b>Totale</b> Congregazione</h3>
				
			</section>
	</div>
EOD;
	}
	
}
include('include/general.php');
echo $Header;
echo $Body;
echo $Footer;