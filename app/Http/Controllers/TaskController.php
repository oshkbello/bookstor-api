<?php

namespace App\Http\Controllers;

use App\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $task = new Task;
        $task->title = 'Eating breakfast';
        $task->body = 'Remember to buy bread, egg and milk.';
        $task->user_id = 054;
        $task->done = 0;
        $task->save();
    }
}