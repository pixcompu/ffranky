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
define('PAGE_CONTENT_SECRET_KEYWORD', 'pageContent');
define('PAGE_TITLE_SECRET_KEYWORD', 'pageTitle');

class View
{
    private $vars;
    private $sections;
    private $template;

    public function __construct()
    {
        $this->vars = [
            PAGE_STYLE_SECRET_KEYWORD => [],
            PAGE_TOP_SCRIPT_SECRET_KEYWORD => [],
            PAGE_BOTTOM_SCRIPT_SECRET_KEYWORD => [],
            PAGE_SECTION_SECRET_KEYWORD => [],
            PAGE_CONTENT_SECRET_KEYWORD => '',
            PAGE_TITLE_SECRET_KEYWORD => 'title'
        ];

        $this->sections = [];
    }

    public function __get($name)
    {
        if(isset($this->sections[$name])){
            return $this->sections[$name];
        }else{
            return $this->vars[$name];
        }
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
        $this->sections[$key] = $filename;
        return $this;
    }

    public function withTitle($title)
    {
        return $this->with(PAGE_TITLE_SECRET_KEYWORD, $title);
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
        /**
         * Output variables
         */
        foreach($this->vars as $key => $value){
            ${$key} = $value;
        }
        /**
         * Use buffering to execute php code
         */
        foreach($this->sections as $key => $value){
            ob_start();
            include SERVER_VIEWS_FOLDER . "/section/" . $value . ".php";
            ${$key} = ob_get_contents();
            ob_end_clean();
        }
        if(is_null($this->template)){
            require_once 'Plain/template.php';
        }else{
            require_once SERVER_VIEWS_FOLDER . "/layout/" . $this->template . ".php";
        }
    }
}