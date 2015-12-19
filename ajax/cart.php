<?php
include("../include/config.php");
include('../include/functions.php');
//echo '<pre>';
//print_r($GLOBALS);
//echo '</pre>';
$_js="\$";

if (!empty($_GET['id_p'])) {

	$anno_minus_one = $_GET['anno']-1;
	
	$proclamatore=mysqli_query($mysqli, "SELECT * FROM proclamatori INNER JOIN contatti ON contatti.id_p = proclamatori.id WHERE proclamatori.id = {$_GET['id_p']}");
	$proclamatore=mysqli_fetch_object($proclamatore);
	
	
	
	$table="";
		$sel_rap=mysqli_query($mysqli, 
		"SELECT p.nome, p.cognome, r.mese, r.anno, r.libri, r.opuscoli, r.ore, r.riviste, r.visite, r.studi, r.note, r.pioniere, r.irreg
		FROM reports AS r 
		LEFT JOIN proclamatori AS p 
			ON r.id_p = p.id 
		WHERE (r.mese > 9 AND r.anno = '{$anno_minus_one}') 
						OR (r.mese < 9 AND r.anno = '{$_GET['anno']}') 
						AND r.id_p = {$_GET['id_p']}
		ORDER BY anno, mese ASC");

		if(mysqli_num_rows($sel_rap) !== 0) {
				
			while ($s=mysqli_fetch_assoc($sel_rap)) {
				
				switch ($s['pioniere']) {
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
				
				if($s['irreg'] == '1') $irreg="<b>Irreg.</b>"; else $irreg = "-";
				
				//CONVERTI DATA FORMATO TESTUALE
				$dateObj = DateTime::createFromFormat('n-Y', "{$s['mese']}-{$s['anno']}");
				$mese_anno = $dateObj->format('F Y');
				
			$table.=<<<EOD
							<tr>
								<td>$mese_anno</td>
								<td>{$s['libri']}</td>
								<td>{$s['opuscoli']}</td>
								<td><b>{$s['ore']}</b></td>
								<td>{$s['riviste']}</td>
								<td>{$s['visite']}</td>
								<td>{$s['studi']}</td>
								<td>{$s['note']}</td>
								<td>$pioniere</td>
								<td>$irreg</td>
							</tr>
EOD;
			}
			
			
			
				$tot_all=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu
				FROM reports
				WHERE (mese > 9 AND anno = '{$anno_minus_one}') 
						OR (mese < 9 AND anno = '{$_GET['anno']}') 
						AND id_p = {$_GET['id_p']}");
					 
					$t_all=mysqli_fetch_assoc($tot_all);
					
						$table_tot.=<<<EOD
							<tr style="background:#26AA4E;color:#fff">
								<td><b>Totale anno teocratico</b></td>
								<td><b>{$t_all['lib']}</b></td>
								<td><b>{$t_all['opu']}</b></td>
								<td><b>{$t_all['ore']}</b></td>
								<td><b>{$t_all['riv']}</b></td>
								<td><b>{$t_all['vis']}</b></td>
								<td><b>{$t_all['stu']}</b></td>
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
	<h2>Rapporto: {$proclamatore->nome} {$proclamatore->cognome} (9/$anno_minus_one - 9/{$_GET['anno']})</h2>
	$msg
	
	<div class="panel panel-default">
	 	 <div class="panel-heading"><b>Informazioni Proclamatore</div>
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
			<th>Lib.</th>
			<th>Opu.</th>
			<th>Ore</th>
			<th>Riv.</th>
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
			<th>Lib.</th>
			<th>Opu.</th>
			<th>Ore</th>
			<th>Riv.</th>
			<th>Vis.</th>
			<th>Stu.</th>
		</tr>
			$table_tot
	</table>
EOD;
	} else {
		echo 'Nessun rapporto trovato per questo proclamatore.';
	}

} else {
	echo '<i>Seleziona sopra una data.</i>';
}
