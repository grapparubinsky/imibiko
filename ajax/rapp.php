<?php
include(__DIR__.'/../include/config.php');
include(__DIR__.'/../include/functions.php');

$_js="\$";



// if troppo lunghi e noiosi da leggere, scrivili una volta e poi civilizzali
if(request_ifset('insert')) 
  $method = 'insert';
if((request_ifsetnotnull('gruppo_id') || request_ifsetnotnull('id_p')) && (request_ifsetnotnull('month') || request_ifsetnotnull('year'))) {
  $method = 'view_reports_table';
  $month = request_ifset('month');
  $year = request_ifset('year');
}

$HandleReports = new HandleReports();

if($method == 'insert') {

  $HandleReports->insert_or_update();

} elseif ($method == 'view_reports_table') {
	$table="";
	
	if(request_ifsetnotnull('gruppo_id')) {
	
	    $gruppo_id = my_escape(request_ifset('gruppo_id',1));
	    $r = $HandleReports->get_reports('gruppo', $gruppo_id);
	    
	} elseif(request_ifsetnotnull('id_p')) {
	
	    $proc_id = my_escape(request_ifset('id_p',1));   
	 // $proc_list = $HandleReports->get_proc_list($proc_id, 'proc');
	    $r = $HandleReports->get_reports('proc', $proc_id);
	}
	
	foreach($r as $proc) {
	
	      // for each proc do this..
	
		$proc = array2object($proc);
	  
		switch($proc->pioniere) {
			case '2':
				$pioniere['check']='';
				//$pioniere['default']='<input type="hidden" value="2" name="pioniere[]">';
				$pioniere['extra_option']='<option value="2" selected>T.I.</option>';
				break;
			case '3':
				$pioniere['check']='';
				//$pioniere['default']='<input type="hidden" value="3" name="pioniere[]">';
				$pioniere['extra_option']='<option value="3" selected>P.R.</option>';
				break;
			case '4':	
				$pioniere['check']='';
				//$pioniere['default']='<input type="hidden" value="4" name="pioniere[]">';
				$pioniere['extra_option']='<option value="4" selected>P.S.</option>';
				break;
			default:
				$pioniere['check']='';
				$pioniere['default']='';
				$pioniere['extra_option']='';
		
		}
		
		
		$pioniere['no']=inputcheck($proc->pioniere, '0', 'selected');
		$pioniere['si']=inputcheck($proc->pioniere, '1', 'selected');
		
		$irreg['no']=inputcheck($proc->irreg, '0', 'selected');
		$irreg['si']=inputcheck($proc->irreg, '1', 'selected');

		
		$table.=<<<EOD
		<tr>
		    <input type="hidden" name="id[]" value="{$proc->id_p}">
		    <input type="hidden" name="month" value="{$month}">
		    <input type="hidden" name="year" value="{$year}">
		    
		    <td>{$proc->nome} {$proc->cognome}</td>
		    <td><input  class="form-control" type="number" min="0" placeholder="Pubb" 			name="pubb[]" 		value="{$proc->pubb}"></td>
		    <td><input  class="form-control" type="number" min="0" placeholder="Vid"			name="video[]" 		value="{$proc->video}"></td>
		    <td><input  class="form-control" type="number" min="0" placeholder="Ore" step="0.15" 	name="ore[]" 		value="{$proc->ore}"></td>
		    <td><input  class="form-control" type="number" min="0" placeholder="Vis"			name="vis[]" 		value="{$proc->visite}"></td>
		    <td><input  class="form-control" type="number" min="0" placeholder="Stu" 			name="stu[]" 		value="{$proc->studi}"></td>
		    <td><input  class="form-control" type="text"  placeholder="Osservazioni"			name="note[]"		value="{$proc->note}"></td>
		    <td>
		      <select  class="form-control" name="pioniere[]" {$pioniere['check']}>
			<option value="0" {$pioniere['no']}>No</option>
			<option value="1" {$pioniere['si']}>Aus.</option>
			{$pioniere['extra_option']}
		      </select>
		    </td>
		    <td>
		      <select class="form-control"  name="irreg[]">
			<option value="0" {$irreg['no']}>No</option>
			<option value="1" {$irreg['si']}>Irr.</option>
		      </select>
		    </td>
		  </tr>
EOD;
					
	}
	
	
	echo $Content=<<<EOD
	<form id="grigliainsert" onchange="return UpdateRecord();">
	<table class="table table-condensed table-curved" style="table-layout:fixed; width:100%" cellspacing="10">
		<tr>
			<th width="180">Proclamatore</th>
			<th>Pubb.</th>
			<th>Video</th>
			<th>Ore</th>
			<th>Visite</th>
			<th>Studi</th>
			<th width="250">Osservazioni</th>
			<th>Pioniere</th>
			<th>Irr.</th>
		</tr>
			$table
	</table>
	</form>
EOD;
	
} else {
	echo '<i>Seleziona sopra un mese, un gruppo (oppure un proclamatore).</i>';
}