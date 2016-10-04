<?php
/**
 * Views
 */

function printStyles($styles)
{
    $styleTemplate = "<link rel='stylesheet' href='%s'>";
    foreach($styles as $style) {
        echo sprintf($styleTemplate, $style);
    }
}

function printScripts($topScripts)
{
    $scriptTemplate = "<script src='%s'></script>";
    foreach($topScripts as $script) {
        echo sprintf($scriptTemplate, $script);
    }
}

function url($url){
    echo getUrl($url);
}

function getUrl($url){
    return CLIENT_ROOT_FOLDER . $url;
}

function asset($name){
    echo getAsset($name);
}

function getAsset($name){
    return CLIENT_PUBLIC_FOLDER . "/" . $name;
}

function isAdmin(){
    return true;
    //return isset($isAdmin) && $isAdmin;
}

function redirect($url){
    header('Location: ' . getUrl($url));
}

function echoOrEmpty($value){
    echo getValue($value);
}

function getValue($value){
    return isset($value) ? $value : '';
}

function goBack(){
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}


////////////////////////////////LOG START

/**
 * @param $message
 * @param null $filename
 */
function logToFile($message, $filename = null)
{
    $name = is_null($filename) ? date('Y-m-d') : $filename;
    $file = fopen( SERVER_APPLICATION_FOLDER . '/Storage/' . $name . '.txt', "a");
    $transformedMessage = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $message;
    fwrite($file, $transformedMessage . "\n");
    fclose($file);
}

/**
 * @param Exception $exception
 */
function logToFileException($exception){
    log("Exception : " . print_r($exception->getTrace(), true));
}

////////////////////////////////LOG END

////////////////////////////////RESPONSE START


function responseWithSuccess($data = array(), $statusDescription = 'Operacion completada con exito'){
    $response = array();
    $response['data'] = $data;
    $response['status'] = 'success';
    $response['status_code'] = 200;
    $response['status_description'] = $statusDescription;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    return;
}

function responseWithError($errorCode = 500, $statusDescription = 'Ocurrio un error'){
    $response = array();
    $response['data'] = [];
    $response['status'] = 'failure';
    $response['status_code'] = $errorCode;
    $response['status_description'] = $statusDescription;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
    return;
}

///////////////////////////////////////RESPONSE END

///////////////////////////////////////EXCEPTION START

/**
 * @param $message
 * @param int $code
 * @throws Exception
 */
function error( $message = 'Hubo un error inesperado' , $code = 500)
{
    throw new Exception( $message , $code );
}

///////////////////////////////////////EXCEPTION END