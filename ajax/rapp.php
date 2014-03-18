<?php
include("../include/config.php");
include('../include/functions.php');
//echo '<pre>';
//print_r($GLOBALS);
//echo '</pre>';
$_js="\$";





if(isset($_GET['insert'])) {
$p=$_GET;	
	for ($i=0; $i < count($p['id']); $i++) {
		
		$kid[$i]=$p['id'][$i].$p['mese'][$i].$p['anno'][$i];
		
		if(!empty($p['ore'][$i]) || $p['irreg'][$i] == '1') {
		$upd=mysqli_query($mysqli, "INSERT INTO 
			reports (id_p, kid, mese, anno, libri, opuscoli, ore, riviste, visite, studi, note, pioniere, anziano, servitore, unto, irreg)
			VALUES ('{$p['id'][$i]}', '{$kid[$i]}', '{$p['mese'][$i]}', '{$p['anno'][$i]}', '{$p['lib'][$i]}', '{$p['opu'][$i]}', '{$p['ore'][$i]}', '{$p['riv'][$i]}', '{$p['vis'][$i]}', '{$p['stu'][$i]}', '{$p['note'][$i]}', '{$p['pioniere'][$i]}', '{$p['anziano']}', '{$p['servitore']}', '{$p['unto']}', '{$p['irreg'][$i]}')
				ON DUPLICATE KEY 
				UPDATE 
					libri = '{$p['lib'][$i]}', 
					opuscoli = '{$p['opu'][$i]}', 
					ore = '{$p['ore'][$i]}', 
					riviste = '{$p['riv'][$i]}', 
					visite = '{$p['vis'][$i]}', 
					studi = '{$p['stu'][$i]}', 
					note = '{$p['note'][$i]}',
					pioniere = '{$p['pioniere'][$i]}',
					anziano = '{$p['anziano'][$i]}',
					servitore = '{$p['servitore'][$i]}',
					unto = '{$p['unto'][$i]}',
					irreg = '{$p['irreg'][$i]}';") or die(mysqli_error($mysqli));
		}
	}
	echo '<pre>';
	print_r($GLOBALS);
} elseif (!empty($_GET['gruppo_id']) && empty($_GET['id_p']) && !empty($_GET['mese'])) {
	$table="";
	$sel_proc=mysqli_query($mysqli, "SELECT id, gruppo_id, nome, cognome, pioniere, servitore, unto, anziano FROM proclamatori WHERE gruppo_id = '{$_GET['gruppo_id']}' AND status = '0' ORDER BY cognome DESC") or die(mysqli_error($mysqli));

	while($r=mysqli_fetch_assoc($sel_proc)) {
		
		$sel_rap=mysqli_query($mysqli, "SELECT * FROM reports WHERE id_p = '{$r['id']}' AND mese = '{$_GET['mese']}' AND anno = '{$_GET['anno']}'");
		$s=mysqli_fetch_assoc($sel_rap);
			
			switch($r['pioniere']) {
				case '2':
					$pioniere['check']='disabled';
					$pioniere['default']='<input type="hidden" value="2" name="pioniere[]">';
					$pioniere['ti']='<option value="2" selected>T.I.</option>';
					break;
				case '3':
					$pioniere['check']='disabled';
					$pioniere['default']='<input type="hidden" value="3" name="pioniere[]">';
					$pioniere['ti']='';
					break;
				case '4':	
					$pioniere['check']='disabled';
					$pioniere['default']='<input type="hidden" value="4" name="pioniere[]">';
					$pioniere['ti']='';
					break;
				default:
					$pioniere['check']='';
					$pioniere['default']='';
					$pioniere['ti']='';
			}
						
			if(empty($s)) {
				$preinseriti=<<<EOD
				<td><input type="number" name="lib[]" value="" min="0" placeholder="Lib"></td>
							<td><input type="number" name="opu[]" value="" min="0" placeholder="Opu"></td>
							<td><input type="number" step="0.15" name="ore[]" value="" min="0" placeholder="Ore"></td>
							<td><input type="number" name="riv[]" value="" min="0" placeholder="Riv"></td>
							<td><input type="number" name="vis[]" value="" min="0" placeholder="Vis"></td>
							<td><input type="number" name="stu[]" value="" min="0" placeholder="Stu"></td>
							<td><input type="text" name="note[]" value=""  placeholder="Note.."></td>
							<td>
								<select name="pioniere[]" {$pioniere['check']}>
									<option value="0">No</option>
									<option value="1">Si</option>
									{$pioniere['ti']}
								</select>
								
							</td>
							<td>
								<select name="irreg[]" >
									<option value="0">No</option>
									<option value="1">Si</option>
								</select>
							</td>
EOD;
			
					} else {
						$pioniere['no']=inputcheck($s['pioniere'], '0', 'selected');
						$pioniere['si']=inputcheck($s['pioniere'], '1', 'selected');
						$pioniere['ti']=inputcheck($s['pioniere'], '2', '<option value="2" selected>T.I.</option>');
						$irreg['no']=inputcheck($s['irreg'], '0', 'selected');
						$irreg['si']=inputcheck($s['irreg'], '1', 'selected');
						
						$preinseriti=<<<EOD
						<td><input type="number" name="lib[]" value="{$s['libri']}" min="0" placeholder="Lib"></td>
								<td><input type="number"  name="opu[]" value="{$s['opuscoli']}" min="0" placeholder="Opu"></td>
								<td><input type="number"  step="0.15" name="ore[]" value="{$s['ore']}" min="0" placeholder="Ore"></td>
								<td><input type="number"  name="riv[]" value="{$s['riviste']}" min="0" placeholder="Riv"></td>
								<td><input type="number"  name="vis[]" value="{$s['visite']}" min="0" placeholder="Vis"></td>
								<td><input type="number"  name="stu[]" value="{$s['studi']}" min="0" placeholder="Stu"></td>
								<td><input type="text" name="note[]" value="{$s['note']}"  placeholder="Note.."></td>
								<td>
									<select name="pioniere[]" {$pioniere['check']}>
										<option value="0" {$pioniere['no']}>No</option>
										<option value="1" {$pioniere['si']}>Si</option>
										{$pioniere['ti']}
									</select>
								</td>
								<td>
									<select name="irreg[]">
										<option value="0" {$irreg['no']}>No</option>
										<option value="1" {$irreg['si']}>Si</option>
									</select>
								</td>
EOD;
					}
					
						
		$table.=<<<EOD
						<tr>
							<td>{$r['id']}</td>
							<input type="hidden" name="id[]" value="{$r['id']}">
							<input type="hidden" name="mese[]" value="{$_GET['mese']}">
							<input type="hidden" name="anno[]" value="{$_GET['anno']}">
							<input type="hidden" name="gruppo_id[]" value="{$r['gruppo_id']}">
							<input type="hidden" name="unto[]" value="{$r['unto']}">
							<input type="hidden" name="servitore[]" value="{$r['servitore']}">
							<input type="hidden" name="anziano[]" value="{$r['anziano']}">
							<td>{$r['nome']} {$r['cognome']} ({$r['pioniere']})</td>
							$preinseriti
							{$pioniere['default']}
						</tr>
EOD;
	}

	echo $Content=<<<EOD
	<form id="grigliainsert" onchange="return UpdateRecord();">
	<table style="table-layout:fixed; width:100%" cellspacing="10">
		<tr>
			<th width="25">ID</th>
			<th width="180">Proclamatore</th>
			<th>Libri</th>
			<th>Opuscoli</th>
			<th>Ore</th>
			<th>Riviste</th>
			<th>Visite</th>
			<th>Studi</th>
			<th width="200">Note</th>
			<th>Aus.</th>
			<th>Irr.</th>
		</tr>
			$table
	</table>
	</form>
EOD;


} elseif(!empty($_GET['id_p'])) {
	$table="";
	$sel_proc=mysqli_query($mysqli, "SELECT id, gruppo_id, nome, cognome, pioniere FROM proclamatori WHERE id = '{$_GET['id_p']}' ORDER BY cognome DESC") or die(mysqli_error($mysqli));

	while($r=mysqli_fetch_assoc($sel_proc)) {
		
		$sel_rap=mysqli_query($mysqli, "SELECT * FROM reports WHERE id_p = '{$r['id']}' AND mese = '{$_GET['mese']}' AND anno = '{$_GET['anno']}'");
		$s=mysqli_fetch_assoc($sel_rap);
			
			if(empty($s)) {
				$preinseriti=<<<EOD
				<td><input type="number" name="lib[]" value="" min="0" placeholder="Lib"></td>
							<td><input type="number" name="opu[]" value="" min="0" placeholder="Opu"></td>
							<td><input type="number" step="0.15" name="ore[]" value="" min="0" placeholder="Ore"></td>
							<td><input type="number" name="riv[]" value="" min="0" placeholder="Riv"></td>
							<td><input type="number" name="vis[]" value="" min="0" placeholder="Vis"></td>
							<td><input type="number" name="stu[]" value="" min="0" placeholder="Stu"></td>
							<td><input type="text" name="note[]" value=""  placeholder="Note.."></td>
							<td>
								<select name="pioniere[]" {$pioniere['check']}>
									<option value="0">No</option>
									<option value="1">Si</option>
								</select>
							</td>
							<td>
								<select name="irreg[]">
									<option value="0">No</option>
									<option value="1">Si</option>
								</select>
							</td>
EOD;
			
					} else {
						$pioniere['check']=inputcheck($s['pioniere'], '2', 'disabled');
						$pioniere['check']=inputcheck($s['pioniere'], '3', 'disabled');
						$pioniere['check']=inputcheck($s['pioniere'], '4', 'disabled');
						$pioniere['no']=inputcheck($s['pioniere'], '0', 'selected');
						$pioniere['si']=inputcheck($s['pioniere'], '1', 'selected');
						$irreg['no']=inputcheck($s['irreg'], '0', 'selected');
						$irreg['si']=inputcheck($s['irreg'], '1', 'selected');
						
						$preinseriti=<<<EOD
						<td><input type="number" name="lib[]" value="{$s['libri']}" min="0" placeholder="Lib"></td>
								<td><input type="number"  name="opu[]" value="{$s['opuscoli']}" min="0" placeholder="Opu"></td>
								<td><input type="number"  step="0.15" name="ore[]" value="{$s['ore']}" min="0" placeholder="Ore"></td>
								<td><input type="number"  name="riv[]" value="{$s['riviste']}" min="0" placeholder="Riv"></td>
								<td><input type="number"  name="vis[]" value="{$s['visite']}" min="0" placeholder="Vis"></td>
								<td><input type="number"  name="stu[]" value="{$s['studi']}" min="0" placeholder="Stu"></td>
								<td><input type="text" name="note[]" value="{$s['note']}"  placeholder="Note.."></td>
								<td>
									<select name="pioniere[]" {$pioniere['check']}>
										<option value="0" {$pioniere['no']}>No</option>
										<option value="1" {$pioniere['si']}>Si</option>
									</select>
								</td>
								<td>
									<select name="irreg[]">
										<option value="0" {$irreg['no']}>No</option>
										<option value="1" {$irreg['si']}>Si</option>
									</select>
								</td>
EOD;
					}
					
					
		$table.=<<<EOD
						<tr>
							<td>{$r['id']}</td>
							<input type="hidden" name="id[]" value="{$r['id']}">
							<input type="hidden" name="mese[]" value="{$_GET['mese']}">
							<input type="hidden" name="anno[]" value="{$_GET['anno']}">
							<input type="hidden" name="gruppo_id[]" value="{$r['gruppo_id']}">
							<td>{$r['nome']} {$r['cognome']} ({$r['pioniere']})</td>
							$preinseriti
						</tr>
EOD;
	}

	echo $Content=<<<EOD
	<form id="grigliainsert" onchange="return UpdateRecord();">
	<table style="table-layout:fixed; width:100%" cellspacing="10">
		<tr>
			<th width="25">ID</th>
			<th width="180">Proclamatore</th>
			<th>Libri</th>
			<th>Opuscoli</th>
			<th>Ore</th>
			<th>Riviste</th>
			<th>Visite</th>
			<th>Studi</th>
			<th width="200">Note</th>
			<th>Aus.</th>
			<th>Irr.</th>
		</tr>
			$table
	</table>
	</form>
EOD;


} else {
	echo '<i>Seleziona sopra un mese, un gruppo (oppure un proclamatore).</i>';
}
