<?php

namespace App\Controllers;

use App\Services\TaskService;
use App\Controllers\BaseController as BaseController;
use Couchbase\Exception;

class TaskController extends BaseController {

    public function GetTaskPageAction(){

        $template = $this->twig->load('Task.twig');

        echo $template->render(['cookie' => isset($_COOKIE['id']) ? $_COOKIE['id']:null]);

    } // GetTaskPage

    public function AddTask(){

        $task = new TaskService();

        $postEmail = $_POST['email_cTask'];
        $postLogin = $_POST['login_cTask'];
        $postTask = $_POST['task_cTask'];

        if(!filter_var($postEmail, FILTER_VALIDATE_EMAIL)){

            echo "E-Mail '$postEmail' указан не верно! Пример: mail@example.com <br> <a href='/'>На главную</a>";
            exit;

        } // If

        $task->CreateTask($postLogin,$postEmail,$postTask);

        header('Location: /');
        exit;

    } // AddTask

    public function GetListTasksAction(){

        $task = new TaskService();

        $task->GetTaskList(3,0);

    } // GetListTasks

    public function SetCheckedTask(){

        $checked = $_POST['checked'];
        $checkedTaskID = $_POST['checked_task_id'];

        $task = new TaskService();

        try {

            $task->SetChecked($checkedTaskID, $checked);

            header('Location: /');
            exit;

        } // Try

        catch (\Exception $ex){
            echo 'Error: ' . $ex;
        } // Catch

    } // SetCheckedTask

    public function GetEditTaskPageAction($id){

        $task = new TaskService();

        try {

            $currentTask = $task->GetCurrentTask($id);
            $template = $this->twig->load('EditTask.twig');

            echo $template->render(['cookie' => isset($_COOKIE['id']) ? $_COOKIE['id']:null, 'currentTask'=> $currentTask]);

        } // Try

        catch (\Exception $ex){
            echo 'Error: ' . $ex;
        } // Catch


    } // GetEditTaskPageAction

    public function EditTask(){

        $editingTask = $_POST['task_eTask'];
        $id = $_POST['id_eTask'];

        $taskService = new TaskService();

        try {

            $taskService->UpdateCurrentTask($id,$editingTask);

            header('Location: /');
            exit;

        } // Try

        catch (\Exception $ex){
            echo 'Error: ' . $ex;
        } // Catch

    } // EditTask

} // TaskController		