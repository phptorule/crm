<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TasksLists;
use App\Cards;
use App\Users;
use App\UsersTeams;
use App\CardsUsers;
use Illuminate\Support\Facades\Auth;

class TaskmanagerController extends Controller
{

	public function getTask($post = []){

        $tasks = TasksLists::all();

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;

    }


    public function deleteTask($post = []){

        $delete_task = TasksLists::find($post['id']);
        $delete_task->delete();

    	$tasks = TasksLists::all();

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;

    }


    public function addTask($post = []){
		
    	$task = new TasksLists();
    	$task->name = $post['name_task_block'];
    	$task->user_id = Auth::user()->users_id;
    	$task->save();

    	$tasks = TasksLists::all();

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;

    }

    public function createCard($post = []){

        $card = new Cards();
        $card->name = $post['name_card'];
        $card->user_id = Auth::user()->users_id;
        $card->task_id = $post['task_id'];
        $card->save();

        $tasks = TasksLists::all();

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;

    }

    public function saveTitle($post = []){
        

        $task_change = TasksLists::find($post['id']);
        $task_change->name = $post['name'];
        $task_change->save();

        $tasks = TasksLists::all();

        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;

    }

    public function saveCard($post = []){

        $card = Cards::find($post['id']);
        $card->name = $post['name'];
        $card->description = $post['description'];
        $card->save();

        $card = Cards::find($post['id']);

        return $card;


    }


    public function getCard($post = []){

        $card = Cards::find($post['card_id']);
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));

        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
        }

        $card->users = $users;      

        return $card;

    }

    public function reset($post = []){
        
        $card = Cards::find($post['card_id']);
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));

        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
        }

        $card->users = $users;      

        return $card;

    }

    public function addToCard($post = []){
        
        //Зберігає звязок користувача з карткою
        /*
        $cards_users = new CardsUsers();
        $cards_users->user_id = $post['user_id'];
        $cards_users->card_id = $post['card_id'];
        $cards_users->save();

        //Бибирає картку
        $card = Cards::find($post['card_id']);

        //Вибирає id всіх користувачів команди доданих до картки
        $users_in_card = CardsUsers::where('card_id',$post['card_id'])->get();

        //Вибирає всіх звязки користувачів з тіми
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));


        foreach ($users_in_card as $user_in_this_card) {

            //Добавляє в массив всі дані користувача в картці
            $users_in_card[] = Users::find($user_in_this_card->user_id);


            
        }

        foreach ($teams_users as $user) {

            $users[] = Users::where('users_id',$user->users_id)->get();

        }

        

        $card->users = $users;
        $card->users_in_card = $users_in_card;

        return $card;
        */

    }

    
    public function saveCardTitle($post = []){
        

        $card_change = Cards::find($post['id']);
        $card_change->name = $post['name'];
        $card_change->save();

        $card = Cards::find($post['id']);
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));

        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
        }

        $card->users = $users;      

        return $card;

    }  


}
