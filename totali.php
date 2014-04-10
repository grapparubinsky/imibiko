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
		    <input type="button" onclick="return submitForm();" value="Filtra">
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
</script>
EOD;
}

echo $Header;
echo $Body;
echo $Footer;