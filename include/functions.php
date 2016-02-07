<?php
function inputcheck($var, $condition, $return) {
      if($var == "$condition") return $return;
	else return $a="";
}

function sanitate($array) {
   foreach($array as $key=>$value) {
      if(is_array($value)) { sanitate($value); }
      else { $array[$key] = my_escape($value); }
   }
   return $array;
}   


/**
 * Shortcut for if(isset($_GET['force'])){...
 * handling of zero depends on php mood
 */
function request_ifset($what,$numeric=false,$default=0) {
	if($numeric && !isset($_REQUEST[$what])){
		return $default;
	}

	if($numeric && !is_numeric($_REQUEST[$what])){
		return $default;
	}

	if (isset($_REQUEST[$what])) {
		if ($_REQUEST[$what] === 0 || $_REQUEST[$what] == '0') {
			return (int) 0;
		} elseif(empty($_REQUEST[$what])) {
			return TRUE;
		} else {
			return my_escape($_REQUEST[$what]);
		}
	}

	if($default){
		return $default;
	}
	return false;
}


/**
 * don't use for updating form !
 */
function request_ifsetnotnull($what) {
	if (isset($_REQUEST[$what]) && $_REQUEST[$what] != '') {
		return my_escape($_REQUEST[$what]);
	}
	return false;
}



function my_escape($w) {
  global $mysqli;
	if (!is_array($w)) {
		return trim($mysqli->real_escape_string($w));
	}

	foreach ($w as $key => $value) {
		$w[$key] = my_escape($value);
	}
	return $w;
}

/**
 * hack to use function  in heredoc
 */
function fn($data) {
	return $data;
}

$fn = 'fn';
//end

function array2object($array) {
    $object = new stdClass();
    
    if($array){
      foreach ($array as $key => $value) {
	  if (is_array($value)) {
	      $value = array2object($value);
	  }
	  $object->$key = $value;
      }
    }
    return $object;
}

function empty_so_zero($array) {
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = empty_so_zero($value);
        }
        if(is_null($value) || !$value)  
	  $object->$key = 0;
	else
	  $object->$key = $value;
    }
    return $object;
}



function set_default_class_property_value($class, $property, $default = ''){
  
  if(!property_exists($class, $property))
    $class->$property = $default;

}
function set_default_ifnull_or_empty($var, $default = ''){
  
  if(empty($var) || is_null($var))
    $var = $default;
  else 
    $var = $var;
    
  return $var;

}

// re-build array
function rebuild_array_please($obj, $no_empty_value = false) {
    foreach(array_keys($obj) as $key) {
	$key_array[] = $key;
	$i=0;
	if(is_array($obj[$key])) {
	  foreach($obj[$key] as $element) {
	      if($no_empty_value) {
		$array[$i][$key] = empty_so_zero($element);
	      } else {
		$array[$i][$key] = $element;
	      }
	  $i++;
	  }
	} else {
	  if($no_empty_value) $array[$key] = empty_so_zero($obj[$key]);
	  else $array[$key] = $obj[$key];
	}
    }
      return $array;
}


function my_query($sql, $return = false, $method = false) {

  global $mysqli;
  $q = $mysqli->query($sql);
  //echo $sql;
  if ($mysqli->error) {
    printf("Errormessage: %s\n", $mysqli->error);
  } else {
    if($return) {
      if($q->num_rows > 0) {
	return $q->fetch_all(MYSQLI_ASSOC);
      } else 
      return FALSE;
    } else {
      return;
    }
  }
}

function get_months_select_options(){

$html = <<<EOD

    <option value="">---</option>
    <option value="01">Gennaio</option>
    <option value="02">Febbraio</option>
    <option value="03">Marzo</option>
    <option value="04">Aprile</option>
    <option value="05">Maggio</option>
    <option value="06">Giugno</option>
    <option value="07">Luglio</option>
    <option value="08">Agosto</option>
    <option value="09">Settembre</option>
    <option value="10">Ottobre</option>
    <option value="11">Novembre</option>
    <option value="12">Dicembre</option>

EOD;

return $html;

}


function get_years_select_options(){

  date_default_timezone_set('Europe/Rome');
  
  $currentYear = date('Y');
  $yearoption="";
  $html='';
  foreach (range($currentYear-1, $currentYear+1) as $value) {
	  if($value==$currentYear) $yearselected="selected"; else $yearselected="";
      $html.= "<option value='$value' $yearselected>{$value}</option>";
  }

  return $html;
}

function year_month_to_ts($month = false, $year = false){
  if($month && $year) {
    $month 	= my_escape($month);
    $year 	= my_escape($year);
  } else {
    $month 	= request_ifsetnotnull('month');
    $year 	= request_ifsetnotnull('year');
  }
  
    $date = DateTime::createFromFormat('Y-m-d H:i:s', "{$year}-{$month}-01 00:00:00");
    return $date->format("U");
  
}

class HandleReports {


  function __construct($ts = false, $bypass_ts = false) {
    $this->req_array 	=	rebuild_array_please(sanitate($_REQUEST));
    $this->req_obj	=	array2object($this->req_array);
    
    $this->ts		=	$ts;
    
    if(!$bypass_ts) {
      $this->process_ts(); // inizializza date
    }
    
  }

  function process_ts($ts = false){
  
    if(!empty($ts)){
      $var = $ts;
    } else {
      $var = $this->ts;
    }
    
      if(!$var) {
	$this->ts_report 	= year_month_to_ts();
      } elseif(is_array($var)) {
	$this->ts_report 	= sanitate($var);
      } elseif(!empty($var)) {	
	$this->ts_report 	= my_escape($var);
      }
      
      $this->ts_sql_filter = $this->process_ts_sql_filter();

  }
  
  function process_ts_sql_filter(){
    if(is_array($this->ts_report))
      return "(ts_report >= {$this->ts_report['start_ts']} AND ts_report < {$this->ts_report['end_ts']})";
    else
      return "(ts_report = {$this->ts_report})";
  }
  
  function insert_or_update() {
  
	
      $sql_update='';

      foreach($this->req_obj as $row) {
	
	if(!empty($row->ore) || $row->irreg == 1) {
	    
	     // add default value if null or empty
	     
	     $row->pubb 	= set_default_ifnull_or_empty($row->pubb, 0);
	     $row->video	= set_default_ifnull_or_empty($row->video, 0);
	     $row->ore		= set_default_ifnull_or_empty($row->ore, 0);
	     $row->vis		= set_default_ifnull_or_empty($row->vis, 0);
	     $row->stu		= set_default_ifnull_or_empty($row->stu, 0);
	     $row->note		= set_default_ifnull_or_empty($row->note, '');
	     $row->pioniere	= set_default_ifnull_or_empty($row->pioniere, 0);
	     $row->irreg	= set_default_ifnull_or_empty($row->irreg, 0);
	    
	      $sql_update = "INSERT INTO 
			    reports SET
			      id_p 		=	'{$row->id}', 
			      ts_report		=	'{$this->ts_report}', 
			      pubb		=	'{$row->pubb}', 
			      video		=	'{$row->video}', 
			      ore 		=	'{$row->ore}', 
			      visite		=	'{$row->vis}', 
			      studi		=	'{$row->stu}', 
			      note		=	'{$row->note}', 
			      pioniere		=	'{$row->pioniere}', 
			      irreg		=	'{$row->irreg}' 
			    ON DUPLICATE KEY UPDATE  
			      pubb		=	'{$row->pubb}', 
			      video		=	'{$row->video}', 
			      ore 		=	'{$row->ore}', 
			      visite		=	'{$row->vis}', 
			      studi		=	'{$row->stu}', 
			      note		=	'{$row->note}', 
			      pioniere		=	'{$row->pioniere}', 
			      irreg		=	'{$row->irreg}'
			      ";
			      
			      
			       my_query($sql_update);
		    
	    }
	    	    
	}
  
  }

  function get_reports($domain = 'all', $domain_id = false, $ts_report = false, $segmented_by_month = false) {
  
      if($ts_report)
	$this->process_ts($ts_report);
      
     	switch($domain){
	  case 'all':
	    $proc_list = $this->get_proc_list();
	  break;
	  
	  case 'proc':
	    $proc_list = $this->get_proc_list($domain_id, 'proc');
	  break;
	  
	  case 'gruppo':
	    $proc_list = $this->get_proc_list($domain_id, 'gruppo');
	  break;
	  
	}
            
      foreach($proc_list as $proc) {
	  $proc = array2object($proc);
	  
	    $r = $this->get_reports_row($proc->id, $ts_report, $segmented_by_month);
	    if($segmented_by_month) {
	      $r = array2object($r); // per un accesso più comodo
	      
	        foreach($r as $r) {
		    // add value from $proc
		  set_default_class_property_value($r, 'id_p', $proc->id);
		  set_default_class_property_value($r, 'nome', $proc->nome);
		  set_default_class_property_value($r, 'cognome', $proc->cognome);
		  set_default_class_property_value($r, 'nome_gruppo', $proc->nome_gruppo);
	
		  // set default value for $r object
		  set_default_class_property_value($r, 'ts_report');
		  set_default_class_property_value($r, 'pubb');
		  set_default_class_property_value($r, 'video');
		  set_default_class_property_value($r, 'ore');
		  set_default_class_property_value($r, 'visite');
		  set_default_class_property_value($r, 'studi');
		  set_default_class_property_value($r, 'note');
		  set_default_class_property_value($r, 'pioniere', $proc->pioniere);
		  set_default_class_property_value($r, 'irreg');
		  $array[] = $r;
		}
	    
	    } else {
	      $r = array2object($r[0]); // per un accesso più comodo
	      // add value from $proc
	      set_default_class_property_value($r, 'id_p', $proc->id);
	      set_default_class_property_value($r, 'nome', $proc->nome);
	      set_default_class_property_value($r, 'cognome', $proc->cognome);
	      set_default_class_property_value($r, 'nome_gruppo', $proc->nome_gruppo);
    
	      // set default value for $r object
	      set_default_class_property_value($r, 'ts_report');
	      set_default_class_property_value($r, 'pubb');
	      set_default_class_property_value($r, 'video');
	      set_default_class_property_value($r, 'ore');
	      set_default_class_property_value($r, 'visite');
	      set_default_class_property_value($r, 'studi');
	      set_default_class_property_value($r, 'note');
	      set_default_class_property_value($r, 'pioniere', $proc->pioniere);
	      set_default_class_property_value($r, 'irreg');
	      $array[] = $r;
	    }
	      
	//   print_r($array);
      
      }
      return $array;
  }
  
  
  function get_reports_row($proc_id, $ts_report = false, $segmented_by_month = false) {
      if($ts_report)
	$this->process_ts($ts_report);
      
      $proc_id = my_escape($proc_id);
      
      if($segmented_by_month) 
	$add_sql_group = "GROUP BY ts_report";
      else
	$add_sql_group = '';
      
      if(!empty($proc_id)) {
      
	  $sql = "SELECT * FROM reports WHERE id_p = {$proc_id} AND {$this->ts_sql_filter} $add_sql_group";
	 // echo $sql;
	  return my_query($sql, 1);
      }

  }
  
  
  function get_reports_sum($proc_id, $ts_report = false){
      
      if($ts_report)
	$this->process_ts($ts_report);
      
      $proc_id = my_escape($proc_id);
      
      if(!empty($proc_id)) {
      
	  $sql = "SELECT SUM(pubb) AS pubb, SUM(video) AS video, SUM(ore) AS ore, SUM(visite) AS visite, SUM(studi) AS studi FROM reports WHERE id_p = {$proc_id} AND {$this->ts_sql_filter} $add_sql_group";
	  return my_query($sql, 1);
	  
      }

  }
  
   function get_proc_list($id = 1, $type = 'all') {
  
      $id = my_escape($id);
  
      switch($type){
	case 'gruppo':
	  $where_field = 'p.gruppo_id';
	break;
	case 'proc':
	  $where_field = 'p.id';
	break;
	case 'all':
	  $where_field = 1;
      }

      if(!empty($id)) {
	
	 $sql = "SELECT p.id, p.gruppo_id, g.nome_gruppo, p.nome, p.cognome, p.pioniere, p.servitore, p.unto, p.anziano FROM proclamatori AS p LEFT JOIN gruppi AS g ON g.id = p.gruppo_id WHERE {$where_field} = {$id} AND p.status = '0' ORDER BY cognome ASC";
	
	 return my_query($sql, 1);
	 
      }

  }
  
    function get_proc_ext_info($id) {
      
      $id = my_escape($id);
	
	 $sql = "SELECT p.*, c.comune, c.address, c.n_casa, c.n_cell, c.email FROM proclamatori AS p LEFT JOIN contatti AS c ON p.id = c.id_p WHERE p.id = {$id}";
	
	 return my_query($sql, 1);
	 
      }

  
  
    function get_missing_reports($ts_report = false) {
    $html='';
      if($ts_report)
	$this->process_ts($ts_report);
      
      	$proc_list = $this->get_proc_list();
	foreach($proc_list as $proc) {
	
	  // for each proc do this..
	    $proc = array2object($proc);
	    $r = $this->get_reports_row($proc->id, $ts_report);
	    
	    if(!$r) $html.= "<li>Rapporto mancante: <b>{$proc->nome} {$proc->cognome}</b> -> gruppo {$proc->nome_gruppo}";
	    else $html.='';
	}
	
	return $html;
    }
}