<?php

/**
 * @param $message
 * @param int $code
 * @throws Exception
 */
function error( $message = 'Hubo un error inesperado' , $code = 500)
{
    throw new Exception( $message , $code );
}