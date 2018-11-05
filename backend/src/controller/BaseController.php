<?php

/**
 * Base Controller
 */

namespace Controller;

class BaseController
{
    protected function message($success, $message, $data ) {
    	return json_encode(["success" => $success, "message" => $message, "data" => $data]);
    }
}

?>