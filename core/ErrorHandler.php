<?php
function MyErrorHandler($errno, $errstr, $errfile, $errline)
{
	$error = "";
    if (!(error_reporting() & $errno)) {
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        $error .= "<b>My ERROR</b> [$errno] $errstr<br />\n";
        $error .= "  Fatal error on line $errline in file $errfile";
        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $error .= "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        $error .= "<h4 align='center' style='margin-top:15%;color:#444'>My WARNING</b> [$errno] $errstr</h2>";
        break;

    case E_USER_NOTICE:
        $error .= "<h4 align='center' style='margin-top:15%;color:#444'>My NOTICE</b> [$errno] $errstr</h2>";
        break;

    default:
		$errstr = str_replace("call_user_func_array() expects parameter 1 to be a valid callback,","",$errstr);
        $error .= "<h4 align='center' style='margin-top:15%;color:#444'>$errstr</h4>";
        break;
    }
	throw new Exception($error);
}

//set_error_handler("MyErrorHandler");
