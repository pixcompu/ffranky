<?php

function respondWithSuccess($data = array(),$statusDescription = 'Operacion completada con exito'){
    $response = array();
    $response['data'] = $data;
    $response['status'] = 'success';
    $response['status_code'] = 200;
    $response['status_description'] = $statusDescription;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
}

function respondWithError($errorCode = 500, $statusDescription = 'Ocurrio un error'){
    $response = array();
    $response['data'] = [];
    $response['status'] = 'failure';
    $response['status_code'] = $errorCode;
    $response['status_description'] = $statusDescription;
    echo json_encode($response, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
}