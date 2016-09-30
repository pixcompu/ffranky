<?php

namespace Application\Http\Request;
use Application\Core\Web\Request;

class DummyRequest extends Request{

    public function rules() {
        return [
            "dummy" => "required|integer|positive|eggs"
        ];
    }
    
    public function validatePositive($value){
        return $value > 0;
    }
    
    public function validateEggs($value){
        return false;
    }
    
}