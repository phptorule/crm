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
use App\Checklists;
use App\Checkboxes;
use Illuminate\Support\Facades\Auth;

class TaskManagerController extends Controller
{
    public function getTeamUsers($post = []) {

        //користувачі в команді
        $team = Teams::find(session('current_team'));
        $team->teams  = $team->users()->get();
        foreach ($team->teams as $teams) {
            $a[] = $teams->users_id;
        }

        //користувачі в картці
        $users_in_card = Cards::find($post['cards_id']);
        $team->in_card = $users_in_card->users()->get();
        $b = [];
        foreach ($team->in_card as $card_users) {
            if(!empty($card_users->users_id)){
                $b[] = $card_users->users_id;
            }
        }

        //користувачі вкоманді, які не вибрані
        $result = array_diff($a,$b);
        if(count($result)>1){
            for ($i=0; $i < count($result); $i++) {
                $users_not_checked[] = Users::find($result[$i]);
            }
        }

        //із-за проблем з індексами
        if(count($result) == 1){
            if(!empty($result[0])){
                $users_not_checked[] = Users::find($result[0]);
            }
            if(!empty($result[1])){
                $users_not_checked[] = Users::find($result[1]);
            }
        }

        if(!empty($users_not_checked)){
            return $team->users_not_checked = $users_not_checked;
        }
    }

    public function getTask($post = []){

        $tasks = TasksLists::all();
        foreach ($tasks as $task) {
            $task->cards = Cards::where('task_id', $task->id)->get();
        }

        return $tasks;
    }

    public function getCard($post = []){
        $card = Cards::find($post['cards_id']);

        $card->users = $card->users()->get();    

        //message - toomorow deadline
        $reddata = strtotime($card->deadline) - strtotime(date('Y-m-d'));
        $card->reddata =  date('d',$reddata) - 1;

        //return comment
        $comments = CardsComments::where('cards_id', $post['cards_id'])->orderBy('created_at', 'desc')->get();
        foreach ($comments as $value) {
            $value->users = Users::find($value->users_id)->first();
        }

        //return checklists
        $checklists = Checklists::where('cards_id',$post['cards_id'])->get();
        foreach ($checklists as $value) {
            $value->checkboxes = Checkboxes::where('checklist_id', $value->id)->get();
        }

        $card->comments = $comments;
        $card->checklists = $checklists;

        return $card;
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
        $task->users_id = Auth::user()->users_id;
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
        $card->users_id = Auth::user()->users_id;
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

    public function saveCardDescription($post = []){
        $card = Cards::find($post['cards_id']);
        $card->description = $post['description'];
        $card->save();
    }

    public function reset($post = []){

        $card = Cards::find($post['cards_id']);
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));

        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
        }

        $card->users = $users;

        return $card;

    }

    public function saveUserToCard($post = []){
        if(!empty($post['users_id'])){
            $card = new CardsUsers();
            $card->cards_id = $post['cards_id'];
            $card->users_id = $post['users_id'];
            $card->save();
        }
    }

    public function removeUser($post = []){
        $card = CardsUsers::where('cards_id',$post['cards_id'])->where('users_id',$post['users_id'])->delete();
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

    public function saveComment($post = []){
        $comments = new CardsComments();
        $comments->cards_id = $post['cards_id'];
        $comments->users_id = Auth::user()->users_id;
        $comments->text = $post['text'];
        $comments->save();
    }
    // Comments end

    public function saveChecklist($post = []){
        $checklists = new Checklists();
        $checklists->title = $post['title'];
        $checklists->users_id = Auth::user()->users_id;
        $checklists->cards_id= $post['cards_id'];
        $checklists->save();
    }

    public function addCheckbox($post = []){
        $checkbox = new Checkboxes;
        $checkbox->checklist_id = $post['id'];
        $checkbox->title = $post['checkbox_title'];
        $checkbox->save();
    }

    public function saveCheckboxec($post = []){
        $checklists_value = Checkboxes::find($post['id']);
        $checklists_value->title = $post['title'];
        $checklists_value->save();
    }

    public function changeCheckboxStatus($post = []){
        $checkbox = Checkboxes::find($post['checkbox_value_id']);

        if($checkbox->status == 0){
            $checkbox->status = 1;
        }else{
            $checkbox->status = 0;
        }

        $checkbox->save();
    }

    public function deleteChecklists($post = []){

        $checklists = Checklists::find($post['checklists_id']);
        $checklists->delete();

        $checklists = Checklists::where('cards_id',$post['cards_id'])->get();
        foreach ($checklists as $value) {
            $value->checklists_value = Checkboxes::all()->where('checklists_id',$value->id);
        }
        return $checklists;
    }

    public function deleteCheckBox($post = []){

        $checkbox = Checkboxes::find($post['checkbox_id']);
        $checkbox->delete();

        $checklists = Checklists::where('cards_id',$post['cards_id'])->get();
        foreach ($checklists as $value) {
            $value->checklists_value = Checkboxes::all()->where('checklists_id',$value->id);
        }
        return $checklists;
    }

    //checklists end
    public function getDeadline($post = []){
        $card = Cards::find($post['cards_id']);

        //message - toomorow deadline
        $reddata = strtotime($card->deadline) - strtotime(date('Y-m-d'));
        $card->reddata =  date('d',$reddata) - 1;

        return $card;
    }

    public function saveDeadline($post = []){

        $cards = Cards::find($post['cards_id']);


        $reddata = strtotime($post['deadline']);
        $cards->deadline =  date('Y-m-d',$reddata + 86400);
        $cards->save();

        $card = Cards::find($post['cards_id']);

        //message - toomorow deadline
        $reddata = strtotime($card->deadline) - strtotime(date('Y-m-d'));
        $card->reddata =  date('d',$reddata) - 1;

        return $card;
    }
}
