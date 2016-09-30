<?php

namespace Application\Http\Request;
use Application\Core\Web\Request;


/**
 * Description of DefaultRequest
 *
 * @author PIX
 */
class DefaultRequest extends Request{


    /**
     * Return validation rules
     * @return array
     */
    public function rules()
    {
       return [];
    }
}
