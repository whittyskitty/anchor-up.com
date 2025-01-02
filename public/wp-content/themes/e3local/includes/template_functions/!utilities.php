<?php 

function is_dev(){
	return getenv('ENV') == 'dev';
}


function theme_dir(){
    return get_template_directory();
}

function root_dir(){
	return ABSPATH.'..';
}

function _dd(){
    while (ob_get_level()) ob_end_clean();
	$to_dd = [];
	foreach ( func_get_args() as $k=>$v ){
		$to_dd[] = $v;
	}

	call_user_func_array('dd',$to_dd);
}

function _var_dump(){
	while (ob_get_level())
    {
        ob_end_clean();
    }
	ob_start();
	$to_dd = [];
	foreach ( func_get_args() as $k=>$v ){
		$to_dd[] = $v;
	}

	// call_user_func_array('dd',$to_dd);
	var_dump($to_dd);
	ob_end_flush();
	exit;
}

function _json_dump(){
	define( 'JSON_REQUEST',TRUE);
	while (ob_get_level())
    {
        ob_end_clean();
    }
	ob_start();
	$to_dd = [];
	foreach ( func_get_args() as $k=>$v ){
		$to_dd[] = $v;
	}

	// call_user_func_array('dd',$to_dd);
	echo json_encode(($to_dd));
	ob_end_flush();
	exit;
}

function _rawdd($obj){
	ob_end_clean();
	echo $obj;
	exit;
}