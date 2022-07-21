<?php
require __DIR__ . "/bootstrap/bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
// print_r($uri);
if ((isset($uri[4]) && $uri[4] != 'order') || !isset($uri[5])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
require PROJECT_ROOT_PATH . "/Controllers/Api/OrderDetailsController.php";
 
$objFeedController = new OrderDetailsController();
$strMethodName = $uri[5] . 'Action';
$objFeedController->{$strMethodName}();
?>