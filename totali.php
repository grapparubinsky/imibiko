<?php
$page="totali_rapporti";
$title="Rapporti > totali rapporti";
$thead="Totali Rapporti";
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
	      <section id="filtra">
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
				 <div class="form-group col-md-4">
			    	<br>
			    	<input class="btn btn-success btn-lg" type="button" onclick="return submitForm();" value="Filtra">
			    </div>
			</div> <!-- /div .row -->
	   	 </form>
	   	</section>
	    <section id="results">
	    	<div class="form_result">
	    		
	    	<div>
	    </section>
  	</div>
<script>
			function submitForm() {
			    $_js.ajax({type:'GET', url: 'ajax/tot.php', data:$_js('#ajaxform').serialize(), success: function(response) {
			        $_js('#results').find('.form_result').html(response);
			      
			    }});
			
			    return false;
			}

</script>

EOD;
}

echo $Header;
echo $Body;
echo $Footer;