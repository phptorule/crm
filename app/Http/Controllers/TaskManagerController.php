<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use App\TasksLists;
use App\Cards;
use App\Teams;
use App\Users;
use App\UsersTeams;
use App\CardsUsers;
use App\CardsComments;
use App\Checklist;
use App\Checklistvalue;
use Illuminate\Support\Facades\Auth;

class TaskManagerController extends Controller
{

    public function getTeamUsers($post = []) {
        $team = Teams::find(session('current_team'));
        return $team->users()->get();
    }

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

        //message - toomorow deadline
        $reddata = strtotime($card->deadline) - strtotime(date('Y-m-d'));
        $card->reddata =  date('d',$reddata) - 1;

        //users in team
        /*$teams_users = UsersTeams::all()->where('teams_id',session('current_team'));
        $team = Teams::find(session('current_team'));
        $teeamuser = $team->users()->get();
        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
            $users_in_work[] = CardsUsers::all()->where('user_id',$user->users_id)->where('card_id',$post['card_id'])->first();

        }

        foreach ($users_in_work as $value) {
            $users_work_in_card[] = Users::find($value->user_id);
        }


        //all users in team
        $card->users = $users;
        //all users work in card
        $card->users_work_in_card = $users_work_in_card;
        //all users no work in card*/

        //print_r($card);

        $card_users = CardsUsers::where('card_id', $post['card_id'])->get();

        foreach ($card_users as $value) {
            $card->card_users = Users::find($value->user_id);
        }


        //return comment
        $comments = CardsComments::where('card_id', $post['card_id'])->get();
        foreach ($comments as $value) {
            $value->users = Users::find($value->user_id)->first();
        }

        //return checklist
        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }

        $card->comments = $comments;
        $card->checklist = $checklist;

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

    public function saveUserToCard($post = []){

        $user_card = new CardsUsers();
        $user_card->user_id = $post['user_id'];
        $user_card->card_id = $post['card_id'];
        $user_card->save();

        $cards_users = CardsUsers::all()->where('card_id',$post['card_id']);

        foreach ($cards_users as $value) {
            $users_works_in_card[] = Users::find($value->user_id);
        }

        return $users_works_in_card;
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


    // Comments begin


    public function saveComment($post = []){

        $comments = new CardsComments();
        $comments->card_id = $post['card_id'];
        $comments->user_id = Auth::user()->users_id;
        $comments->text = $post['text'];
        $comments->save();

        $comments = CardsComments::where('card_id',$post['card_id'])->get();
        foreach ($comments as $value) {
            $value->users = Users::find($value->user_id)->first();
        }
        return $comments;
    }
    // Comments end


    // Checklist begin

    public function saveChecklistTitle($post = []){

        $checklist = new Checklist();
        $checklist->title = $post['title'];
        $checklist->user_id = Auth::user()->users_id;
        $checklist->card_id= $post['card_id'];
        $checklist->save();

        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }
        return $checklist;
    }

    public function saveChecklistValue($post = []){

        $checklist_value = new ChecklistValue();
        $checklist_value->title = $post['title'];
        $checklist_value->checklist_id = $post['checklist_id'];;
        $checklist_value->save();

        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }
        return $checklist;

    }

    public function saveChangeChecklistStatus($post = []){

        $checklist_value = ChecklistValue::find($post['checkbox_value_id']);
        if($checklist_value->status == 0){
            $checklist_value->status = 1;
        }else{
            $checklist_value->status = 0;
        }
        $checklist_value->save();

        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }

        return $checklist;
    }

    public function deleteCheckList($post = []){

        $checklist = Checklist::find($post['checklist_id']);
        $checklist->delete();

        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }
        return $checklist;
    }

    public function deleteCheckBox($post = []){

        $checkbox = ChecklistValue::find($post['checkbox_id']);
        $checkbox->delete();

        $checklist = Checklist::where('card_id',$post['card_id'])->get();
        foreach ($checklist as $value) {
            $value->checklist_value = ChecklistValue::all()->where('checklist_id',$value->id);
        }
        return $checklist;
    }

    //Checklist end


    public function saveDeadline($post = []){

        $cards = Cards::find($post['card_id']);


        $reddata = strtotime($post['deadline']);
        $cards->deadline =  date('Y-m-d',$reddata + 86400);
        $cards->save();

        $card = Cards::find($post['card_id']);

        //message - toomorow deadline
        $reddata = strtotime($card->deadline) - strtotime(date('Y-m-d'));
        $card->reddata =  date('d',$reddata) - 1;

        return $card;
    }
}
