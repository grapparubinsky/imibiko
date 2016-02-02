<?php
$page="totali_rapporti";
$title="Rapporti > totali rapporti";
$thead="Totali Rapporti";
include('include/config.php');
include('include/general.php');
include('include/functions.php');
$_js="\$";
if(!isset($_POST['id'])) {

  $Body=<<<EOD
    <div id="content-wrapper">
	      <section id="filtra">
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