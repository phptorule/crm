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
use App\ListsUsers;
use App\Descs;
use App\CheckboxesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskManagerController extends Controller
{
    public function getTeamUsers($post = [])
    {

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
        $result = array_values($result);
        if(count($result)>=1){
            for ($i=0; $i < count($result); $i++) {
                if(isset($result[$i])){
                    $users_not_checked[] = Users::find($result[$i]);
                }
            }
        }

        if(!empty($users_not_checked)){
            return $team->users_not_checked = $users_not_checked;
        }
    }

    public function getDesks()
    {
        $desks = Descs::where('team_id', session('current_team'))->get();

        return $desks;
    }

    public function getTasks($post = [])
    {
        $tasks = TasksLists::where('desc_id', $post['desk_id'])->get();

        foreach ($tasks as $task)
        {
            $task->cards = $task->cards()->get();

            foreach ($task->cards as $card) {
                $card_users = $card->users;
                $card_user_me = $card->users->contains('users_id', Auth::user()->users_id);

                foreach ($card->checkLists as $value) {
                    $all_count_checkboxes[$card->cards_id][] = $value->checkBoxes->count();
                    $all_conut_checked_checkboxes[$card->cards_id][] =  $value->checkBoxes->where('status', 1)->count();
                }

                if( ! empty($all_count_checkboxes[$card->cards_id])) {
                    $card_checkbox_all = array_sum($all_count_checkboxes[$card->cards_id]);
                }else {
                    $card_checkbox_all = NULL;
                }

                if(!empty($all_conut_checked_checkboxes[$card->cards_id])) {
                    $card_cheked_checkbox = array_sum($all_conut_checked_checkboxes[$card->cards_id]);
                }else {
                    $card_cheked_checkbox = NULL;
                }

                $card_description = $card->description;

                if( ! empty($card->deadline)) {
                    $card_deadline = date("M d", strtotime($card->deadline));
                }else {
                    $card_deadline = NULL;
                }

                //return comment
                $comments = CardsComments::where('cards_id', $card->cards_id)->orderBy('created_at', 'desc')->get();
                foreach ($comments as $value) {
                    $value->users = Users::find($value->users_id)->first();
                }

                //return checklists
                $checklists = Checklists::where('cards_id', $card->cards_id)->get();
                foreach ($checklists as $checklist) {
                    $checklist->checkboxes = Checkboxes::where('checklist_id', $checklist->id)->get();

                    foreach ($checklist->checkboxes as $checkbox) {
                        $checkbox->users;
                    }
                }

                $card_comments_count = $card->cardComments()->get()->count();

                $card->comments = $comments;
                $card->checklists = $checklists;
                $card->card_user_me = $card_user_me;
                $card->card_checkbox_all = $card_checkbox_all;
                $card->card_cheked_checkbox = $card_cheked_checkbox;
                $card->card_description = $card_description;
                $card->card_deadline = $card_deadline;
                $card->card_comments_count = $card_comments_count;
            }
        }

        return $tasks;
    }

    public function saveDesk($post = [])
    {
        $desks = new Descs();
        $desks->name = $post['desc_name'];
        $desks->team_id = session('current_team');
        $desks->user_id = Auth::user()->users_id;
        $desks->save();
    }

    public function saveDeskTitle($post = [])
    {
        $desks = Descs::find($post['id']);
        $desks->name = $post['name'];
        $desks->save();
    }

    public function getListTeamUsers($post = [])
    {
        //користувачі в команді
        $team = Teams::find(session('current_team'));
        $team->users_team  = $team->users()->get();
        foreach ($team->users_team as $teams) {
            $a[] = $teams->users_id;
        }

        //користувачі в картці
        $users_in_list = TasksLists::find($post['list_id']);
        $team->users = $users_in_list->users()->get();
        $b = [];
        foreach ($team->users as $list_users) {
            if(!empty($list_users->users_id)){
                $b[] = $list_users->users_id;
            }
        }

        //користувачі вкоманді, які не вибрані
        $result = array_diff($a,$b);
        $result = array_values($result);
        if(count($result)>=1){
            for ($i=0; $i < count($result); $i++) {
                if(isset($result[$i])){
                    $users_not_checked[] = Users::find($result[$i]);
                }
            }
        }

        if(!empty($users_not_checked)){
            $team->users_not_checked = $users_not_checked;
        }
        return $team;

    }

    public function saveUserToList($post = [])
    {
        if( ! empty($post['users_id'])) {
            $user_list = new ListsUsers();
            $user_list->lists_id = $post['lists_id'];
            $user_list->users_id = $post['users_id'];
            $user_list->save();
        }
    }

    public function removeUserList($post = [])
    {
        $user_list = ListsUsers::where('lists_id',$post['lists_id'])->where('users_id',$post['users_id'])->delete();
    }

    public function deleteTask($post = [])
    {

        $delete_task = TasksLists::find($post['id']);
        $delete_task->delete();
    }

    public function addTask($post = [])
    {
        $task = new TasksLists();
        $task->name = $post['task_name'];
        $task->user_id = Auth::user()->users_id;
        $task->position = '0';
        $task->desc_id = $post['desk_id'];
        $task->teams_id = session('current_team');
        $task->save();
    }

    public function createCard($post = [])
    {
        $card = new Cards();
        $card->name = $post['name_card'];
        $card->user_id = Auth::user()->users_id;
        $card->task_id = $post['task_id'];
        $card->save();
    }

    public function savePosition($post = [])
    {
        $mass = explode(" ", $post['id']);

        foreach ($mass as $value) {
           $new_value = explode("=", $value);
           $list_value[] = $new_value[1];
        }

        for ($i=0; $i < count($list_value); $i++) {
            $taskslists = TasksLists::find($list_value[$i]);
            $taskslists->position = $i;
            $taskslists->save();
        }
    }

    public function saveTaskTitle($post = [])
    {
        $task = TasksLists::find($post['task_id']);
        $task->name = $post['task_name'];
        $task->save();
    }

    public function saveCardDescription($post = []){
        $card = Cards::find($post['cards_id']);
        $card->description = $post['description'];
        $card->save();
    }

    public function reset($post = [])
    {

        $card = Cards::find($post['cards_id']);
        $teams_users = UsersTeams::all()->where('teams_id',session('current_team'));

        foreach ($teams_users as $user) {
            $users[] = Users::find($user->users_id);
        }

        $card->users = $users;

        return $card;
    }

    public function addUserToCard($post = [])
    {
        if(!empty($post['users_id'])){
            $card = Cards::find($post['cards_id']);
            $card->users()->syncWithoutDetaching($post['users_id']);

            return $card->users()->get();
        }
    }

    public function removeUser($post = [])
    {
        $card = Cards::find($post['cards_id']);
        $card->users()->detach($post['users_id']);

        return $card->users()->get();
    }

    public function saveCardTitle($post = [])
    {
        $card_change = Cards::find($post['card_id']);
        $card_change->name = $post['card_name'];
        $card_change->save();
    }

    public function saveComment($post = [])
    {
        $comments = new CardsComments();
        $comments->cards_id = $post['cards_id'];
        $comments->users_id = Auth::user()->users_id;
        $comments->text = $post['text'];
        $comments->save();

        $card_commnets = CardsComments::where('cards_id', $post['cards_id'])->orderBy('created_at', 'desc')->get();

        return $card_commnets;
    }

    public function saveChecklist($post = [])
    {
        if(!empty($post['title'])) {
            $checklists = new Checklists();
            $checklists->title = $post['title'];
            $checklists->users_id = Auth::user()->users_id;
            $checklists->cards_id= $post['cards_id'];
            $checklists->save();

            $card_checklists = Checklists::where('cards_id', $post['cards_id'])->get();

            foreach ($card_checklists as $checklist) {
                $checklist->checkboxes = $checklist->checkBoxes()->get();

                foreach ($checklist->checkboxes as $value) {
                    $value->users;
                }
            }

            return $card_checklists;
        }
    }

    public function getCheckboxes($post = [])
    {
        $checklist = Checklists::find($post['checklist_id']);
        $checkboxes = $checklist->checkBoxes()->get();

        foreach ($checkboxes as $value) {
            $value->users;
        }

        return $checkboxes;
    }

    public function addCheckbox($post = [])
    {
        if( ! empty($post['checkbox_title'])) {
            $checkbox = new Checkboxes();
            $checkbox->checklist_id = $post['checklist_id'];
            $checkbox->title = $post['checkbox_title'];
            $checkbox->deadline = ! empty($post['deadline']) ? $post['deadline'] : '';

            $checkbox->save();
            $checkbox->users()->sync($post['users']);
        }
    }

    public function deleteCheckbox($post = [])
    {
        $checkbox = Checkboxes::find($post['id']);
        $checkbox->users()->detach($post['users']);
        $checkbox->delete();
    }

    public function saveCheckboxDescription($post = [])
    {
        $checkbox = Checkboxes::find($post['id']);
        $checkbox->title = $post['title'];
        $checkbox->deadline = ! empty($post['deadline']) ? $post['deadline'] : '';
        $checkbox->save();
        $checkbox->users()->sync($post['users']);

        return $checkbox->deadline;
    }

    public function changeCheckboxStatus($post = [])
    {
        $checkbox = Checkboxes::find($post['checkbox_id']);

        if($checkbox->status == 0){
            $checkbox->status = 1;
        }else{
            $checkbox->status = 0;
        }

        $checkbox->save();

        return $checkbox->status;
    }

    public function deleteChecklists($post = [])
    {
        $checklists = Checklists::find($post['checklists_id']);
        $checklists->delete();

        $checklists = Checklists::where('cards_id',$post['cards_id'])->get();
        foreach ($checklists as $value) {
            $value->checklists_value = Checkboxes::all()->where('checklists_id',$value->id);
        }
        return $checklists;
    }

    public function saveCardDeadline($post = []){
        $deadline_date = date('Y/m/d', strtotime($post['deadline']['date']));
        $card_deadline = $deadline_date.' '.$post['deadline']['hour'].':'.$post['deadline']['minute'];

        //die(var_dump($card_deadline));

        $card = Cards::find($post['cards_id']);

        $card->deadline = $card_deadline;
        $card->save();

        return $card->deadline;
    }

    public function removeCardDeadline($post = []){
        $card = Cards::find($post['cards_id']);
        $card->deadline = '';
        $card->save();

        return $card->deadline;
    }

    public function changeDone($post = [])
    {
        $cards = Cards::find($post['cards_id']);

        if($cards->done == '0') {
            $cards->done = '1';
        }else {
            $cards->done = '0';
        }

        $cards->save();

        return $cards->done;
    }

    public function saveChecklistTitle($post = [])
    {
        if( ! empty($post['checklist_title'])) {

            $checklist = Checklists::find($post['checklist_id']);
            $checklist->title = $post['checklist_title'];
            $checklist->save();
        }
    }
}
