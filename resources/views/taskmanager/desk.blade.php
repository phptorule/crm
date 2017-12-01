<div class="row task_manager_board"  data-ng-controller="Task_managerCtrl" ng-init="initTask()">
    <form class="no-transition" id="task_manager" name="form" method="post" novalidate="novalidate">
        <div class="outer">
            <div class="sortable-outer task_manager_list" ng-repeat="(k,task) in tasks">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="list_title col-sm-10">
                                <h4 ng-click="title[k] = ! title[k]" ng-show="title[k]">@{{tasks[k].name}}</h4>
                                <input type="text" focus-me="! title[k]" class="form-control" ng-show=" ! title[k]" ng-blur="saveTitle(tasks[k].id,tasks[k].name); title[k] = ! title[k]" ng-model="tasks[k].name">
                            </div>
                            <div class="list_settings col-sm-2 pull-right">
                                <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                    <a href="javascript:void(0);" class="btn dropdown-toggle" uib-dropdown-toggle ng-click="getListTeamUsers(tasks[k].id)"><i class="fa fa-cog" aria-hidden="true"></i></a>
                                    <div uib-dropdown-menu class="custom_pop_up">
                                        <div class="text-left">
                                            <button class="btn btn-danger" ng-click="deleteTask(task.id)">Delete list</button>
                                        </div>

                                        <span>Users</span>

                                        <div class="form-group">
                                            <select class="form-control" name="assign_to" ng-model="users_list">
                                                <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                            </select>
                                        </div>

                                        <button type="button" class="btn btn-add" ng-click="saveUserToList(users_list,tasks[k].id);">
                                            Add user
                                        </button>

                                        <span ng-repeat="user in users">
                                            <p class="user_in_list"><span>@{{ user.users_first_name + ' ' + user.users_last_name }}</span><i class="icon_hidden fa fa-trash-o" ng-click="removeUserList(user.users_id,tasks[k].id)"></i></p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner">
                        <div class="panel-body">
                            <div class="sortable-inner task_manager_card" ng-repeat="card in cards[k]" ng-click="selectCard(card.cards_id)" ng-init="initSortable()">
                                <p>@{{card.name}}</p>
                                <div class="preview_card">
                                    <div class="cards_preview_item" ng-If="card_user_me[card.cards_id]" title="You are subscribed to this card">
                                        <i class="fa fa-user"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-If="card_description[card.cards_id]" title="This card has a description">
                                        <i class="fa fa-align-left"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-If="card_comments_count[card.cards_id]" title="Comments">
                                        <i class="fa fa-comment"></i> @{{card_comments_count[card.cards_id]}}
                                    </div>

                                    <div class="cards_preview_item" ng-If="card_deadline[card.cards_id]" title="Deadline">
                                        <i class="fa fa-calendar-check-o"></i> @{{card_deadline[card.cards_id]}}
                                    </div>

                                    <div class="cards_preview_item" ng-If="card_checkbox_all[card.cards_id]" title="Checklist items">
                                        <i class="fa fa-check-square-o"></i> @{{card_cheked_checkbox[card.cards_id]}}/@{{card_checkbox_all[card.cards_id]}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer" ng-click="show_input_card = ! show_input_card" ng-show="show_input_card">
                        <span >Add a card</span>
                    </div>

                    <div class="panel-footer" ng-class="{active: ! show_input_card}" ng-show=" ! show_input_card">
                        <div ng-show=" ! show_input_card">
                            <input type="text" class="form-control" ng-model="card.name_card" name="name_card" />
                            <button class="btn btn-add" ng-click="createCard(tasks[k].id)">Add card</button>
                            <a class="cancel_button" href="javascript:void(0);" ng-click="show_input_card = ! show_input_card"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="task_manager_list add_list">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter list name" ng-model="list.name_task_block" name="name_task_block" required />
                        </div>

                        <button class="btn btn-add" ng-click="addTask()" type="reset">Add list</button>
                        <!--a class="cancel_button" href="javascript:void(0);" ng-click="deleteTask()"><i class="fa fa-times"></i></a-->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script type="text/ng-template" id="SelectCard.html">
    <div class="modal-header modal-header-add" ng-init="initCard()">
        <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>

        <h4 ng-show="card_title" ng-click="card_title = ! card_title"><b>@{{card.name}}</b></h4>
        <input type="text" focus-me="! card_title" ng-show="! card_title" ng-blur="saveCardTitle(card.cards_id,card.name); card_title = ! card_title" ng-model="card.name">
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form class="no-transition card_info">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="card_info_header">
                                    <div class="row">
                                        <div class="col-sm-5 users_block" ng-show="users != ''">
                                            <ul>
                                                <h4>Users:</h4>
                                                <li ng-repeat="user in users">
                                                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                                        <a href="javascript:void(0);" class="card_user dropdown-toggle" uib-dropdown-toggle>@{{ user.users_first_name + ' ' + user.users_last_name }} <i class="fa fa-pencil"></i></a>
                                                        <div uib-dropdown-menu class="custom_pop_up">

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-danger" ng-click="removeUser(user.users_id); editCardUser = ! editCardUser">
                                                                    Delete from card
                                                                </button>
                                                            </div>

                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-add">
                                                                    View profile
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-sm-5 deadline_block" ng-show="card.deadline">
                                            <h4>Deadline to:</h4>

                                            <span ng-If="card.reddata == 1 || card.reddata == 0" class="reddata">@{{card.deadline}}</span>
                                            <span ng-If="card.reddata > 1">@{{card.deadline}}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr ng-show="users != ''">

                                <div class="card_block description">
                                    <h4>Description:</h4>
                                    <div class="card_description">
                                        <div class="form-group">
                                            <p ng-show="show_description" ng-click="makeDescriptionCopy(); show_description = ! show_description">@{{card.description}}</p>
                                            <textarea class="form-control resize" ng-show="! show_description || ! card.description" ng-model="temp_description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-add" ng-show="! show_description || ! card.description" ng-click="saveCardDescription(); show_description = ! show_description">Save</button>
                                            <button class="btn btn-danger" ng-show="! show_description && card.description" ng-click="resetCardDescription()">Cancel</button>
                                            <button class="btn btn-add" ng-show="show_description && card.description" ng-click="makeDescriptionCopy(); show_description = ! show_description">Edit</button>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="card_block checklists" ng-repeat="(l, checklist) in checklists">
                                    <div class="checklist_header">
                                        <h4><i class="fa fa-check-square-o"></i> @{{checklist.title}}</h4>
                                        <!--a href="javascript:void(0);" ng-click="deleteCheckList(checklist.id)">Delete checklist</a-->
                                    </div>

                                    <div class="checkbox_item" ng-repeat="(k, checkbox) in checklists[l].checkboxes">
                                        <div ng-show="checkbox.status == 0">
                                            <div class="card_checkbox" ng-click="changeCheckboxStatus(checklists[l].checkboxes[k].id)">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div class="card_checkbox_description" ng-click="makeCheckboxDescriptionCopy(k, l); editChecklistItem[k] = ! editChecklistItem[k]">
                                                <span ng-show="editChecklistItem[k]" ng-model="checklists[l].checkboxes[k].title">@{{checklists[l].checkboxes[k].title}}</span>
                                                <textarea ng-show=" ! editChecklistItem[k]" class="form-control" ng-click="editChecklistItem[k] = ! editChecklistItem[k]" ng-model="checklists[l].checkboxes[k].title"></textarea>
                                            </div>

                                            <div class="checkbox_description_buttons">
                                                <button class="btn btn-add" ng-show="! editChecklistItem[k]" ng-click="saveCheckboxec(checklists[l].checkboxes[k]); editChecklistItem[k] = ! editChecklistItem[k]">Save</button>
                                                <button class="btn btn-danger" ng-show="! editChecklistItem[k]" ng-click="resetCheckboxDescription(k, l); editChecklistItem[k] = ! editChecklistItem[k]">Cancel</button>
                                            </div>
                                        </div>

                                        <div ng-show="checkbox.status == 1">
                                            <div class="card_checkbox active" ng-click="changeCheckboxStatus(checklists[l].checkboxes[k].id)">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div class="card_checkbox_description" ng-click="makeCheckboxDescriptionCopy(k, l); editChecklistItem[k] = ! editChecklistItem[k]">
                                                <span class="active_span" ng-show="editChecklistItem[k]" ng-model="checklists[l].checkboxes[k].title">@{{checklists[l].checkboxes[k].title}}</span>
                                                <textarea ng-show=" ! editChecklistItem[k]" class="form-control" ng-click="editChecklistItem[k] = ! editChecklistItem[k]" ng-model="old_checkbox_description">@{{old_checkbox_description}}</textarea>
                                            </div>

                                            <div class="checkbox_description_buttons">
                                                <button class="btn btn-add" ng-show="! editChecklistItem[k]" ng-click="saveCheckboxec(checklist.id, checklists[l].checkboxes[k].title); editChecklistItem[k] = ! editChecklistItem[k]">Save</button>
                                                <button class="btn btn-danger" ng-show="! editChecklistItem[k]" ng-click="resetCheckboxDescription(k, l); editChecklistItem[k] = ! editChecklistItem[k]">Cancel</button>
                                            </div>
                                        </div>

                                        <div class="delete_chceckbox" ng-click="deleteCheckBox(checkbox.id)">
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    </div>


                                    <div ng-show=" ! showCheckBox">
                                        <div class="form-group">
                                            <input class="form-control" type="text" ng-model="checklists[l].checkbox_title">
                                        </div>
                                        <button class="btn btn-add" ng-click="addCheckbox(checklists[l])">Add</button>
                                        <button class="btn btn-danger" ng-click="showCheckBox = ! showCheckBox" type="reset">Cancel</button>
                                    </div>

                                    <a href="javascript:void(0);" ng-show="showCheckBox" ng-click="showCheckBox = ! showCheckBox">Add new item</a>
                                </div>

                                <hr ng-show="checklists != ''">

                                <div class="card_comments">
                                    <div class="form-group">
                                        <h4><i class="fa fa-comments-o"></i> Add comment</h4>
                                        <textarea class="form-control resize" ng-model="comment_text"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-add" ng-click="saveComment()" type="reset">Save</button>
                                    </div>

                                    <p ng-show="comments">Comments: </p>
                                    <div ng-repeat="comment in comments">
                                        <div class="card_comment_block">
                                            <div class="comment_author">
                                                @{{comment.users.users_first_name + ' ' + comment.users.users_last_name + ' (' + comment.created_at + ')'}}
                                            </div>

                                            <div class="comment_text">
                                                @{{comment.text}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-4 card_settings_block">
                                <h4>Add</h4>

                                <div class="form-group">
                                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                        <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-user"></i> Users</a>

                                       <div uib-dropdown-menu class="custom_pop_up">
                                            <div class="custom_pop_up_header text-center">
                                                <span>Users</span>
                                            </div>

                                           <div class="form-group">
                                                <select class="form-control" name="assign_to" ng-model="users_list">
                                                    <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                </select>
                                            </div>

                                           <button type="button" class="btn btn-add" ng-click="saveUserToCard(users_list);">
                                               Add user
                                            </button>
                                        </div>
                                    </div>

                                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                        <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-check-square-o"></i> Checklist</a>

                                       <div uib-dropdown-menu class="custom_pop_up">
                                            <div class="custom_pop_up_header text-center">
                                                <span>Add checklist</span>
                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control" ng-model="checklists.title">
                                            </div>

                                            <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveChecklist()">
                                                Save
                                            </button>
                                        </div>
                                    </div>

                                    <a class="btn card_nav" ng-click="calendarOpen(0);"><i class="glyphicon glyphicon-calendar"></i> Timing</a>
                                    <input type="hidden" ng-change="saveDeadline(card.checklist.deadline);" class="form-control" uib-datepicker-popup="dd/MM/yyyy" ng-model="card.checklist.deadline" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">

                </div>
            </div>
        </div>
   </div>

   <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Close</button>
   </div>

</script>