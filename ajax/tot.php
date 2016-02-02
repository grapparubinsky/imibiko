<?php
include("../include/config.php");
include('../include/functions.php');
//echo '<pre>';
//print_r($GLOBALS);
//echo '</pre>';
$_js="\$";

if(request_ifsetnotnull('month') && request_ifsetnotnull('year')){

  $msg_content = '';
  $msg='';
  $table='';
  $month = request_ifset('month');
  $year	 = request_ifset('year');

$HandleReports = new HandleReports();
  
  if($HandleReports->get_missing_reports()) 
      $msg_content.= $HandleReports->get_missing_reports();
      
  if($msg_content) { 
  
  $msg = <<<EOD
  <div class="alert alert-danger fade in printhidden">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Attenzione!</strong> {$msg_content}
    </div>
EOD;

}
	
	$table="";
	
	$whole_reports = $HandleReports->get_reports();
	//print_r($whole_reports);die;
	
	   foreach($whole_reports as $row) {

		switch ($row->pioniere) {
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
		  break;
		}

		if($row->irreg == '1') $irreg="<b>Irreg.</b>"; else $irreg = "-";

		$table.=<<<EOD
		<tr>
		  <td>{$row->nome} {$row->cognome}</td>
		  <td>{$row->pubb}</td>
		  <td>{$row->video}</td>
		  <td>{$row->ore}</b></td>
		  <td>{$row->visite}</td>
		  <td>{$row->studi}</td>
		  <td>{$row->note}</td>
		  <td>$pioniere</td>
		  <td>$irreg</td>
		</tr>
EOD;
	  }
	
	
	// proclamatori, pionieri ausiliari, pionieri regolari, numero proclamatori

	$tot_rap_proc=mysqli_query($mysqli, 
				"SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE ts_report = '{$HandleReports->ts_report}' 
					AND pioniere = '0'
					AND irreg = '0'");
					
					$table_tot="";
					while($t_proc=mysqli_fetch_assoc($tot_rap_proc)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Proclamatori</td>
								<td>{$t_proc['n']}</td>
								<td>{$t_proc['pubb']}</td>
								<td>{$t_proc['video']}</td>
								<td>{$t_proc['ore']}</td>
								<td>{$t_proc['vis']}</td>
								<td>{$t_proc['stu']}</td>
							</tr>
EOD;
					}
					
			$tot_rap_aus=mysqli_query($mysqli, 
				"SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE ts_report = '{$HandleReports->ts_report}' 
					AND (pioniere = '1' OR pioniere = '2')");
					
					while($t_aus=mysqli_fetch_assoc($tot_rap_aus)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Ausiliari</td>
								<td>{$t_aus['n']}</td>
								<td>{$t_aus['pubb']}</td>
								<td>{$t_aus['video']}</td>
								<td>{$t_aus['ore']}</td>
								<td>{$t_aus['vis']}</td>
								<td>{$t_aus['stu']}</td>
							</tr>
EOD;
					}
					
			$tot_pion_reg=mysqli_query($mysqli, 
				"SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE ts_report = '{$HandleReports->ts_report}' 
					AND pioniere = '3'");
					
					while($t_reg=mysqli_fetch_assoc($tot_pion_reg)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Regolari</td>
								<td>{$t_reg['n']}</td>
								<td>{$t_reg['pubb']}</td>
								<td>{$t_reg['video']}</td>
								<td>{$t_reg['ore']}</td>
								<td>{$t_reg['vis']}</td>
								<td>{$t_reg['stu']}</td>
							</tr>
EOD;
					}
				$tot_pion_spec=mysqli_query($mysqli, 
				"SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE ts_report = '{$HandleReports->ts_report}' 
					AND pioniere = '4'");
					
					while($t_spec=mysqli_fetch_assoc($tot_pion_spec)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Speciali</td>
								<td>{$t_spec['n']}</td>
								<td>{$t_spec['pubb']}</td>
								<td>{$t_spec['video']}</td>
								<td>{$t_spec['ore']}</td>
								<td>{$t_spec['vis']}</td>
								<td>{$t_spec['stu']}</td>
							</tr>
EOD;
					}
					
				$irregolari_q=mysqli_query($mysqli, "SELECT COUNT(id) FROM reports WHERE irreg = '1' AND mese = '{$_GET['mese']}' AND anno = '{$_GET['anno']}'");
				$irrqs=mysqli_fetch_assoc($irregolari_q);
				$table_tot.=<<<EOD
							<tr>
								<td>Irregolari</td>
								<td>{$irrqs['COUNT(id)']}</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								
							</tr>
EOD;
				
				$tot_all=mysqli_query($mysqli, 
				"SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE ts_report = '{$HandleReports->ts_report}'");
					
					$t_all=mysqli_fetch_assoc($tot_all);
					
						$table_tot.=<<<EOD
							<tr style="background:#26AA4E;color:#fff">
								<td><b>Totale</b></td>
								<td>{$t_all['n']}</td>
								<td>{$t_all['pubb']}</td>
								<td>{$t_all['video']}</td>
								<td>{$t_all['ore']}</td>
								<td>{$t_all['vis']}</td>
								<td>{$t_all['stu']}</td>

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
	<h2>Rapporto Congregazione ($month/$year)</h2>
	$msg
	<table class="table table-striped table-curved">
		<tr>
			<th width="180"></th>
			<th>N.</th>
			<th>Pubb.</th>
			<th>Video</th>
			<th>Ore</th>
			<th>Vis.</th>
			<th>Stu.</th>
		</tr>
			$table_tot
	</table>
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
EOD;

} else {
	echo '<i>Seleziona sopra una data.</i>';
}
