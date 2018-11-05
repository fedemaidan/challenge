<?php

declare(strict_types=1);

use Controller\TeamController;
use Controller\PlayerController;

include 'autoload.inc.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: PUT, POST, GET, DELETE, OPTIONS');

$requestUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$controllerAction = explode('/', $_SERVER['REQUEST_URI']);


if ($controllerAction[1] == "") {
	var_dump("Welcome");
}
else {

	$method = $_SERVER["REQUEST_METHOD"];
	$finalParams  = [];
	switch ($method) {
		case "GET":
			$execute = "get";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			break;
		case "PUT":
			$execute = "edit";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			$finalParams = json_decode(file_get_contents("php://input"),true);
			break;
		case "POST":
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			$execute = $id ? "edit" : "create";
			$finalParams = json_decode(file_get_contents("php://input"),true);
			break;
		case "DELETE":
			$execute = "delete";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			break;
	}

	switch ($controllerAction[2]) {
		case 'team':
			$controller = new TeamController;
			break;
		case 'player':
			$controller = new PlayerController;
			break;
		default:
			var_dump("Welcome");die;
			break;
	}

	$actionName = $execute.'Action';
	

	if ($id) {
		$finalParams["id"] = $id;
	}
	
	$controller->$actionName($finalParams);
}

?>