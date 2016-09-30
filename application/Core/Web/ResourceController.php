<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 29/09/2016
 * Time: 04:45 PM
 */

namespace Application\Core\Web;


abstract class ResourceController extends Controller
{
    /**
     * Main view of resource
     * @return mixed
     */
    abstract function index();

    /**
     * Create form of resource
     * @return mixed
     */
    abstract function create();

    /**
     * Store action for resource
     * @return mixed
     */
    abstract function store();

    /**
     * Update action for resource
     * @return mixed
     */
    abstract function update();

    /**
     * Destroy action for resource
     * @return mixed
     */
    abstract function destroy();

}