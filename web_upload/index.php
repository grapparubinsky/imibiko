<?php
$page="inserimento_rapporti";
$title="Rapporti > inserimento rapporti";
$thead="Inserimento rapporti";

require_once __DIR__.'/../include/config.php';
require_once __DIR__.'/../include/general.php';
require_once __DIR__.'/../include/functions.php';

$_js="\$";
if(!isset($_POST['id'])) {
 
  $Body=<<<EOD
    <div id="content-wrapper">
	      <section>
		  	<h3>Filtra</h3>
		  	<form id="ajaxform">
		  	<div class="row">
			  	<div class="form-group col-md-4">
				  	<label for="mese">Mese</label>
				  	<select class="form-control" name="month">
				  		{$fn(get_months_select_options())}
				  	</select>
			  	</div>
			  	<div class="form-group col-md-4">
			  		<label for="anno">Anno </label>
				  	<select id="anno" class="form-control" name="year">
				  		{$fn(get_years_select_options())}
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