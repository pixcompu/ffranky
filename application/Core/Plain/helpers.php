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

function printFonts($fonts){

}