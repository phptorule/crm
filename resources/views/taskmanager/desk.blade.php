<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()" class="ng-cloak">
   
    <form class="no-transition" name="form" method="post" novalidate="novalidate">

        
        <div class="col-sm-4" ng-repeat="(k,task) in tasks">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <div class="form-group">
                        <p>
                            <a ng-show="title" ng-click="task_title_edit()">@{{tasks[k].name}}</a>
                            <input type="text" ng-show="title_edit" ng-blur="saveTitle(tasks[k].id,tasks[k].name);task_title_edit()" ng-model="tasks[k].name">
                            <button class="btn btn-danger pull-right" ng-click="deleteTask(task.id)">X</button>
                        </p>
                    </div>
                    <hr>
                    <p ng-repeat="card in cards[k]" class="card_title"><a href="" ng-click="selectCard(card.id)">@{{card.name}}</a><i class="pull-right fa fa-pencil m-r-5"></i></p>  
                </div>


                <div class="panel panel-bd lobidrag_task_manager">
                    <div class="panel-heading">
                        
                        <p><a class="btn btn-primary" href='' ng-show="button_add_card" ng-click="show_input_card()" id="link_add">add a card</a></p>
                        <div class="form-group">
                            <input type="text" class="form-control" ng-model="card.name_card" ng-show="button_input_card" name="name_card" placeholder="Введить назву" required />
                        </div>
                        <button class="btn btn-primary" ng-show="button_input_card" ng-click="createCard(tasks[k].id)" type="reset">add</button>
                        <button class="btn btn-danger"  ng-show="button_input_card" ng-click="show_input_card()">X</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Введить назву" ng-model="list.name_task_block" name="name_task_block" required />
                    </div>
                        <button class="btn btn-primary" ng-click="initTask()" type="reset">add</button>
                        <button class="btn btn-danger" ng-click="deleteTask()">X</button>
                </div>
            </div>
        </div>

    </form>
</div>


<script type="text/ng-template" id="SelectCard.html">
    <div class="modal-header modal-header-primary" ng-init="getCard();getTeamUsers(); initComments(); initChecklist();">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <p ng-show="card_title" ng-click="status_card_title_edit()">@{{card.name}}</p>
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
                    <form class="no-transition">
                        <div class="row">

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <p>Users:</p> 
                                    <li ng-repeat="user_work in card.users_work_in_card">
                                        @{{user_work.users_first_name}}
                                    </li>   
                                </div>

                                <div class="form-group">
                                    <p ng-show="status_description" ng-click="show_description()">@{{card.description}}</p>
                                    <textarea class="form-control resize" ng-show="status_description_textarea" ng-model="card.description"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" ng-click="saveCard(); show_description();">Save</button>
                                    <button class="btn btn-danger" ng-If="card.description.length > 1" ng-click="reset(card.id)">Cancel</button>
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

                            <div class="col-sm-4">
                                <p class="text-center">Add</p>

                                <div class="form-group">

                                    <p class="card_nav" ng-click="openDiscount(k)"><i class="fa fa-user m-r-5"></i>Users</p>
                                    <p class="card_nav" ng-click="openCheklistForm(k)">Checklist</p>
                                    <p class="card_nav" ng-click="calendarOpen(0);"><i class="glyphicon glyphicon-calendar"></i> Timing</p>
                                    <input type="hidden" ng-change="saveDeadline(card.checklist.deadline);" class="form-control" uib-datepicker-popup="dd/MM/yyyy" ng-model="card.checklist.deadline" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                    
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