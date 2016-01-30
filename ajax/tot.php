<?php
include("../include/config.php");
include('../include/functions.php');
//echo '<pre>';
//print_r($GLOBALS);
//echo '</pre>';
$_js="\$";

if (!empty($_GET['mese'])) {

	
	/* fai il controllo rapporti mancanti */
	$msg_content="";
	$all_proc=mysqli_query($mysqli, "SELECT p.id, p.nome, p.cognome, g.nome_gruppo FROM proclamatori AS p LEFT JOIN gruppi AS g ON g.id = p.gruppo_id WHERE p.status = 0");
	while ($check = mysqli_fetch_object($all_proc)) {
		$check_month_vs_proc=mysqli_query($mysqli, "SELECT * FROM `proclamatori` AS p LEFT JOIN reports AS r ON p.id = r.id_p WHERE r.id_p = {$check->id} AND (r.mese = {$_GET['mese']} AND r.anno = {$_GET['anno']})");		
	
	$res_check=mysqli_fetch_object($check_month_vs_proc);
		if(empty($res_check)) $msg_content.= "<li>Rapporto mancante: <b>{$check->nome} {$check->cognome}</b> -> gruppo {$check->nome_gruppo}";
	}
	
$msg = <<<EOD
 <div class="alert alert-danger fade in printhidden">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Attenzione!</strong> {$msg_content}
  </div>
EOD;
	
	
	$table="";
		$sel_rap=mysqli_query($mysqli, 
		"SELECT p.nome, p.cognome, r.libri, r.opuscoli, r.ore, r.riviste, r.visite, r.studi, r.note, r.pioniere, r.irreg
		FROM reports AS r 
		LEFT JOIN proclamatori AS p 
			ON r.id_p = p.id 
		WHERE mese = '{$_GET['mese']}' 
			AND anno = '{$_GET['anno']}' 
		ORDER BY cognome ASC");
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
				
			$table.=<<<EOD
							<tr>
								<td>{$s['nome']} {$s['cognome']}</td>
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
			
			// proclamatori, pionieri ausiliari, pionieri regolari, numero proclamatori
			
			$tot_rap_proc=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE mese = '{$_GET['mese']}' 
					AND anno = '{$_GET['anno']}' 
					AND pioniere = '0'
					AND irreg = '0'");
					
					$table_tot="";
					while($t_proc=mysqli_fetch_assoc($tot_rap_proc)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Proclamatori</td>
								<td>{$t_proc['n']}</td>
								<td>{$t_proc['lib']}</td>
								<td>{$t_proc['opu']}</td>
								<td>{$t_proc['ore']}</td>
								<td>{$t_proc['riv']}</td>
								<td>{$t_proc['vis']}</td>
								<td>{$t_proc['stu']}</td>
							</tr>
EOD;
					}
			$tot_rap_aus=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE mese = '{$_GET['mese']}' 
					AND anno = '{$_GET['anno']}' 
					AND (pioniere = '1' OR pioniere = '2')");
					
					while($t_aus=mysqli_fetch_assoc($tot_rap_aus)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Ausiliari</td>
								<td>{$t_aus['n']}</td>
								<td>{$t_aus['lib']}</td>
								<td>{$t_aus['opu']}</td>
								<td>{$t_aus['ore']}</td>
								<td>{$t_aus['riv']}</td>
								<td>{$t_aus['vis']}</td>
								<td>{$t_aus['stu']}</td>
							</tr>
EOD;
					}
					
			$tot_pion_reg=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE mese = '{$_GET['mese']}' 
					AND anno = '{$_GET['anno']}' 
					AND pioniere = '3'");
					
					while($t_reg=mysqli_fetch_assoc($tot_pion_reg)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Regolari</td>
								<td>{$t_reg['n']}</td>
								<td>{$t_reg['lib']}</td>
								<td>{$t_reg['opu']}</td>
								<td>{$t_reg['ore']}</td>
								<td>{$t_reg['riv']}</td>
								<td>{$t_reg['vis']}</td>
								<td>{$t_reg['stu']}</td>
							</tr>
EOD;
					}
				$tot_pion_spec=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE mese = '{$_GET['mese']}' 
					AND anno = '{$_GET['anno']}' 
					AND pioniere = '4'");
					
					while($t_spec=mysqli_fetch_assoc($tot_pion_spec)) {
						$table_tot.=<<<EOD
							<tr>
								<td>Pion. Speciali</td>
								<td>{$t_spec['n']}</td>
								<td>{$t_spec['lib']}</td>
								<td>{$t_spec['opu']}</td>
								<td>{$t_spec['ore']}</td>
								<td>{$t_spec['riv']}</td>
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
								<td></td>
								
							</tr>
EOD;
				
				$tot_all=mysqli_query($mysqli, 
				"SELECT SUM(libri) AS lib, SUM(opuscoli) AS opu, SUM(ore) AS ore, SUM(riviste) AS riv, SUM(visite) AS vis, SUM(studi) AS stu, COUNT(id) AS n
				FROM reports
				WHERE mese = '{$_GET['mese']}' 
					AND anno = '{$_GET['anno']}'");
					
					$t_all=mysqli_fetch_assoc($tot_all);
					
						$table_tot.=<<<EOD
							<tr style="background:#26AA4E;color:#fff">
								<td><b>Totale</b></td>
								<td>{$t_all['n']}</td>
								<td>{$t_all['lib']}</td>
								<td>{$t_all['opu']}</td>
								<td><b>{$t_all['ore']}</b></td>
								<td>{$t_all['riv']}</td>
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
	<h2>Rapporto Congregazione ({$_GET['mese']}/{$_GET['anno']})</h2>
	$msg
	<table class="table table-striped table-curved">
		<tr>
			<th width="180"></th>
			<th>N.</th>
			<th>Lib.</th>
			<th>Opu.</th>
			<th>Ore</th>
			<th>Riv.</th>
			<th>Vis.</th>
			<th>Stu.</th>
		</tr>
			$table_tot
	</table>
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
EOD;
	} else {
		echo 'Rapporti non ancora compilati per questo mese.';
	}

} else {
	echo '<i>Seleziona sopra una data.</i>';
}
