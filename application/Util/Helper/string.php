<?php

function isEmpty($string){
    return strlen(trim($string)) === 0;
}

function toString($value){
    return "'" . $value . "'";
}