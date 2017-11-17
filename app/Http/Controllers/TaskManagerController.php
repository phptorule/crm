<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TasksLists;
use App\Cards;
use Illuminate\Support\Facades\Auth;

class TaskmanagerController extends Controller
{

	public function getTask($post = []){

		//$tasks = Task::all();
    	//return $tasks;


        ////////////////

        $tasks = TasksLists::all();
        //$mas = [];

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
            //array_push($mas, TaskList::where('task_id', $task->id));
        }
          //return dd($tasks = Task::all());
          //return dd($tasks->tasks());
          //$all = [];
          //$tasks->cards;

        //$carts = TaskList::all();
        //$tasks->cards = $card;
        //dd($tasks);




        return $tasks;

    }


    public function deleteTask($post = []){

        $delete_task = TasksLists::find($post['id']);
        $delete_task->delete();

    	$tasks = TasksLists::all();
        //$mas = [];

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
            //array_push($mas, TaskList::where('task_id', $task->id));
        }

        return $tasks;

    }


    public function addTask($post = []){

		//return $request->name_task_block;
      	//dd(request()->name_task_block);
      	//return $post['name'];
		
    	$task = new TasksLists();
    	$task->name = $post['name_task_block'];
    	$task->user_id = Auth::user()->users_id;
    	$task->save();

    	$tasks = TasksLists::all();
        //$mas = [];

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
            //array_push($mas, TaskList::where('task_id', $task->id));
        }

        return $tasks;

    }

    public function createCard($post = []){

        //dd($post);
        $card = new Cards();
        $card->name = $post['name_card'];
        $card->user_id = Auth::user()->users_id;
        //$task->task_id = $post['task_id'];
        $card->task_id = $post['task_id'];
        $card->save();



        $tasks = TasksLists::all();
        //$mas = [];

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
            //array_push($mas, TaskList::where('task_id', $task->id));
        }

        return $tasks;

        //$data_card = Task::all();

        //return $data_card;

    }

    public function saveCard($post = []){

        //dd($post);
        $card = Cards::find($post['id']);
        //dd($card);
        $card->name = $post['name'];
        //$card->user_id = Auth::user()->users_id;
        $card->description = $post['description'];
        $card->save();


        $card = Cards::find($post['id']);

        return $card;


    }

    public function getCard($post = []){

        //dd($post);
        $card = Cards::find($post['card_id']);
        //dd($card_modal);

        return $card;

    }


}
