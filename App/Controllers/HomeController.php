<?php

namespace App\Controllers;

use App\Services\TaskService;
use App\Controllers\BaseController as BaseController;
use App\Services\UserService;

class HomeController extends BaseController {

    public function indexAction() {

        $taskService = new TaskService();

        $limit = 3;
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        $offset = $offset< 0 ? 0: $offset;

        $listTasks = $taskService->GetTaskList($limit, $offset, 1);
        $countTasks = count($listTasks);

        if(isset($_GET['sortType']) && isset($_GET['sort'])){

            $getSortType = $_GET['sortType'];
            $getSort = $_GET['sort'];
            $sortType = null;
            $sort = '';

            switch ($getSortType) {

                case 'login_sort':
                    $sortType = 2;
                    break;
                case 'email_sort':
                    $sortType = 3;
                    break;
                case 'task_sort':
                    $sortType = 4;
                    break;
                default:
                    break;

            } // Switch

            switch ($getSort){

                case 'asc':
                    $sort = "ASC";
                    break;
                case 'desc':
                    $sort = "DESC";
                    break;
                default:
                    break;

            } // Switch

            $listTasks = $taskService->GetTaskList($limit, $offset, $sortType, $sort);

        } // If

        $template = $this->twig->load('Home.twig');

        echo $template->render(
            [ 'listTasks' => $listTasks, 'limit' => $limit,
            'offset' => $offset, 'cookie' => isset($_COOKIE['id']) ? $_COOKIE['id']:null,
            'countTasks' => $countTasks
            ]);

    } // indexAction

} // HomeController