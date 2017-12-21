<div data-ng-controller="TaskManagerCtrl" ng-init="getDesks()">
    <section class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-icon">
                    <i class="@{{ Page.icon() }}"></i>
                </div>

                <div class="header-title">
                    <h1 ng-click="desk_title = ! desk_title" class="pointer" ng-show="desk_title">@{{desk.name}}</h1>

                    <div class="input-group input-group-unstyled" ng-show=" ! desk_title">
                        <input type="text" focus-me="! desk_title" class="form-control" ng-enter="saveDeskTitle()" ng-model="desk.name">
                        <div class="btn btn-add save_title" ng-click="saveDeskTitle()">
                            Save
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="desk_switcher pull-right">
                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                        <button class="btn btn-add" uib-dropdown-toggle>
                            Choose your desk
                        </button>

                        <div uib-dropdown-menu class="custom_pop_up">
                            <ul>
                                <li ng-repeat="desk in desks"><a href="#" ng-click="getDeskLists(desk)"><i class="fa fa-trello"></i> @{{desk.name}}</a></li>
                            </ul>

                            <div class="create_desk text-center">
                                <span>Create new desk</span>
                                <div class="input-group input-group-unstyled">
                                    <a href=""><input type="text" class="form-control" ng-model="create_desk_name" ng-enter="saveDesk(create_desk_name)"></a>
                                    <div class="btn btn-add save_title" ng-click="saveDesk(create_desk_name)">
                                        Save
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-danger" ng-click="deleteDesk()">Delete desk</button>
                </div>
            </div>
        </div>
    </section>

    <div class="task_manager_board">
        <form class="no-transition" id="task_manager" name="form" method="post" novalidate="novalidate">
            <div class="outer">
                <div class="sortable-outer task_manager_list" id="item-@{{task.id}} " ng-repeat="task in tasks">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="list_title col-sm-10">
                                    <h4 ng-click="title[task.id] = ! title[task.id]" ng-show=" ! title[task.id]">@{{task.name}}</h4>
                                    <div class="input-group input-group-unstyled" ng-show="title[task.id]">
                                        <input type="text" focus-me="! title[task.id]" class="form-control" ng-enter="saveTaskTitle(task)" ng-model="task.name">
                                        <div class="btn btn-add save_title" ng-click="saveTaskTitle(task)">
                                            Save
                                        </div>
                                    </div>
                                </div>

                                <div class="list_settings col-sm-2 pull-right">
                                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                        <a href="javascript:void(0);" class="dropdown-toggle" uib-dropdown-toggle ng-click="getListTeamUsers(task.id)"><i class="fa fa-cog" aria-hidden="true"></i></a>
                                        <div uib-dropdown-menu class="custom_pop_up">
                                            <button type="button" value="Delete list" class="btn btn-danger" ng-click="deleteList(task)">
                                                Delete list
                                            </button>

                                            <div class="form-group">
                                                <span>Users</span>

                                                <select class="form-control" name="assign_to" ng-model="users_list">
                                                    <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                </select>
                                            </div>

                                            <button type="button" class="btn btn-add" ng-click="saveUserToList(users_list,task.id);">
                                                Add user
                                            </button>

                                            <div ng-repeat="user in users">
                                                <span>@{{ user.users_first_name + ' ' + user.users_last_name }}</span>
                                                <div class="delete_card_item">
                                                    <i class="fa fa-trash-o" ng-click="removeUserList(user.users_id,task.id)"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body inner">
                            <div class="sortable-inner task_manager_card" ng-repeat="card in task.cards" ng-class="{card_done: card.done == 1}" ng-click="selectCard(card)" ng-init="initSortable()">
                                <p>
                                    @{{ card.name }} <i class="fa fa-check" ng-If="card.done == 1"></i>
                                </p>

                                <div class="preview_card">
                                    <div class="cards_preview_item" ng-show="card.assign_to_card" title="You are subscribed to this card">
                                        <i class="fa fa-user"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.description" title="This card has a description">
                                        <i class="fa fa-align-left"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.comments_amount" title="Comments">
                                        <i class="fa fa-comment"></i> @{{ card.comments_amount }}
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.deadline" title="Deadline">
                                        <i class="fa fa-calendar-check-o"></i> @{{ card.deadline_preview }}
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.all_checkboxes" title="Checklist items">
                                        <i class="fa fa-check-square-o"></i> @{{ card.checked_checkboxes}}/@{{card.all_checkboxes }}
                                    </div>
                                </div>

                                <div class="preview_users text-right">
                                    <div ng-repeat="user in card.users" class="user_avatar preview" style="background-color: rgb(@{{ user.icon_color}})" title="@{{user.users_first_name + ' ' + user.users_last_name}}">
                                        <span class="icon_name">@{{ user.users_first_name.slice(0,1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer" ng-click="addNewCard(task)" ng-show=" ! showCreateNewCard[task.id]">
                            <span >Add a card</span>
                        </div>

                        <div class="panel-footer" ng-class="{active: showCreateNewCard[task.id]}" ng-show="showCreateNewCard[task.id]">
                            <input type="text" class="form-control" ng-enter="createCard(task)" ng-model="card_name[task.id]" />
                            <button class="btn btn-add" ng-click="createCard(task)">Add card</button>
                            <a class="cancel_button" href="javascript:void(0);" ng-click="showCreateNewCard[task.id] = ! showCreateNewCard[task.id]"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>

                <div class="task_manager_list add_list">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="form-group">
                                <input type="text" class="form-control" ng-enter="addTaskList()" placeholder="Enter list name" ng-model="task_name" />
                            </div>

                            <button class="btn btn-add" ng-click="addTaskList()">Add list</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script type="text/ng-template" id="SelectCard.html">
        <div class="modal-header modal-header-add no-transition" ng-init="initCard()">
            <button type="button" class="close" ng-click="cancel()">×</button>
            <h4>
                <b class="title_pointer" ng-show="card_title" ng-click="card_title = ! card_title">@{{card.name}}</b> <i class="fa fa-check" ng-If="card.done == 1"></i>
            </h4>

            <div class="input-group input-group-unstyled">
                <input type="text" focus-me="! card_title" ng-show="! card_title" ng-enter="saveCardTitle()" class="form-control" ng-model="card.name">
                <div class="btn btn-add save_title" ng-show=" ! card_title" ng-click="saveCardTitle()">
                    Save
                </div>
            </div>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal_content_header">
                        <form class="card_info no-transition">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="card_info_header">
                                        <div class="row">
                                            <div class="col-sm-5 users_block" ng-show="card.users != '' && card.users">
                                                <ul>
                                                    <h4>Users:</h4>
                                                    <li ng-repeat="user in card.users">
                                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                                            <a href="javascript:void(0);" class="card_user dropdown-toggle" uib-dropdown-toggle>@{{ user.users_first_name + ' ' + user.users_last_name }} <i class="fa fa-pencil"></i></a>
                                                            <div uib-dropdown-menu class="custom_pop_up">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-danger" ng-click="removeUserFromCard(user.users_id)">
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
                                                <span>@{{card.deadline}}</span>
                                                <div class="delete_card_item">
                                                    <i class="fa fa-trash-o" ng-click="removeCardDeadline()"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="card.users != '' && card.users || card.deadline">

                                    <div class="card_block description">
                                        <h4>Description:</h4>
                                        <div class="card_description">
                                            <div class="form-group">
                                                <p class="title_pointer" ng-show="show_description && card.description" ng-click="makeDescriptionCopy()">@{{card.description}}</p>
                                                <textarea class="form-control resize" ng-show=" ! show_description || ! card.description" ng-model="temp_description"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <button class="btn btn-add" ng-show=" ! show_description || ! card.description" ng-click="saveCardDescription()">Save</button>
                                                <button class="btn btn-danger" ng-show=" ! show_description && card.description" ng-click="resetCardDescription()">Cancel</button>
                                                <button class="btn btn-add" ng-show="show_description && card.description" ng-click="makeDescriptionCopy()">Edit</button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="checklists">

                                    <div class="card_block checklists" ng-repeat="checklist in checklists">
                                        <div class="checklist_header">
                                            <h4 ng-show=" ! showChecklistTitle[checklist.id]">
                                                <i class="fa fa-check-square-o"></i> <span class="checklist_title pointer" ng-click="showChecklistTitle[checklist.id] = ! showChecklistTitle[checklist.id]">@{{checklist.title}}</span>
                                            </h4>

                                            <div class="delete_card_item">
                                                <i class="fa fa-trash-o" ng-click="deleteChecklist(checklist)"></i>
                                            </div>

                                            <div class="input-group input-group-unstyled" ng-show="showChecklistTitle[checklist.id]">
                                                <input type="text" class="form-control" focus-me="showChecklistTitle[checklist.id]" ng-enter="saveChecklistTitle(checklist)" ng-model="checklist.title">
                                                <div class="btn btn-add save_title" ng-click="saveChecklistTitle(checklist)">
                                                    Save
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkbox_item" ng-repeat="checkbox in checkboxes[checklist.id]">
                                            <div class="card_checkbox" ng-class="{active: checkbox.status == 1}" ng-click="changeCheckboxStatus(checkbox)">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div class="card_checkbox_description" ng-click="selectCheckbox(checkbox)">
                                                <span ng-show=" ! editCheckbox[checkbox.id]" ng-class="{active_span: checkbox.status == 1}">@{{checkbox.title}}</span>
                                                <textarea ng-show="editCheckbox[checkbox.id]" class="form-control" ng-click="editCheckbox[checkbox.id] = ! editCheckbox[checkbox.id]" ng-model="checkbox_title[checkbox.id]"></textarea>
                                            </div>

                                            <div class="card_checkbox_settings" ng-show="editCheckbox[checkbox.id]">
                                                <div class="chekbox_settings_buttons">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <button class="btn btn-add" ng-click="saveCheckboxDescription(checkbox)">Save</button>
                                                            <button class="btn btn-danger" ng-click="resetCheckboxDescription(checkbox)">Cancel</button>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div uib-dropdown auto-close="outsideClick">
                                                                <button class="btn btn-add" uib-dropdown-toggle><i class="fa fa-user"></i> Users</button>

                                                                <div uib-dropdown-menu class="custom_pop_up">
                                                                    <div class="custom_pop_up_header text-center">
                                                                        <span>Users</span>
                                                                    </div>

                                                                   <div class="form-group">
                                                                        <select class="form-control" ng-model="card_users_list">
                                                                            <option disabled="disabled" value="">Select user</option>
                                                                            <option ng-repeat="user in card.users | filter:uncheckedUsers(checkbox)" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                                        </select>
                                                                    </div>

                                                                   <button type="button" class="btn btn-add" ng-click="addCheckboxUser(checkbox, card_users_list)">
                                                                       Add user
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div uib-dropdown auto-close="outsideClick">
                                                                <button class="btn btn-add" uib-dropdown-toggle><i class="glyphicon glyphicon-calendar"></i> Deadline</button>

                                                                <div uib-dropdown-menu class="custom_pop_up checkbox_deadline">
                                                                    <div class="custom_pop_up_header text-center">
                                                                        <span>Add deadline</span>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="input-group custom-datapicker-input">
                                                                            <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="checkbox_deadline.date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                                            <span class="input-group-btn">
                                                                                <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label>Hours:</label>
                                                                                <select class="form-control" name="checkbox_deadline_hour" ng-model="checkbox_deadline.hour">
                                                                                    <option ng-repeat="h in range(23)" value="@{{ h }}">@{{ h }}</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <label>Minutes:</label>
                                                                                <select class="form-control" name="checkbox_deadline_minute" ng-model="checkbox_deadline.minute">
                                                                                    <option ng-repeat="m in range(59)" value="@{{ m }}">@{{ m }}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <button type="button" class="btn btn-primary" ng-click="addTempCheckboxDeadline(checkbox)">
                                                                        Save
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="checkbox_settings add_checkbox">
                                                    <div class="row">
                                                        <div class="col-sm-6" ng-show="checkbox.users != '' ">
                                                            <h5>Users:</h5>
                                                            <div ng-repeat="user in checkbox.users">
                                                                <div uib-dropdown class="m-b-5" auto-close="outsideClick" ng-show="user != ''">
                                                                    <span class="card_user" uib-dropdown-toggle>
                                                                        @{{ user.users_first_name + ' ' + user.users_last_name }}
                                                                    </span>

                                                                    <div class="delete_card_item">
                                                                        <i class="fa fa-trash-o" ng-click="removeUserFromCheckbox(checkbox, user.users_id)"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6" ng-show="temp_checkbox_deadline[checkbox.id]">
                                                            <h5>Deadline:</h5>
                                                            <span>@{{temp_checkbox_deadline[checkbox.id]}}</span>

                                                            <div class="delete_card_item">
                                                                <i class="fa fa-trash-o" ng-click="removeTempCheckboxDeadline()"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="checkbox_settings" ng-show=" ! editCheckbox[checkbox.id]">
                                                <span ng-show="checkbox.users != '' ">Users: </span>
                                                <div  class="user_avatar preview" ng-repeat="users in checkbox.users" title="@{{users.users_first_name + ' ' + users.users_last_name}}" style="background-color:RGB(@{{ user.icon_color}})">
                                                    <span class="icon_name">@{{users.users_first_name.slice(0,1)}}</span>
                                                </div>

                                                <span ng-show="checkbox.deadline">Deadline: @{{checkbox.deadline}}</span>
                                            </div>
                                        </div>

                                        <div class="m-t-20">
                                            <a href="javascript:void(0);" ng-show=" ! showCheckBox[checklist.id]" ng-click="createNewCheckbox(checklist)">Add new item</a>
                                        </div>

                                        <div ng-show="showCheckBox[checklist.id]" class="dev_add_checkbox">
                                            <div class="form-group">
                                                <input type="text" class="form-control" ng-enter="addCheckbox(checklist)" ng-model="add_checkbox_title[checklist.id]">
                                            </div>

                                            <button class="btn btn-add" ng-click="addCheckbox(checklist)">Add</button>
                                            <button class="btn btn-danger" ng-click="showCheckBox[checklist.id] = ! showCheckBox[checklist.id]">Cancel</button>

                                            <div class="pull-right">
                                                <div uib-dropdown class="m-b-5" auto-close="outsideClick" class="dropdown_left">
                                                    <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-user"></i> Users</a>

                                                   <div uib-dropdown-menu class="custom_pop_up">
                                                        <div class="custom_pop_up_header text-center">
                                                            <span>Users</span>
                                                        </div>

                                                       <div class="form-group">
                                                            <select class="form-control" name="assign_to" ng-model="add_checkbox_users_list">
                                                                <option disabled="disabled" value="">Select user</option>
                                                                <option ng-repeat="user in not_checked_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                            </select>
                                                        </div>

                                                       <button type="button" class="btn btn-add" ng-click="addUserToList(add_checkbox_users_list)">
                                                           Add user
                                                        </button>
                                                    </div>
                                                </div>

                                                <div uib-dropdown class="m-b-5" auto-close="outsideClick" class="dropdown_left">
                                                    <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="glyphicon glyphicon-calendar"></i> Deadline</a>

                                                    <div uib-dropdown-menu class="custom_pop_up checkbox_deadline">
                                                        <div class="custom_pop_up_header text-center">
                                                            <span>Add deadline</span>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="input-group custom-datapicker-input">
                                                                <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="checkbox_deadline.date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label>Hours:</label>
                                                                    <select class="form-control" name="checkbox_deadline_hour" ng-model="checkbox_deadline.hour">
                                                                        <option ng-repeat="h in range(23)" value="@{{ h }}">@{{ h }}</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <label>Minutes:</label>
                                                                    <select class="form-control" name="checkbox_deadline_minute" ng-model="checkbox_deadline.minute">
                                                                        <option ng-repeat="m in range(59)" value="@{{ m }}">@{{ m }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <button type="button" class="btn btn-primary" ng-click="addTempCheckboxDeadline()">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="checkbox_settings add_checkbox">
                                                <div class="row">
                                                    <div class="col-sm-6" ng-show="checked_users != '' ">
                                                        <h5>Users:</h5>
                                                        <div ng-repeat="user in checked_users">
                                                            <div uib-dropdown class="m-b-5" auto-close="outsideClick" ng-show="user != ''">
                                                                <span class="card_user" uib-dropdown-toggle>
                                                                    @{{ user.users_first_name + ' ' + user.users_last_name }}
                                                                </span>
                                                                <div class="delete_card_item">
                                                                    <i class="fa fa-trash-o" ng-click="removeUserFromList(user.users_id)"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6" ng-show="showCheckboxDeadline">
                                                        <h5>Deadline:</h5>
                                                        <span>@{{temp_checkbox_deadline}}</span>
                                                        <div class="delete_card_item">
                                                            <i class="fa fa-trash-o" ng-click="removeTempCheckboxDeadline()"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="checklists != ''">

                                    <div class="card_comments">
                                        <div class="form-group">
                                            <h4><i class="fa fa-comments-o"></i> Add comment</h4>
                                            <textarea class="form-control resize" ng-model="comment_text"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-add" ng-click="saveComment()">Save</button>
                                        </div>

                                        <p ng-show="card.comments">Comments: </p>
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
                                    <div class="form-group">
                                        <button class="btn btn-success" ng-If="card.done == 0" ng-click="changeDone()">Mark as done</button>
                                        <button class="btn btn-add" ng-If="card.done == 1" ng-click="changeDone()">Mark as undone</button>
                                    </div>

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

                                                <button type="button" class="btn btn-add" ng-click="addUserToCard(users_list);">
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
                                                    <input type="text" class="form-control" ng-model="checklist_title" ng-enter="saveChecklist()">
                                                </div>

                                                <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveChecklist()">
                                                    Save
                                                </button>
                                            </div>
                                        </div>

                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="glyphicon glyphicon-calendar"></i> Deadline</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span>Add deadline</span>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-group custom-datapicker-input">
                                                        <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="card_deadline.date" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                   <div class="row">
                                                        <div class="col-sm-6">
                                                            <label>Hours:</label>
                                                            <select class="form-control" ng-model="card_deadline.hour">
                                                                <option ng-repeat="h in range(23)" value="@{{ h }}">@{{ h }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <label>Minutes:</label>
                                                            <select class="form-control" ng-model="card_deadline.minute">
                                                                <option ng-repeat="m in range(59)" value="@{{ m }}">@{{ m }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveCardDeadline()">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="delete_card">
                                        <a href="javascript:void(0);" class="btn btn-danger card_nav" ng-click="deleteCard()">Delete card</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       </div>

       <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Close</button>
       </div>
    </script>

    <script type="text/ng-template" id="ConfirmWindow.html">
        <div class="modal-header modal-header-primary">
            <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
            <h3>Uwaga</h3>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="col-md-12 form-group user-form-group">
                                <label class="control-label">Czy napewno usunąć?</label>
                                <div class="pull-right">
                                    <button class="btn btn-danger btn-sm" ng-click="cancel()">Nie</button>
                                    <button class="btn btn-add btn-sm" ng-click="delete()">Tak</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" ng-click="cancel()">Anuluj</button>
        </div>
    </script>

</div>