<?php
include("../include/config.php");
include('../include/functions.php');
//echo '<pre>';
//print_r($GLOBALS);
//echo '</pre>';
$_js="\$";

if (request_ifsetnotnull('proc_id')) {

	$anno 			= request_ifset('anno', 1);
	$anno_plus_one 		= $anno+1;
	$anno_minus_one 	= $anno-1;
	
	$anno_minus_one_ts 	= year_month_to_ts('09', $anno_minus_one);
	$anno_plus_one_ts 	= year_month_to_ts('09', $anno_plus_one);
	$anno_ts 		= year_month_to_ts('09', $anno);
	
	$ts_cond_array		= array('start_ts'=>$anno_minus_one_ts,'end_ts'=>$anno_ts);
	
	$HandleReports = new HandleReports(FALSE, 1);
	$proc_info = $HandleReports->get_proc_ext_info(request_ifset('proc_id'));
	$proclamatore = $proc = array2object($proc_info[0]);
		
	$reports = $HandleReports->get_reports('proc', $proc->id, $ts_cond_array, 1);
	$reports = array2object($reports);
	
	foreach($reports as $r) {
	  
				
	    switch ($r->pioniere) {
		    case '0':
			    $pioniere="-";
			    break;
		    case '1':
			    $pioniere="Aus.";
			    break;
		    case '2':
			    $pioniere="T.I";
			    break;
		    case '3':
			    $pioniere="Reg.";
			    break;
		    case '4':
			    $pioniere="Spec.";
	    }
			      
	    if($r->irreg == '1') $irreg="<b>Irreg.</b>"; 
	      else $irreg = "-";
	    
	    //CONVERTI DATA FORMATO TESTUALE
	    $dateObj = DateTime::createFromFormat('U', $r->ts_report);
	    $mese_anno = $dateObj->format('F Y');
	    
	    $table.=<<<EOD
    
	    <tr>
		    <td>$mese_anno</td>
		    <td>{$r->pubb}</td>
		    <td>{$r->video}</td>
		    <td><b>{$r->ore}</b></td>
		    <td>{$r->visite}</td>
		    <td>{$r->studi}</td>
		    <td>{$r->note}</td>
		    <td>$pioniere</td>
		    <td>$irreg</td>
	    </tr>
EOD;
	}
			
			
	$reports_sum = $HandleReports->get_reports_sum($proc->id, $ts_cond_array);
	$r_sum = array2object($reports_sum[0]);
	
	$table_tot.=<<<EOD
		
	  <tr style="background:#26AA4E;color:#fff">
		  <td><b>Totale anno teocratico</b></td>
		  <td>{$r_sum->pubb}</td>
		  <td>{$r_sum->video}</td>
		  <td>{$r_sum->ore}</td>
		  <td>{$r_sum->visite}</td>
		  <td>{$r_sum->studi}</td>
	  </tr>
EOD;
					
					
	
			
		echo	$Content=<<<EOD
		
	<style>
	table {
		table-layout:fixed; width:100%;background:#eee; border:1px solid #ddd;
	}
	td {
		font-size: 1.2em;
}
	th {
		text-transform:uppercase; padding-top: 5px; padding-bottom: 4px; background-color: #555; color: #fff;
	}
	</style>	
	<h2>Rapporto: {$proclamatore->nome} {$proclamatore->cognome} (9/$anno_minus_one - 8/{$anno})</h2>
	$msg
	
	<div class="panel panel-default">
	 	 <div class="panel-heading"><b>Informazioni Proclamatore</b></div>
		 <div class="panel-body">
				<table class="table" style="font-weight:normal">
				<tr>
					<td><b>{$proclamatore->nome} {$proclamatore->cognome}</b></td>
					<td><b>Fisso</b>: {$proclamatore->n_casa}</td>
					<td><b>Cellulare</b>: {$proclamatore->n_cell}</td>
				</tr>
				<tr>
					<td><b>Indirizzo</b>: {$proclamatore->address}</td>
					<td>{$proclamatore->comune}</td>
					<td><b>Email</b>: {$proclamatore->email}</td>
				</tr>
				<tr>
					<td><b>Data nascita</b>: {$proclamatore->d_nascita}</td>
					<td><b>Data battesimo</b>: {$proclamatore->d_battesimo}</td>
					<td><b>Note</b>: {$proclamatore->note}</td>
				</tr>
				</table>
		 </div>
	</div>
	
	
	<h2>Dettaglio Rapporto</h2>
	
	<table class="table table-striped table-curved">
		<tr>
			<th width="180">Proclamatore</th>
			<th>Pubb.</th>
			<th>Video</th>
			<th>Ore</th>
			<th>Vis.</th>
			<th>Stu.</th>
			<th width="200">Note</th>
			<th>Pion.</th>
			<th>Irr.</th>
		</tr>
			$table
	</table>
	
		<h2>Totale Rapporto</h2>
	
	<table class="table table-striped table-curved">
		<tr>
			<th width="250"></th>
			<th>Pubb.</th>
			<th>Video</th>
			<th>Ore</th>
			<th>Vis.</th>
			<th>Stu.</th>
		</tr>
			$table_tot
	</table>
EOD;

} else {
		echo 'Nessun rapporto trovato per questo proclamatore.';

}
