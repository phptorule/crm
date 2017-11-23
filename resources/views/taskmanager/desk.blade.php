<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">
    <form class="no-transition" id="task_manager" name="form" method="post" novalidate="novalidate">
        <div class="outer">
            <div class="sortable-outer col-sm-3" ng-repeat="(k,task) in tasks">
                <div class="panel panel-bd">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="list_title col-sm-10">
                                <h4 ng-click="title = ! title" ng-show="title">@{{tasks[k].name}}</h4>
                                <input type="text" class="form-control" ng-show=" ! title" ng-blur="saveTitle(tasks[k].id,tasks[k].name); title = ! title" ng-model="tasks[k].name">
                            </div>

                            <div class="list_settings col-sm-2 text-right">
                                <a href="javascript:void(0);" ng-click="show_settings = ! show_settings"><i class="fa fa-cog" aria-hidden="true"></i></a>

                                <div class="settings_box text-left" ng-show="show_settings">
                                    <button class="btn btn-danger" ng-click="deleteTask(task.id)">Delete list</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner">
                        <div class="panel-body">
                            <div class="sortable-inner task_manager_card" ng-repeat="card in cards[k]" ng-click="selectCard(card.id)" ng-init="initSortable()">
                                <span>@{{card.name}}</span>
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
        </div>

        <div class="col-sm-2">
            <div class="panel panel-bd">
                <div class="panel-heading">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter list name" ng-model="list.name_task_block" name="name_task_block" required />
                    </div>

                    <button class="btn btn-add" ng-click="initTask()" type="reset">Add list</button>
                    <a class="cancel_button" href="javascript:void(0);" ng-click="deleteTask()"><i class="fa fa-times"></i></a>
                </div>
            </div>
        </div>
    </form>
</div>


<script type="text/ng-template" id="SelectCard.html">
    <div class="modal-header modal-header-add" ng-init="getCard();getTeamUsers(); initComments(); initChecklist();">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <h4 ng-show="card_title" ng-click="status_card_title_edit()"><b>@{{card.name}}</b></h4>
       <input type="text" ng-show="card_title_edit" ng-blur="status_card_title_edit();saveCardTitle(card.id,card.name)" ng-model="card.name">
       <p>
           <span ng-If="card.reddata == 1 || card.reddata == 0" class="reddata">@{{card.deadline}}</span>
           <span ng-If="card.reddata > 1">@{{card.deadline}}</span>
       </p>
    </div>

   <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form class="no-transition card_info">
                        <div class="row">

                            <div class="col-sm-8">
                                <div class="card_info_header">
                                    <div class="users_block" ng-show="checked_users != 0">
                                        <ul class="assign-list">
                                            <li class="form-span" ng-repeat="user in users">@{{ user.users_first_name}}</li>
                                        </ul>

                                        <ul>
                                            Users:
                                            <li ng-repeat="user in checked_users">
                                                <a href="javascript:void(0);" class="card_user" ng-click="editCardUser = ! editCardUser">@{{ user.users_first_name + ' ' + user.users_last_name }} <i class="fa fa-pencil"></i></a>

                                                <div class="custom_pop_up edit_card_user" ng-show="editCardUser">
                                                    <div class="custom_pop_up_header text-center">
                                                        <span>@{{ user.users_first_name + ' ' + user.users_last_name }}</span>
                                                        <button type="button" class="close" ng-click="editCardUser = ! editCardUser">×</button>
                                                    </div>

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
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card_description_block">
                                    <h4>Description:</h4>
                                    <div class="card_description">
                                        <div class="form-group">
                                            <p ng-show="show_description" ng-click="makeDescriptionCopy(); show_description = ! show_description">@{{card.description}}</p>
                                            <textarea class="form-control resize" ng-show="! show_description || ! card.description" ng-model="temp_description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-add"  ng-show="! show_description || ! card.description" ng-click="saveCard(); show_description = ! show_description">Save</button>
                                            <button class="btn btn-danger" ng-show="! show_description && card.description" ng-click="reset()">Cancel</button>
                                            <button class="btn btn-add" ng-show="show_description && card.description" ng-click="makeDescriptionCopy(); show_description = ! show_description">Edit</button>
                                        </div>
                                    </div>
                                </div>


                                <p>Checklist:</p>    
                                <div class="form-group" ng-repeat="checklist in card.checklist">
                                    <p>
                                        <span>@{{checklist.title}}</span>
                                        <i class="fa fa-minus pointer" ng-click="deleteCheckList(checklist.id)"></i>
                                    </p>

                                    <div ng-repeat="checkbox in checklist.checklist_value">
                                        <div ng-If="checkbox.status == 0">
                                            <input type="checkbox" id="checkbox" ng-click="saveChangeChecklistStatus(checkbox.id)">
                                            <label for="checkbox" >@{{checkbox.title}}</label>
                                            <i class="fa fa-minus pointer" ng-click="deleteCheckBox(checkbox.id)"></i>
                                        </div>
                                        <div ng-If="checkbox.status == 1">
                                            <input type="checkbox" checked id="checkbox" ng-click="saveChangeChecklistStatus(checkbox.id)">
                                            <label for="checkbox" ><s>@{{checkbox.title}}</s></label>
                                            <i class="fa fa-minus pointer" ng-click="deleteCheckBox(checkbox.id)"></i>
                                        </div>
                                    </div>

                                    <div ng-If="show_checkbox_input == checklist.id">
                                        <div ng-show="showChackBox">
                                            <input class="form-control" type="text" ng-model="card.checklist.checkbox.title">
                                            <button class="btn btn-success" ng-click="saveChecklistValue(checklist.id, card.checklist.checkbox.title)" type="reset">Add</button>
                                            <button class="btn btn-danger" ng-click="showChackBoxInput()" type="reset">Cancel</button>
                                        </div>
                                    </div>

                                    <a class="btn" ng-click="showChackBoxInput(checklist.id)">Add check</a>
                                </div>


                                <div class="form-group">
                                    <p>Добавление кометаря</p>
                                    <textarea class="form-control resize" ng-model="card.comment"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success" ng-click="saveComment(card.comment)" type="reset">Save</button>
                                </div>

                                <p>Comments: </p>
                                <p ng-repeat="comments in card.comments">@{{comments.users.users_first_name}}: @{{comments.text}}</p>

                            </div>


                            <div class="col-sm-4 card_settings_block">
                                <h4>Add</h4>

                                <div class="form-group">
                                    
                                    <a href="javascript:void(0);" class="btn card_nav" ng-click="showAddUsers = ! showAddUsers"><i class="fa fa-user m-r-5"></i>Users</a>
                                    <a class="btn card_nav" ng-click="openCheklistForm(k)">Checklist</a>
                                    <a class="btn card_nav" ng-click="calendarOpen(0);"><i class="glyphicon glyphicon-calendar"></i> Timing</a>
                                    <input type="hidden" ng-change="saveDeadline(card.checklist.deadline);" class="form-control" uib-datepicker-popup="dd/MM/yyyy" ng-model="card.checklist.deadline" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />

                                    <div class="custom_pop_up add_users" ng-show="showAddUsers">
                                        <div class="custom_pop_up_header text-center">
                                            <span>Users</span>
                                            <button type="button" class="close" ng-click="showAddUsers = ! showAddUsers">×</button>
                                        </div>

                                        <div class="form-group">
                                            <select class="form-control" name="assign_to" ng-model="users_list">
                                                <option ng-repeat="user in not_checked_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                            </select>
                                        </div>

                                        <button type="button" class="btn btn-add" ng-click="addUser(users_list)">
                                           Add user
                                        </button>
                                    </div>

                                    <div class="discount_window_card" ng-show="discount_window[k]">
                                        <div class="discount_header">
                                            <button type="button" class="close" ng-click="discount_window[k] = ! discount_window[k]" aria-hidden="true">×</button>
                                        </div>
                                        <br>

                                        <div>
                                            <select name="assign_to" ng-model="users_list">
                                                <span ng-repeat="user_work in users_work_in_card">
                                                    <option ng-repeat="user in not_checked_users" ng-If="user_work.users_id != user.users_id" value="@{{ user.users_id }}">@{{user.users_first_name}}</option>
                                                </span>
                                            </select>
                                        
                                            <button type="button" class="btn" ng-click="addUser(users_list)">
                                               <i class="fa fa-plus"></i>
                                            </button>
                                        </div>

                                        <ul class="assign-list">
                                            <li class="form-span" ng-repeat="user in users">@{{ user.users_first_name}}</li>
                                        </ul>

                                        <ul class="assign-list" ng-model="customers.assign_to">
                                            <li ng-repeat="user in checked_users" class="margin_li">
                                                @{{ user.users_first_name}}

                                                <button type="button" class="btn btn-danger" ng-click="removeUser(user.users_id)">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </li>

                                            <button type="button" class="btn btn-primary m-b-5" ng-click="SaveUserToCard(card.id)">
                                                Save
                                            </button>
                                        </ul>
                                    </div>

                                    <div class="discount_window_card" ng-show="openCheklistForm[k]">
                                        <div class="discount_header">
                                            <button type="button" class="close" ng-click="openCheklistForm[k] = ! openCheklistForm[k]" aria-hidden="true">×</button>
                                        </div>
                                        <br>
                                         
                                        <input type="text" ng-model="card.checklist.title">
                                        <button type="button" aria-hidden="true" class="btn btn-primary m-b-5" ng-click="saveChecklistTitle(card.checklist.title);">
                                            Save
                                        </button>
                                    </div>
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