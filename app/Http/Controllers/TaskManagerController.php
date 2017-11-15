<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Task;
use App\TaskList;
use Illuminate\Support\Facades\Auth;

class TaskManagerController extends Controller
{

	public function getTask($post = []){

		//$tasks = Task::all();
    	//return $tasks;


        ////////////////

        $tasks = Task::all();
          //return dd($tasks = Task::all());
          //return dd($tasks->tasks());
          //$all = [];
          //$tasks->cards;

        //$carts = TaskList::all();




        return $tasks;

    }


    public function deleteTask($post = []){

        $delete_task = Task::find($post['id']);
        $delete_task->delete();

    	$tasks = Task::all();

    	return $tasks;

    }


    public function addTask($post = []){

		//return $request->name_task_block;
      	//dd(request()->name_task_block);
      	//return $post['name'];
		
    	$task = new Task();
    	$task->name = $post['name_task_block'];
    	$task->user_id = Auth::user()->users_id;
    	$task->save();

    	$data = Task::all();

    	return $data;

    }

    public function createCard($post = []){

        //dd($post);
        $task = new TaskList();
        $task->name = $post['name_card'];
        $task->user_id = Auth::user()->users_id;
        //$task->task_id = $post['task_id'];
        $task->task_id = '1';
        $task->save();

        //$data_card = Task::all();

        //return $data_card;

    }

}
