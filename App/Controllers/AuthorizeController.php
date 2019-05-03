<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Controllers\BaseController as BaseController;

class AuthorizeController extends BaseController{

    public function GetAuthorizePageAction(){

        $template = $this->twig->load('Authorize.twig');

        echo $template->render();

    } // GetAuthorizePageAction

    public function Authorize(){

        $task = new UserService();

        $postLogin = $_POST['login_authorize'];
        $postPassword = $_POST['pass_authorize'];

        $data = $task->GetUser($postLogin);

        if($data->userPassword === $postPassword){

            $hash = md5(self::GenerateCode(10));

            $task->UpdateHash($postLogin, $hash);

            setcookie("id", $data->userID, time()+60*60*24*30);

            setcookie("hash", $hash, time()+60*60*24*30);

            header('Location: /');
            exit();

        } // If
        else {

            print "Вы ввели неправильный логин/пароль";

        } // Else

    } // AddTask

    public static function GenerateCode($length=6) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

        $code = "";

        $clen = strlen($chars) - 1;

        while (strlen($code) < $length) {

            $code .= $chars[mt_rand(0,$clen)];

        } // While

        return $code;

    } // GenerateCode

    public function LogOut(){

        setcookie("id", '', time()-3600);
        setcookie("hash", '', time()-3600);

        unset($_COOKIE['id']);
        unset($_COOKIE['hash']);

        header('Location: /');
        exit();

    } // LogOut

} // AuthorizeController