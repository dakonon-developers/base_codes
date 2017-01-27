<?php
	header('Content-Type:application/json');
	require 'api/Api.php';
	
	//echo "<h1>Hello api :)</h1>";
	
	$method = $_SERVER['REQUEST_METHOD'];
	$request = explode('/',trim($_GET['PATH_INFO'],'/'));
	if($request[0]=='api')
	{
		$api = new Api($method);
		$api = $api->get_app(array_slice ($request, 1));
		if($api!=null)
		{
			echo json_encode($api);
		}
		
	}
	

?>
