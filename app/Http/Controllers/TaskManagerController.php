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
use App\Labels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskManagerController extends Controller
{
    /* DESK ACTIONS */
    public function getDesks()
    {
        $desks = Descs::where('team_id', session('current_team'))->get();
        return $desks;
    }

    public function getDeskLists($post = [])
    {
        $tasks = TasksLists::where('desc_id', $post['desk_id'])->orderBy('position')->get();

        foreach ($tasks as $task){
            $task->cards = $task->cards()->get();
            $cards_preview = array();
            $card_obj = new cards();

            foreach ($task->cards as $card) {
                $card->users;
                $card->card_preview = $card_obj->getCardPreview($card->cards_id);
            }
        }

        return $tasks;
    }

    public function getCardPreview($post = []){
        $card_obj = new cards();
        return $card_obj->getCardPreview($post['cards_id']);
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

    public function deleteDesk($post = [])
    {
        $desks = Descs::find($post['desk_id']);
        $tasklists = $desks->tasks()->get();

        foreach ($tasklists as $tasklist) {
            $cards = $tasklist->cards()->get();

            foreach ($cards as $card) {
                $checklists = $card->checkLists()->get();

                foreach ($checklists as $checklist) {
                    $checkboxes = $checklist->checkBoxes()->get();

                    foreach ($checkboxes as $checkbox) {
                        $checkbox->usersRelation()->delete();
                    }
                    $checklist->checkBoxes()->delete();
                }

                $card->cardComments()->delete();
                $card->checkLists()->delete();
                $card->usersRelation()->delete();
                $card->delete();
            }
        }

        $desks->tasks()->delete();
        $desks->delete();
    }
    /* END DESK ACTIONS */


    /* TASK LIST ACTIONS */
    public function addTaskList($post = [])
    {
        $last_position = TasksLists::where('desc_id', $post['desk_id'])->max('position');
        $list = new TasksLists();
        $list->name = $post['task_name'];
        $list->user_id = Auth::user()->users_id;
        $list->position = '0';
        $list->desc_id = $post['desk_id'];
        $list->teams_id = session('current_team');
        $list->position = $last_position + 1;
        $list->save();
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
        $user_list = ListsUsers::where('lists_id', $post['lists_id'])->where('users_id', $post['users_id'])->delete();
    }

    public function deleteList($post = [])
    {
        $task = TasksLists::find($post['id']);
        $cards = $task->cards()->get();

        foreach ($cards as $card) {
            $checklists = $card->checkLists()->get();

            foreach ($checklists as $checklist) {
                $checkboxes = $checklist->checkBoxes()->get();

                foreach ($checkboxes as $checkbox) {
                    $checkbox->usersRelation()->delete();
                }

                $checklist->checkBoxes()->delete();
            }

            $card->cardComments()->delete();
            $card->checkLists()->delete();
            $card->usersRelation()->delete();
            $card->delete();
        }

        $task->usersRelation()->delete();
        $task->cards()->delete();
        $task->delete();
    }
    /* END TASK LIST ACTIONS */


    /* CARD ACTIONS */
    public function createCard($post = [])
    {
        $card = new Cards();
        $card->name = $post['card_name'];
        $card->user_id = Auth::user()->users_id;
        $card->task_id = $post['task_id'];
        $card->save();

        $task = TasksLists::find($post['task_id']);

        return $task->cards()->get();
    }

    public function deleteCard($post = [])
    {
        $card = Cards::findOrFail($post['cards_id']);
        $checklists = $card->checkLists()->get();

        foreach ($checklists as $checklist) {
            $checkboxes = $checklist->checkBoxes()->get();

            foreach ($checkboxes as $checkbox) {
                $checkbox->usersRelation()->delete();
            }

            $checklist->checkBoxes()->delete();
        }

        $card->cardComments()->delete();
        $card->checkLists()->delete();
        $card->usersRelation()->delete();
        $card->delete();
    }

    public function saveCardDescription($post = []){
        $card = Cards::find($post['cards_id']);
        $card->description = $post['description'];
        $card->save();
    }

    public function addUserToCard($post = [])
    {
        if( ! empty($post['users_id'])){
            $card = Cards::find($post['cards_id']);
            $card->users()->syncWithoutDetaching($post['users_id']);

            return $card->users()->get();
        }
    }

    public function removeUserFromCard($post = [])
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
    /* END CARD ACTIONS */


    /* CHECKLIST ACTIONS */
    public function getChecklists($post = [])
    {
        $card = Cards::find($post['cards_id']);

        return $card->checkLists;
    }

    public function saveChecklist($post = [])
    {
        if( ! empty($post['title'])) {
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

    public function saveChecklistTitle($post = [])
    {
        if( ! empty($post['checklist_title'])) {

            $checklist = Checklists::find($post['checklist_id']);
            $checklist->title = $post['checklist_title'];
            $checklist->save();
        }
    }

    public function deleteChecklist($post = [])
    {
        $checklist = Checklists::findOrFail($post['checklist_id']);
        $checkboxes = $checklist->checkBoxes()->get();

        foreach ($checkboxes as $checkbox) {
            $checkbox->usersRelation()->delete();
        }

        $checklist->checkBoxes()->delete();
        $checklist->delete();

    }
    /* END CHECKLIST ACTIONS */


    /* CHECKBOX ACTIONS */
    public function getCheckboxes($post = [])
    {
        $checklist = Checklists::find($post['checklist_id']);
        $checkboxes = $checklist->checkBoxes;

        foreach ($checkboxes as $checkbox) {
            $checkbox->users;
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
    /* END CHECKBOX ACTIONS */


    /* COMMENTS ACTIONS */
    public function getComments($post = [])
    {
        $card = Cards::find($post['cards_id']);
        $comments = $card->cardComments()->orderBy('created_at', 'desc')->get();

        foreach ($comments as $item) {
            $item->users = Users::find($item['users_id']);
            $item->comment_date = date('Y-d-m H:m', strtotime($item->created_at));
        }

        return $comments;
    }

    public function saveComment($post = [])
    {
        $comments = new CardsComments();
        $comments->cards_id = $post['cards_id'];
        $comments->users_id = Auth::user()->users_id;
        $comments->text = $post['text'];
        $comments->save();

        $card_comments = CardsComments::where('cards_id', $post['cards_id'])->orderBy('created_at', 'desc')->get();

        foreach ($card_comments as $item) {
            $item->users = Users::find($item['users_id']);
            $item->comment_date = date('Y-d-m H:m', strtotime($item->created_at));
        }

        return $card_comments;
    }
    /* END COMMENTS ACTIONS */


    /* LABELS */

    public function getLabels()
    {

    }

    /* END LABELS*/

    public function addCustomerToCard($post = [])
    {
        $card = Cards::find($post['cards_id']);
        $card->customers()->syncWithoutDetaching($post['customer_id']);
    }

    public function getCustomers($post = [])
    {
        $card = Cards::find($post['cards_id']);

        return $card->customers()->get();
    }

    public function deleteCustomerFromCard($post = [])
    {
        $card = Cards::find($post['cards_id']);
        $card->customers()->detach($post['customer_id']);
    }

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
}
