<?php
function load_enums($table , $field){
	$query = "SHOW COLUMNS FROM ".$table." LIKE '$field'";
	$row = $this->db->query("SHOW COLUMNS FROM ".$table." LIKE '$field'")->row()->Type;
	$regex = "/'(.*?)'/";
	preg_match_all( $regex , $row, $enum_array );
	$enum_fields = $enum_array[1];
	foreach ($enum_fields as $key=>$value)
	{
		$enums[$value] = $value;
	}
	return $enums;
}

function loadCustList($branch = 1) {
    $commondb = new Commondb();
    $where = array('counterid' => $branch);

    $roleList = $commondb
        ->condition($where)
        ->table_name(V_CUST_LIST)
        ->limit_offset(-1, 0)
        ->do_read();
    return $roleList;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

