<?php

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