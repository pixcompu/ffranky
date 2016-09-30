<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 29/09/2016
 * Time: 04:57 PM
 */

namespace Application\Http\Controller;

use Application\Core\Web\Controller;

class MainController extends Controller
{
    public function index()
    {
        $this->view->withSection('pageContent', 'main')->withStyle('site')->withBottomScript('site')->render();
    }
}