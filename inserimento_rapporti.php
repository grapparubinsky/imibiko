<?php
$page="inserimento_rapporti";
$title="Rapporti > inserimento rapporti";
$thead="Inserimento rapporti";
include('include/config.php');
include('include/general.php');
include('include/functions.php');
$_js="\$";
if(!isset($_POST['id'])) {
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
		  	<form id="ajaxform">
		  	<div class="row">
			  	<div class="form-group col-md-4">
				  	<label for="mese">Mese</label>
				  	<select class="form-control" name="mese">
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
			  	</div>
			  	<div class="form-group col-md-4">
			  		<label for="anno">Anno </label>
				  	<select id="anno" class="form-control" name="anno">
				  		$yearoption
				  	</select>
				</div>
			</div> <!-- /div .row -->
			<div class="row">
			  	 <div class="form-group col-md-4">
				    <label for="nome_gruppo">Gruppo di servizio </label>
				    <input class="form-control" id="gruppo" name="nome_gruppo" type="text" value="">
				    <input type="hidden" id="gruppo_id" name="gruppo_id" value="">
				 </div>
				 <div class="form-group col-md-4">
				    <label for="proclamtore">Proclamatore</label>
			    	<input  class="form-control" id="proclamatore" name="nome_proclamatore" type="text" value="">
			    	<input class="form-control" type="hidden" id="id_p" name="id_p" value="">
				 </div>
			    <div class="form-group col-md-4">
			    	<br>
			    	<input class="btn btn-success btn-lg" type="button" onclick="return submitForm();" value="Filtra">
			    </div>
	   	 	</div> <!-- /div .row -->
	   	 </form>
	   	</section>
	    <section id="results">
	    	<h3>Rapporto</h3>
	    	<div class="form_result">
	    		
	    	<div>
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

	function UpdateRecord() {
			    $_js.ajax({type:'GET', url: 'ajax/rapp.php?insert', data:$_js('#grigliainsert').serialize(), success: function(response) {
			       
			      
			    }});
			
			    return false;
			}
</script>
</script>
EOD;
}

echo $Header;
echo $Body;
echo $Footer;