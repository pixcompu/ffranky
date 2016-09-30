<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 29/09/2016
 * Time: 05:28 PM
 */

namespace Application\Core;

define('PAGE_STYLE_SECRET_KEYWORD', 'pageUniqueLongAssNameToAvoidCollisionsStyle');
define('PAGE_TOP_SCRIPT_SECRET_KEYWORD', 'pageUniqueLongAssNameToAvoidCollisionsTopScript');
define('PAGE_BOTTOM_SCRIPT_SECRET_KEYWORD', 'pageUniqueLongAssNameToAvoidCollisionsBottomScript');
define('PAGE_SECTION_SECRET_KEYWORD', 'pageUniqueLongAssNameToAvoidCollisionsSection');

class View
{
    private $vars;
    private $template;

    public function __construct()
    {
        $this->vars = [
            PAGE_STYLE_SECRET_KEYWORD => [],
            PAGE_TOP_SCRIPT_SECRET_KEYWORD => [],
            PAGE_BOTTOM_SCRIPT_SECRET_KEYWORD => [],
            PAGE_SECTION_SECRET_KEYWORD => [],
            'pageContent' => '',
            'pageTitle' => 'title'
        ];
    }

    public function __get($name)
    {
        return $this->vars[$name];
    }

    /**
     * @param $filename
     * @return $this
     */
    public function withStyle($filename, $isLink = false)
    {
        if(!$isLink){
            $filename = CLIENT_PUBLIC_FOLDER . "/style/" . $filename . ".css";
        }
        $this->vars[PAGE_STYLE_SECRET_KEYWORD][] =  $filename;
        return $this;
    }

    /**
     * @param $filename
     * @return $this
     */
    public function withTopScript($filename, $isLink = false)
    {
        if(!$isLink){
            $filename = CLIENT_PUBLIC_FOLDER . "/script/" . $filename . ".js";
        }
        $this->vars[PAGE_TOP_SCRIPT_SECRET_KEYWORD][] =  $filename;
        return $this;
    }

    /**
     * @param $filename
     * @return View $this
     */
    public function withBottomScript($filename, $isLink = false)
    {
        if(!$isLink){
            $filename = CLIENT_PUBLIC_FOLDER . "/script/" . $filename . ".js";
        }
        $this->vars[PAGE_BOTTOM_SCRIPT_SECRET_KEYWORD][] =  $filename;
        return $this;
    }

    public function withSection($key, $filename)
    {
        $this->vars[$key] = file_get_contents(SERVER_VIEWS_FOLDER . "/section/" . $filename . ".php");
        return $this;
    }

    public function with($key, $value)
    {
        $this->vars[$key] = $value;
        return $this;
    }

    public function setTemplate($filename)
    {
        $this->template = $filename;
    }

    public function render()
    {
        foreach($this->vars as $key => $value){
            ${$key} = $value;
        }
        if(is_null($this->template)){
            require_once 'Plain/template.php';
        }else{
            require_once SERVER_ROOT_FOLDER . "/" . $this->template . ".php";
        }
    }
}