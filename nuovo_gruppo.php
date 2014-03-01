<?php
$page="nuovo_gruppo";
$title="Rapporti > nuovo gruppo";
$thead="Nuovo Gruppo di servizio";
include('include/general.php');
include('include/config.php');
if(!isset($_POST['nome'])) {

  $Body=<<<EOD
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
<script type="text/javascript">
$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "gruppo_ajax.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});

jQuery("#result").live("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery("#result").fadeOut(); 
    }
});
$('#searchid').click(function(){
    jQuery("#result").fadeIn();
});
});
</script>
    <div id="content-wrapper">
      <section>
	  <h3>Informazioni personali</h3>
	  <form method="POST" action="">
	    <input name="nome"_gruppo required type="text" value="" placeholder="Nome Gruppo">
	    <input name="cognome" required type="text" value="" placeholder="Cognome">
	    </br>
	    <label for="anziano_id">Anziano</label>
	    <input type="text" class="search" id="searchid" placeholder="Search for people" />&nbsp; &nbsp; Ex:arunkumar, shanmu, vicky<br /> 
	    </br>
	    <label for="assistente_id">Assistente</label>
	    <input id="assistente_id" name="assistente_id" type="text" value="">
	    </br>
      </section>
    <input type="submit" value="Registra">
    </form>
    </div>

EOD;
} else {

  if(isset($_POST['unto'])) $unto="1"; else $unto="0";
  if(isset($_POST['anziano'])) $anziano="1"; else $anziano="0";
  if(isset($_POST['servitore'])) $servitore="1"; else $servitore="0";
  
$ins_proc=mysqli_query($mysqli, "INSERT INTO proclamatori (nome, cognome, d_nascita, d_battesimo, unto, anziano, servitore, pioniere) 
VALUES ('{$_POST['nome']}', '{$_POST['cognome']}', '{$_POST['d_nascita']}', '{$_POST['d_battesimo']}', '$unto', '$anziano', '$servitore', '{$_POST['pioniere']}')") or die(mysqli_error($mysqli));

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