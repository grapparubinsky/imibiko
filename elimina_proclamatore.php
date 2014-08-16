<?php
$page="elimina_proclamatore";
$title="Rapporti > elimina proclamatore";
$thead="Elimina proclamatore";
include('include/config.php');
include('include/general.php');
include('include/functions.php');

if(!empty($_GET['id'])) {
   $del=mysqli_query($mysqli, "DELETE FROM proclamatori WHERE id = '{$_GET['id']}'") or die(mysqli_error($mysqli));
   $r=mysqli_fetch_assoc($del);
  	$del2=mysqli_query($mysqli, "DELETE FROM contatti WHERE id_p = '{$_GET['id']}'") or die(mysqli_error($mysqli));
	   $r2=mysqli_fetch_assoc($del2);
   
    $Body=<<<EOD

      <div id="content-wrapper">
			<section>
			    <h3>Rimosso correttamente</h3>
			   
			</section>
	</div>
EOD;

}

echo $Header;
echo $Body;
echo $Footer;