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
					    <label for="proclamtore">Proclamatore</label>
				    	<input  class="form-control" id="proclamatore" name="nome_proclamatore" type="text" value="">
				    	<input class="form-control" type="hidden" id="proc_id" name="proc_id" value="">
					 </div>
					
		   	 	</div> <!-- /div .row -->
	   	 		
	   	 		<div class="row">
				  	 <div class="form-group col-md-4">
			  		<label for="anno">Anno teocratico</label>
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
		callback: function (obj) { document.getElementById('proc_id').value = obj.id; }
	};
	var as_json = new AutoSuggest('proclamatore', options2);

	function submitForm() {
	    $_js.ajax({type:'GET', url: 'ajax/cart.php', data:$_js('#ajaxform').serialize(), success: function(response) {
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