<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Utils\Request;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use App\Utils\MySQL;

class BaseController {

    protected $request;

    protected $loader;
    protected $twig;

    protected $user;

    public function __construct(){

        MySQL::$db = new \PDO(
            "mysql:dbname=radly;host=mysql.zzz.com.ua;charset=utf8",
            "radlybejee",
            "Qwerty12345"
        );

        $this->loader = new Twig_Loader_Filesystem('./App/Templates');
        $this->twig = new Twig_Environment($this->loader);

    } // __construct

    protected function createUrl( $controller , $action ){

        return "?ctrl=$controller&act=$action";

    } // CreateURL

    protected function json( $code , $data ){

        http_response_code($code);
        header('Content-type: application/json');

        echo json_encode($data); //  res.send();

        exit();

    } // JSON

} // BaseController