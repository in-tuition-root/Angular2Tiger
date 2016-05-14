<?php
/**
 * Created by PhpStorm.
 * User: nejindal
 * Date: 5/8/2016
 * Time: 1:32 PM
 */

define("RATING","integer");

//this function checks if a mongodb field is numeric
function isNumericKey($key){

    if(defined(strtoupper($key))){
        if(constant(strtoupper($key)) == "integer"){
            return true;
        }
    }
    return false;
}