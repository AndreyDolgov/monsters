<?php

if(!function_exists('dd')){
    function dd($data){
        var_dump($data);
        die();
    }
}
if(!function_exists('get_user')){
    //возвращает текущего пользователя
    function get_user()
    {
        //подразумеваем, что есть функционал для авторизации и пользователи у нас уже авторизированы
    }
}

if(!function_exists('error')){
    function error($mess)
    {
        echo $mess;
        die();
    }
}