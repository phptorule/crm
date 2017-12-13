<div class="row task_manager_board"  data-ng-controller="Task_managerCtrl" ng-init="getDescs()">
    <form class="no-transition" id="task_manager" name="form" method="post" novalidate="novalidate">
        <div class="outer">
            <div class="hotfix_desk_switcher">
                <ul class="nav navbar-nav">
                    <li class="dropdown dropdown-user">
                        <button href="#" class="btn btn-add dropdown-toggle" data-toggle="dropdown" >
                            Choose your desk
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" ng-repeat="desc in descs" ng-click="changeDesc(desc.id)"><i class="fa fa-trello"></i> @{{desc.name}}</a></li>
                            <li class="text-center" style="padding: 0 20px 10px 20px">
                                <span>Create new desk</span>
                                <div class="input-group input-group-unstyled">
                                    <a href=""><input type="text" class="form-control" name="desc_name" ng-model="desc_name" ng-enter="saveDesc(desc_name)"></a>
                                    <div class="btn btn-add save_title" ng-click="saveDesc(desc_name)">
                                        Save
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div ng-repeat="desc in descs" ng-if="desc.id == check_desc">
                <!--h4 style="color:red;">this desc: @{{desc.name}}</h4-->
                <div class="sortable-outer task_manager_list" id="item-@{{task.id}} " ng-repeat="task in desc.tasks" >
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="list_title col-sm-10">
                                    <h4 ng-click="title = ! title" ng-show="title">@{{task.name}}</h4>
                                    <input type="text" name="task[]"  ng-model="task.id" hidden>
                                    <div class="input-group input-group-unstyled" ng-show=" ! title">
                                        <input type="text" focus-me="! title" class="form-control" ng-enter="saveTitle(task.id,task.name); title = ! title" ng-model="task.name">
                                        <div class="btn btn-add save_title" ng-show=" ! title" ng-mousedown="saveTitle(task.id,task.name); title = ! title">
                                            Save
                                        </div>
                                    </div>
                                </div>
                                <div class="list_settings col-sm-2 pull-right">
                                    <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                        <a href="javascript:void(0);" class="dropdown-toggle" uib-dropdown-toggle ng-click="getListTeamUsers(task.id)"><i class="fa fa-cog" aria-hidden="true"></i></a>
                                        <div uib-dropdown-menu class="custom_pop_up">
                                            <div class="text-left">
                                                <input type="button" value="Delete list" class="btn btn-danger" ng-click="deleteTask(task.id)">
                                            </div>

                                            <span>Users</span>

                                            <div class="form-group">
                                                <select class="form-control" name="assign_to" ng-model="users_list">
                                                    <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                </select>
                                            </div>

                                            <button type="button" class="btn btn-add" ng-click="saveUserToList(users_list,task.id);">
                                                Add user
                                            </button>

                                            <span ng-repeat="user in users">
                                                <p class="user_in_list"><span>@{{ user.users_first_name + ' ' + user.users_last_name }}</span><i class="icon_hidden fa fa-trash-o" ng-click="removeUserList(user.users_id,task.id)"></i></p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner">
                            <div class="panel-body">
                                <div class="sortable-inner task_manager_card" ng-repeat="card in task.cards" ng-class="{card_done: card.done == 1}" ng-click="selectCard(card)" ng-init="initSortable()">
                                    <p>@{{card.name}} <i class="fa fa-check" ng-If="card.done == 1"></i></p>
                                    <div class="preview_card">
                                        <div class="cards_preview_item" ng-If="card.card_user_me" title="You are subscribed to this card">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <div class="cards_preview_item" ng-If="card.card_description" title="This card has a description">
                                            <i class="fa fa-align-left"></i>
                                        </div>

                                        <div class="cards_preview_item" ng-If="card.card_comments_count" title="Comments">
                                            <i class="fa fa-comment"></i> @{{card.card_comments_count}}
                                        </div>

                                        <div class="cards_preview_item" ng-If="card.card_deadline" title="Deadline">
                                            <i class="fa fa-calendar-check-o"></i> @{{card.card_deadline}}
                                        </div>

                                        <div class="cards_preview_item" ng-If="card.card_checkbox_all" title="Checklist items">
                                            <i class="fa fa-check-square-o"></i> @{{card.card_cheked_checkbox}}/@{{card.card_checkbox_all}}
                                        </div>
                                    </div>
                                    <div class="preview_users text-right">
                                        <div ng-repeat="user in card.users" class="user_avatar preview" style="background-color: rgb(@{{ user.icon_color}})" title="@{{user.users_first_name + ' ' + user.users_last_name}}">
                                            <span class="icon_name">@{{user.users_first_name.slice(0,1)}}</span>
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
                                <input type="text" class="form-control" ng-enter="createCard(task.id)" ng-model="card.name_card" name="name_card" />
                                <button class="btn btn-add" ng-click="createCard(task.id)">Add card</button>
                                <a class="cancel_button" href="javascript:void(0);" ng-click="show_input_card = ! show_input_card"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="task_manager_list add_list">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="form-group">
                                <input type="text" class="form-control" ng-enter="addTask(name_task_block)" placeholder="Enter list name" ng-model="name_task_block" name="name_task_block" required />
                            </div>

                            <button class="btn btn-add" ng-click="addTask(name_task_block)" type="reset">Add list</button>
                            <!--a class="cancel_button" href="javascript:void(0);" ng-click="deleteTask()"><i class="fa fa-times"></i></a-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>


<script type="text/ng-template" id="SelectCard.html">
    <div class="modal-header modal-header-add no-transition" ng-init="initCard()">
        <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
        <h4 class="title_pointer" ng-show="card_title" ng-click="card_title = ! card_title"><b>@{{card.name}}</b> <i class="fa fa-check" area-hidden="true" ng-If="card.done == 1"></i></h4>
        <div class="input-group input-group-unstyled">
            <input type="text" focus-me="! card_title" ng-enter="saveCardTitle(card.cards_id,card.name);card_title = ! card_title" class="form-control" ng-show="! card_title" ng-model="card.name">
            <div class="btn btn-add save_title" ng-show=" ! card_title" ng-click="saveCardTitle(card.cards_id,card.name); card_title = ! card_title">
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
                                            <p class="title_pointer" ng-show="show_description" ng-click="makeDescriptionCopy(); show_description = ! show_description">@{{card.description}}</p>
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

                                <div class="card_block checklists" ng-repeat="checklist in checklists">
                                    <div class="checklist_header">
                                        <!--  -->
                                        <h4 class="title_pointer" ng-show="checklist.created_at" ng-click="checklist.created_at = ! checklist.created_at">
                                            <i class="fa fa-check-square-o"></i> @{{checklist.title}}
                                        </h4>
                                        <input type="text" focus-me="! checklist.created_at" ng-enter="saveChecklistTitle(checklist.id, checklist.title); checklist.created_at = ! checklist.created_at" class="form-control" ng-show="! checklist.created_at" ng-model="title[checklist.id]">
                                        <!--a href="javascript:void(0);" ng-click="deleteCheckList(checklist.id)">Delete checklist</a-->
                                    </div>

                                    <div class="checkbox_item" ng-repeat="checkbox in checklist.checkboxes">
                                        <div ng-show="checkbox.status == 0">
                                            <div class="card_checkbox" ng-click="changeCheckboxStatus(checkbox.id)">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div class="card_checkbox_description" ng-click="makeCheckboxDescriptionCopy(checkbox)">
                                                <span ng-show=" ! editChecklistItem[checkbox.id]">@{{checkbox.title}}</span>
                                                <textarea ng-show="editChecklistItem[checkbox.id]" class="form-control" ng-click="editChecklistItem[checkbox.id] = ! editChecklistItem[checkbox.id]" ng-model="checkbox_title[checkbox.id]"></textarea>
                                            </div>

                                            <div class="checkbox_description_buttons" ng-show="editChecklistItem[checkbox.id]">
                                                <button class="btn btn-add" ng-click="saveCheckboxDescription(checkbox)">Save</button>
                                                <button class="btn btn-danger" ng-click="resetCheckboxDescription(checkbox)">Cancel</button>
                                            </div>
                                        </div>

                                        <div ng-show="checkbox.status == 1">
                                            <div class="card_checkbox active" ng-click="changeCheckboxStatus(checkbox.id)">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div class="card_checkbox_description" ng-click="makeCheckboxDescriptionCopy(checkbox)">
                                                <span class="active_span" ng-show=" ! editChecklistItem[checkbox.id]">@{{checkbox.title}}</span>
                                                <textarea ng-show="editChecklistItem[checkbox.id]" class="form-control" ng-click="editChecklistItem[checkbox.id] = ! editChecklistItem[checkbox.id]" ng-model="checkbox_title[checkbox.id]"></textarea>
                                            </div>

                                            <div class="checkbox_description_buttons" ng-show="editChecklistItem[checkbox.id]">
                                                <button class="btn btn-add" ng-click="saveCheckboxDescription(checkbox)">Save</button>
                                                <button class="btn btn-danger" ng-click="resetCheckboxDescription(checkbox)">Cancel</button>
                                            </div>
                                        </div>

                                        <div class="checkbox_settings">
                                            <span ng-show="checkbox.deadline">Deadline: @{{checkbox.deadline}}</span>
                                            <span ng-show="checkbox.users">Users: </span>

                                            <div  class="user_avatar preview" ng-repeat="users in checkbox.users" style="background-color:RGB(@{{ user.icon_color}})">
                                                <span class="icon_name">@{{users.users_first_name.slice(0,1)}}</span>
                                            </div>
                                        </div>

                                        <div class="delete_chceckbox" ng-click="deleteCheckBox(checkbox.id)">
                                            <i class="fa fa-trash-o"></i>
                                        </div>
                                    </div>


                                    <div ng-show=" ! showCheckBox" class="dev_add_checkbox">
                                        <div class="form-group">
                                            <input class="form-control" ng-enter="addCheckbox(checklist.id, checklists[l].checkbox_title)" type="text" ng-model="checklists[l].checkbox_title">
                                        </div>

                                        <div class="checkbox_settings" style="margin-left: 0; margin-bottom: 20px;">
                                            <div  class="user_avatar preview" ng-repeat="user in temp_users" style="background-color:RGB(@{{ user.icon_color}})">
                                                <span class="icon_name" style="cursor:pointer;" ng-click="deletePreviewUserCheckbox(user.users_id)">@{{user.users_first_name.slice(0,1)}}
                                                    <span style="font-size:10px;">x</span>
                                                </span>
                                            </div>

                                            <span ng-If="temp_deadline" ng-click="clearCheckboxDeadline()" style="cursor:pointer;">Deadline: @{{temp_deadline}} X</span>
                                        </div>

                                        <button class="btn btn-add" ng-click="addCheckbox(checklist.id, checklists[l].checkbox_title)">Add</button>
                                        <button class="btn btn-danger" ng-click="showCheckBox = ! showCheckBox" type="reset" ng-click="addCheckbox(checklists[l],checklists[l].checkbox_title,save=false)">Cancel</button>

                                        <div class="pull-right">
                                            <div uib-dropdown class="m-b-5" auto-close="outsideClick" class="dropdown_left">
                                                <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-user"></i> Users</a>

                                               <div uib-dropdown-menu class="custom_pop_up">
                                                    <div class="custom_pop_up_header text-center">
                                                        <span>Users</span>
                                                    </div>

                                                   <div class="form-group">
                                                        <select class="form-control" name="assign_to" ng-model="users_list">
                                                            <option ng-repeat="user in users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                        </select>
                                                    </div>

                                                   <button type="button" class="btn btn-add" ng-click="saveUserToCheckbox(users_list);">
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
                                                            <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="deadline" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label>Hours:</label>
                                                                <select class="form-control" name="assign_to" ng-model="hh">
                                                                    <option ng-repeat="h in time_h" value="@{{ h }}">@{{h}}</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label>Minutes:</label>
                                                                <select class="form-control" name="assign_to" ng-model="mm">
                                                                    <option ng-repeat="m in time_m" value="@{{ m }}">@{{m}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveCheckboxDeadline(deadline,hh,mm);">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="delete_chceckbox" ng-click="deleteCheckBox(checkbox.id)">
                                            <i class="fa fa-trash-o"></i>
                                        </div>

                                    </div>

                                    <div class="m-t-20">
                                        <a href="javascript:void(0);" ng-show="showCheckBox" ng-click="showCheckBox = ! showCheckBox">Add new item</a>
                                    </div>
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
                                                <input type="text" class="form-control" ng-model="checklists.title" ng-enter="saveChecklist()">
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
                                                    <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="deadline" is-open="date[0].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default" ng-click="calendarOpen(0)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Hours:</label>
                                                        <select class="form-control" name="assign_to" ng-model="hh">
                                                            <option ng-repeat="h in time_h" value="@{{ h }}">@{{h}}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label>Minutes:</label>
                                                        <select class="form-control" name="assign_to" ng-model="mm">
                                                            <option ng-repeat="m in time_m" value="@{{ m }}">@{{m}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveDeadline(deadline,hh,mm);">
                                                Save
                                            </button>
                                        </div>
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