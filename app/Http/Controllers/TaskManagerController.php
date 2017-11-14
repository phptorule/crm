<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskManagerController extends Controller
{

	public function getTask($post = []){

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
    	



      	
		//$post
    	//return $request->finances_id; 

    	//return response()->json($post);

    	//return view('test', compact('post'));


    }

}
