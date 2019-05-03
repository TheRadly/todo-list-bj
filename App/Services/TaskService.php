<?php

namespace App\Services;

use App\Utils\MySQL;

class TaskService {

    public function CreateTask($login,$email,$task){

        $checked = 0;

        $stm = MySQL::$db->prepare("INSERT INTO tasks VALUES( DEFAULT, :login, :email, :task, :checked)");
        
        $stm->bindParam(':login' , $login , \PDO::PARAM_STR);
        $stm->bindParam(':email' , $email , \PDO::PARAM_STR);
        $stm->bindParam(':task', $task, \PDO::PARAM_STR);
        $stm->bindParam(':checked', $checked, \PDO::PARAM_STR);$stm->execute();

        return MySQL::$db->lastInsertId();

    } // CreateTask

    public function GetTaskList($limit = 3, $offset = 0, $sort = 1, $asc_desc = "ASC"){

        $stm = MySQL::$db->prepare("SELECT * FROM tasks ORDER BY :sort $asc_desc LIMIT :offset, :limit");

        $stm->bindParam(':offset' , $offset , \PDO::PARAM_INT);
        $stm->bindParam(':limit' , $limit , \PDO::PARAM_INT);
        $stm->bindParam(':sort' , $sort , \PDO::PARAM_INT);

        $stm->execute();

        return $stm->fetchAll(\PDO::FETCH_OBJ);

    } // GetTaskList

    public function GetCurrentTask($id){

        $stm = MySQL::$db->prepare("SELECT * FROM tasks WHERE id = :id");

        $stm->bindParam(':id', $id,\PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetch(\PDO::FETCH_OBJ);

    } // GetCurrentTask

    public function UpdateCurrentTask($id, $task){

        $stm = MySQL::$db->prepare("UPDATE tasks SET task = :task WHERE id = :id");

        $stm->bindParam(':id', $id,\PDO::PARAM_INT);
        $stm->bindParam(':task', $task,\PDO::PARAM_STR);

        $stm->execute();

    } // UpdateCurrentTask

    public function SetChecked($id, $checked){

        $stm = MySQL::$db->prepare("UPDATE tasks SET checked = :checked WHERE id = :id");

        $stm->bindParam(':id', $id,\PDO::PARAM_INT);
        $stm->bindParam(':checked', $checked,\PDO::PARAM_INT);

        $stm->execute();

    } // SetChecked

} // TaskService