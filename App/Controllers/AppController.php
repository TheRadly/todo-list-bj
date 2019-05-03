<?php

namespace App\Controllers;

use App\Controllers\BaseController as BaseController;
use Bramus\Router\Router;

class AppController extends BaseController {

    public function Start() {

        $router = new Router();

        $routes = array(

            'get' => [
                '/' => 'HomeController@indexAction',
                '/createTask' => 'TaskController@GetTaskPageAction',
                '/authorize' => 'AuthorizeController@GetAuthorizePageAction',
                '/logout' => 'AuthorizeController@LogOut'
            ],
            'post' => [
                '/taskCreated' => 'TaskController@AddTask',
                '/login' => 'AuthorizeController@Authorize',
                '/checkedTask' => 'TaskController@SetCheckedTask',
                '/editTask/(\d+)' => 'TaskController@GetEditTaskPageAction',
                '/editTask/taskEdited' => 'TaskController@EditTask'
            ]

        ); // $routes

        $router->setNamespace('App\\Controllers');

        $router->set404( function (){

            try {

                $template = $this->twig->load('ErrorPages/404-not-found.twig');
                echo $template->render();

            } // Try
            catch (\Exception $ex) {
                echo $ex;
            } // Catch

        }); // Set404

        foreach ($routes as $key => $path ){

            foreach ($path as $subKey => $value){

                $router->$key( $subKey , $value );

            } // Foreach

        } // Foreach

        $router->run();

    } // Start

} // AppController