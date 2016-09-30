<?php

namespace Application\Core\Web;

use Application\Core\View;

abstract class Controller
{
    protected $view;
    public function __construct()
    {
        $this->view = new View();
    }
}