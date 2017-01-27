<?php
	header('Content-Type:application/json');
	header('Content-type: application/json; charset=utf-8');
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header('Access-Control-Allow-Origin: *');

	// show errors
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	//echo "<h1>Hello api :)</h1>";
	
	$method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/',trim($_GET['PATH_INFO'],'/'));
	if($request[0]=='api')
	{
	    if ($request[1] == 'v1')
    	    require 'api/v1/Api.php';
		$api = new Api($method);
		$api = $api->get_app(array_slice ($request, 1));
		if($api!=null)
		{
			echo json_encode($api);
		}/*
		else {
		    echo '{"result": "without response"}';
		}*/
		
	}
	

?>
