<?php

declare(strict_types=1);

use Controller\TeamController;

include 'autoload.inc.php';
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
			$controllerAction[2] = "get";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			break;
		case "PUT":
			$controllerAction[2] = "edit";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			parse_str(file_get_contents("php://input"),$finalParams);
			break;
		case "POST":
			$controllerAction[2] = "create";
			$finalParams = $_POST;
			break;
		case "DELETE":
			$controllerAction[2] = "delete";
			$id = $controllerAction[3] ? $controllerAction[3] : null;
			break;
	}

	$action = explode('?', $controllerAction[2]);
	$controllerName = ucwords($controllerAction[1]).'Controller';
	$actionName = $action[0].'Action';

	if ($id) {
		$finalParams["id"] = $id;
	}

	$controller = new TeamController;
	$controller->$actionName($finalParams);
}
