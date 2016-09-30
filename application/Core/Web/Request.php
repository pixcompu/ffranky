<?php

namespace Application\Core\Web;
use Exception;

/**
 * Request Class
 */
abstract class Request {

    private $errors;
    private $input;

    /**
     * Initialize new Request
     */
    public function __construct() {
        $this->errors = array();
        $this->input = $_REQUEST;
    }
    
    /**
     * Set custom input instead of super global variable
     * @param array $input
     */
    public function setInput(array $input){
        $this->input = $input;
    }

    /**
     * Actual validation
     * @throws Exception
     */
    public function validate() {
        if (!$this->isAuthorized()) {
            $this->onAuthorizationFailed();
        }
        if (!$this->isValid()) {
            $this->onValidationFailed();
        }
    }
    
    /**
     * Returns if there is errors from the last validation
     * @return boolean
     */
    public function hasErrors(){
        return count($this->errors) > 0;
    }

    /**
     * Return the errors
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Get one input name or all if no input name especified
     * @param string $name
     * @return mixed
     */
    public function getInput($name = null){
        if(is_null($name)){
            return $this->input;
        }else{
            if(isset($this->input[$name])){
                return $this->input[$name];
            }else{
                return null;
            }
        }
    }
    
    /**
     * Return validation rules
     * @return array
     */
    public abstract function rules();
    
    /**
     * Check if the request has permisions
     * @return boolean
     */
    protected function isAuthorized() {
        return true;
    }

    /**
     * Handle validation failure
     */
    protected function onValidationFailed() {
        
    }
    
    /**
     * Handle authorization failure
     */
    protected function onAuthorizationFailed(){
        
    }

    /**
     * Check if all fields pass the validations
     * @return boolean
     */
    private function isValid() {
        foreach ($this->rules() as $field => $rules) {
            $this->proccessRequest($field, $rules);
        }
        return count($this->errors) === 0;
    }

    /**
     * Do the actual validation for each field
     * @param string $field
     * @param string $rules
     */
    private function proccessRequest($field, $rules) {
        $value = $this->getValue($field);
        $ruleList = explode("|", $rules);
        $hasRequiredRule = in_array("required", $ruleList);

        if ($hasRequiredRule && is_null($value)) {
            $this->errors[$field] = $field . " es requerido";
        } else if (!is_null($value)) {
            $ruleList = array_diff($ruleList, ["required"]);
            if(count($ruleList)>0){
                $this->applyRules($field, $value, $ruleList);
            }
        }
    }

    /**
     * Test if field passes all his validations
     * @param string $field
     * @param mixed $value
     * @param array $ruleList
     */
    private function applyRules($field, $value, $ruleList) {
        foreach ($ruleList as $rule) {
            if (!$this->rulePass($value, $rule)) {
                $this->errors[$field] = "Campo no paso la regla " . $rule;
                break;
            }
        }
    }

    /**
     * Get value from input considering nesting with dot notation
     * @param string $field
     * @return mixed
     */
    private function getValue($field) {
        $nestedItems = explode('.', $field);
        $input = $this->input;
        for ($i = 0; $i < count($nestedItems); $i++) {
            if (!isset($input[$nestedItems[$i]])) {
                return null;
            }else{
                $input = $input[$nestedItems[$i]];
            }
        }
        return $input;
    }

    /**
     * Actual test corresponding to rule, if not found will try to match a class function
     * @param string $input
     * @param string $rule
     * @return boolean
     */
    private function rulePass($input, $rule) {
        switch ($rule) {
            case "array":
                return is_array($input);
            case "integer":
                return ctype_digit(strval($input));
            case "string":
                return is_string($input);
            case "double":
                return is_float($input);
            case "boolean":
                return is_bool($input);
            case "numeric":
                return is_numeric($input);
            default:
                if (method_exists($this, "validate" . ucwords($rule))) {
                    return $this->{"validate" . ucwords($rule)}($input);
                }
        }
        return false;
    }

}
