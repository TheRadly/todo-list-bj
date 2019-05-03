<?php

return array(

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
);