<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Task;
use App\TaskList;
use Illuminate\Support\Facades\Auth;

class TaskListController extends Controller
{

	public functiosn getTask($post = []){

		$tasks_list = TaskList::all();
    	return $tasks_list;

    }


    public function deleteTask($post = []){

        $delete_task = TaskList::find($post['id']);
        $delete_task->delete();

    	$tasks_list = Task::all();

    	return $tasks_list;

    }


    public function addTask($post = []){

		//return $request->name_task_block;
      	//dd(request()->name_task_block);
      	//return $post['name'];
		
    	$task = new TaskList();
    	$task->name = $post['name_task_block'];
    	$task->user_id = Auth::user()->users_id;
        $task->task_id = $post['task_id'];
    	$task->save();

    	$data_list = Task::all();

    	return $data_list;

    }

}
