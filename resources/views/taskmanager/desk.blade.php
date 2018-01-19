<div data-ng-controller="TaskManagerCtrl" ng-init="initTaskManager()">
    <section class="content-header">
        <div class="header-icon">
            <i class="fa fa-briefcase"></i>
        </div>

        <div class="header-title">
            <h4 ng-show="desk_title"><span class="pointer" ng-click="desk_title = ! desk_title">@{{desk.name}}</span></h4>

            <div class="input-group input-group-unstyled" ng-show=" ! desk_title">
                <input type="text" focus-me="! desk_title" class="form-control" ng-enter="saveDeskTitle()" ng-model="desk.name">
                <div class="btn btn-add save_title" ng-click="saveDeskTitle()">
                    Zapisz
                </div>
            </div>
        </div>

        <div class="task_manager_header pull-right">
            <div class="add_customer">
                <div ng-show="! showCustomerLink">
                    <select class="form-control" ng-model="customers_list">
                        <option value='0' disabled="disabled">Dodaj kontrahenta</option>
                        <option ng-repeat="customer in customers" value="@{{ customer.customer_id }}">@{{ customer.company_name }}</option>
                    </select>

                    <button class="btn btn-add" ng-click="selectCustomer(customers_list)">Zapisz</button>
                </div>

                <div class="add_customer_link" ng-show="showCustomerLink">
                    <a href="/customers/add/@{{ customer_url_text }}/@{{ customer_id }}/">@{{ customer_name }}</a>

                    <div class="delete_card_item">
                        <i class="fa fa-trash-o" ng-click="showCustomerLink = ! showCustomerLink"></i>
                    </div>
                </div>
            </div>

            <div class="desk_switcher">
                <div uib-dropdown auto-close="outsideClick">
                    <button class="btn btn-add" uib-dropdown-toggle>
                        Wybierz Projekt
                    </button>

                    <div uib-dropdown-menu class="custom_pop_up">
                        <ul>
                            <li ng-repeat="desk in desks"><a href="#" ng-click="getDeskLists(desk)"><i class="fa fa-trello"></i> @{{desk.name}}</a></li>
                        </ul>

                        <div class="create_desk text-center">
                            <span>Stworzyć nowy projekt</span>
                            <div class="input-group input-group-unstyled">
                                <input type="text" class="form-control" ng-model="create_desk_name" ng-enter="saveDesk(create_desk_name)" />
                                <div class="btn btn-add save_title" ng-click="saveDesk(create_desk_name)">
                                    Zapisz
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-danger" ng-click="deleteDesk()">Zarchiwizować projekt</button>
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
                                    <h4 ng-click="editListTitle(task)" ng-show=" ! title[task.id]">@{{task.name}}</h4>
                                    <div class="input-group input-group-unstyled" ng-show="title[task.id]">
                                        <input type="text" focus-me="! title[task.id]" class="form-control" ng-enter="saveTaskTitle(task)" ng-model="task.name">
                                        <div class="btn btn-add save_title" ng-click="saveTaskTitle(task)">
                                            Zapisz
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
                                                <span>Użytkownicy</span>

                                                <select class="form-control" name="assign_to" ng-model="users_list">
                                                    <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                </select>
                                            </div>

                                            <button type="button" class="btn btn-add" ng-click="saveUserToList(users_list,task.id);">
                                                Dodaj użytkownika
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
                                    <div class="cards_preview_item" ng-show="card.card_preview.assign_to_card" title="You are subscribed to this card">
                                        <i class="fa fa-user"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.card_preview.description" title="This card has a description">
                                        <i class="fa fa-align-left"></i>
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.card_preview.comments_amount" title="Comments">
                                        <i class="fa fa-comment"></i> @{{ card.card_preview.comments_amount }}
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.card_preview.deadline_preview" title="Deadline">
                                        <i class="fa fa-calendar-check-o"></i> @{{ card.card_preview.deadline_preview }}
                                    </div>

                                    <div class="cards_preview_item" ng-show="card.card_preview.all_checkboxes" title="Checklist items">
                                        <i class="fa fa-check-square-o"></i> @{{ card.card_preview.checked_checkboxes}}/@{{card.card_preview.all_checkboxes }}
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

                <div class="add_list_link inline_block" ng-show="! addNewList">
                    <a href="javascript:void(0);" ng-click="addNewList = ! addNewList">Add new list</a>
                </div>

                <div class="task_manager_list add_list" ng-show="addNewList">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="form-group">
                                <input type="text" class="form-control" ng-enter="addTaskList()" placeholder="Enter list name" ng-model="task_name" />
                            </div>

                            <button class="btn btn-add" ng-click="addTaskList()">Add list</button>
                            <button class="btn btn-danger" ng-click="addNewList = ! addNewList">Anuluj</button>
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
                    Zapisz
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
                                                    <h4>Użytkownicy:</h4>
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
                                                <h4>Termin do:</h4>
                                                <span>@{{card.deadline}}</span>
                                                <div class="delete_card_item">
                                                    <i class="fa fa-trash-o" ng-click="removeCardDeadline()"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="card.users != '' && card.users || card.deadline">

                                    <div class="assign_customer_block" ng-show="customer_is_designer">
                                        <h4>
                                            <div class="inline_title">Projektant</div>

                                            <div class="delete_card_item">
                                                <i class="fa fa-trash-o" ng-click="deleteCustomerFromCard(customer_designer)"></i>
                                            </div>
                                        </h4>

                                        <div class="customer_description">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Osoba kontaktowa</label>
                                                        <span class="form-span">@{{ customer_designer.contact_person }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nazwa firmy</label>
                                                        <span class="form-span">@{{ customer_designer.company_name }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Telefon</label>
                                                        <span class="form-span">@{{ customer_designer.phone_number }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <span class="form-span">@{{ customer_designer.email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="customer_is_designer">

                                    <div class="assign_customer_block" ng-show="customer_is_officeman">
                                        <h4>
                                            <div class="inline_title">Urzędnik</div>

                                            <div class="delete_card_item">
                                                <i class="fa fa-trash-o" ng-click="deleteCustomerFromCard(customer_officeman)"></i>
                                            </div>
                                        </h4>

                                        <div class="customer_description">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Osoba kontaktowa</label>
                                                        <span class="form-span">@{{ customer_officeman.contact_person }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Nazwa firmy</label>
                                                        <span class="form-span">@{{ customer_officeman.company_name }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Telefon</label>
                                                        <span class="form-span">@{{ customer_officeman.phone_number }}</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <span class="form-span">@{{ customer_officeman.email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="customer_is_officeman">

                                    <div class="card_block description">
                                        <h4>Opis:</h4>
                                        <div class="card_description">
                                            <div class="description_add" ng-show="! card.description && show_description">
                                                <a href="javascript:void(0);" ng-click="show_description = ! show_description"><i class="fa fa-align-left"></i> Dodaj opis</a>
                                            </div>

                                            <div class="description_area" ng-show="card.description || ! show_description">
                                                <div class="form-group">
                                                    <p class="pointer" ng-show="show_description && card.description" ng-click="makeDescriptionCopy()">@{{card.description}}</p>
                                                    <textarea class="form-control resize" ng-show=" ! show_description" ng-model="temp_description"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <button class="btn btn-add" ng-show=" ! show_description" ng-click="saveCardDescription()">Zapisz</button>
                                                    <button class="btn btn-danger" ng-show=" ! show_description" ng-click="resetCardDescription()">Anuluj</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr ng-show="checklists">

                                    <div class="card_block checklists" ng-repeat="checklist in checklists">
                                        <div class="checklist_header">
                                            <h4 ng-show=" ! showChecklistTitle[checklist.id]">
                                                <i class="fa fa-check-square-o"></i> <div class="checklist_title pointer" ng-click="showChecklistTitle[checklist.id] = ! showChecklistTitle[checklist.id]">@{{checklist.title}}</div>
                                            </h4>

                                            <div class="delete_card_item">
                                                <i class="fa fa-trash-o" ng-click="deleteChecklist(checklist)"></i>
                                            </div>

                                            <div class="input-group input-group-unstyled" ng-show="showChecklistTitle[checklist.id]">
                                                <input type="text" class="form-control" focus-me="showChecklistTitle[checklist.id]" ng-enter="saveChecklistTitle(checklist)" ng-model="checklist.title">
                                                <div class="btn btn-add save_title" ng-click="saveChecklistTitle(checklist)">
                                                    Zapisz
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
                                                            <button class="btn btn-add" ng-click="saveCheckboxDescription(checkbox)">Zapisz</button>
                                                            <button class="btn btn-danger" ng-click="resetCheckboxDescription(checkbox)">Anuluj</button>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div uib-dropdown auto-close="outsideClick">
                                                                <button class="btn btn-add" uib-dropdown-toggle><i class="fa fa-user"></i> Użytkownicy</button>

                                                                <div uib-dropdown-menu class="custom_pop_up">
                                                                    <div class="custom_pop_up_header text-center">
                                                                        <span>Użytkownicy</span>
                                                                    </div>

                                                                   <div class="form-group">
                                                                        <select class="form-control" ng-model="card_users_list">
                                                                            <option disabled="disabled" value="">Select user</option>
                                                                            <option ng-repeat="user in card.users | filter:uncheckedUsers(checkbox)" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                                        </select>
                                                                    </div>

                                                                   <button type="button" class="btn btn-add" ng-click="addCheckboxUser(checkbox, card_users_list)">
                                                                       Dodaj użytkownika
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div uib-dropdown auto-close="outsideClick">
                                                                <button class="btn btn-add" uib-dropdown-toggle><i class="glyphicon glyphicon-calendar"></i> Termin</button>

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
                                                                        Zapisz
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="checkbox_settings add_checkbox">
                                                    <div class="row">
                                                        <div class="col-sm-6" ng-show="checkbox.users != '' ">
                                                            <h5>Użytkownicy:</h5>
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
                                                <span ng-show="checkbox.users != '' ">Użytkownicy: </span>
                                                <div  class="user_avatar preview" ng-repeat="users in checkbox.users" title="@{{users.users_first_name + ' ' + users.users_last_name}}" style="background-color:RGB(@{{ user.icon_color}})">
                                                    <span class="icon_name">@{{users.users_first_name.slice(0,1)}}</span>
                                                </div>

                                                <span ng-show="checkbox.deadline">Termin: @{{checkbox.deadline}}</span>
                                            </div>
                                        </div>

                                        <div class="m-t-20">
                                            <a href="javascript:void(0);" ng-show=" ! showCheckBox[checklist.id]" ng-click="createNewCheckbox(checklist)">Dodaj checkboxa</a>
                                        </div>

                                        <div ng-show="showCheckBox[checklist.id]" class="dev_add_checkbox">
                                            <div class="form-group">
                                                <input type="text" class="form-control" ng-enter="addCheckbox(checklist)" ng-model="add_checkbox_title[checklist.id]">
                                            </div>

                                            <button class="btn btn-add" ng-click="addCheckbox(checklist)">Zapisz</button>
                                            <button class="btn btn-danger" ng-click="showCheckBox[checklist.id] = ! showCheckBox[checklist.id]">Anuluj</button>

                                            <div class="pull-right">
                                                <div uib-dropdown class="m-b-5" auto-close="outsideClick" class="dropdown_left">
                                                    <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-user"></i> Użytkownicy</a>

                                                   <div uib-dropdown-menu class="custom_pop_up">
                                                        <div class="custom_pop_up_header text-center">
                                                            <span>Użytkownicy</span>
                                                        </div>

                                                       <div class="form-group">
                                                            <select class="form-control" name="assign_to" ng-model="add_checkbox_users_list">
                                                                <option disabled="disabled" value="">Select user</option>
                                                                <option ng-repeat="user in not_checked_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                            </select>
                                                        </div>

                                                       <button type="button" class="btn btn-add" ng-click="addUserToList(add_checkbox_users_list)">
                                                           Dodaj użytkownika
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
                                                            Zapisz
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="checkbox_settings add_checkbox">
                                                <div class="row">
                                                    <div class="col-sm-6" ng-show="checked_users != '' ">
                                                        <h5>Użytkownicy:</h5>
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
                                                        <h5>Termin:</h5>
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
                                            <h4>Dodaj komentarz</h4>
                                            <textarea class="form-control resize" ng-model="comment_text"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-add" ng-click="saveComment()">Zapisz</button>
                                        </div>

                                        <p ng-show="comments">Komentarze: </p>
                                        <div ng-repeat="comment in comments">
                                            <div class="card_comment_block">
                                                <div class="comment_author">
                                                    @{{comment.users.users_first_name + ' ' + comment.users.users_last_name  + ' (' + comment.comment_date + ')'}}
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
                                        <button class="btn btn-add" ng-If="card.done == 0" ng-click="changeDone()">Zaznacz jako zrobione</button>
                                        <button class="btn btn-add" ng-If="card.done == 1" ng-click="changeDone()">Zaznacz jako nie zrobione</button>
                                    </div>

                                    <h4>Dodaj</h4>

                                    <div class="form-group">
                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-user"></i> Użytkownicy</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span>Użytkownicy</span>
                                                </div>

                                                <div class="form-group">
                                                    <select class="form-control" name="assign_to" ng-model="users_list">
                                                        <option ng-repeat="user in team_users" value="@{{ user.users_id }}">@{{user.users_first_name + ' ' + user.users_last_name}}</option>
                                                    </select>
                                                </div>

                                                <button type="button" class="btn btn-add" ng-click="addUserToCard(users_list);">
                                                   Dodaj użytkownika
                                                </button>
                                             </div>
                                        </div>

                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-check-square-o"></i> Lista</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span>Dodaj listę</span>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" ng-model="checklist_title" ng-enter="saveChecklist()">
                                                </div>

                                                <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveChecklist()">
                                                    Zapisz
                                                </button>
                                            </div>
                                        </div>

                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-calendar"></i> Termin</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span>Dodaj termin</span>
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
                                                    Zapisz
                                                </button>
                                            </div>
                                        </div>

                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-tag"></i> Etykieta</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span>Dodaj etykietę</span>
                                                </div>

                                                <ul class="label_picker">
                                                    <li>
                                                        <a href="javascript:void(0);" title="Dodaj opis" ng-click="addLabelDescription(green)"><i class="fa fa-pencil"></i></a>
                                                        <span class="card_label green_label"></span>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" title="Dodaj opis" ng-click="addLabelDescription(yellow)"><i class="fa fa-pencil"></i></a>
                                                        <span class="card_label yellow_label"></span>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" title="Dodaj opis" ng-click="addLabelDescription(orange)"><i class="fa fa-pencil"></i></a>
                                                        <span class="card_label orange_label"></span>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" title="Dodaj opis" ng-click="addLabelDescription(red)"><i class="fa fa-pencil"></i></a>
                                                        <span class="card_label red_label"></span>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" title="Dodaj opis" ng-click="addLabelDescription(blue)"><i class="fa fa-pencil"></i></a>
                                                        <span class="card_label blue_label"></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="m-b-5">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" ng-click="selectCustomer('designers')"><i class="fa fa-user-plus"></i> Dodaj projektanta</a>
                                        </div>

                                        <div class="m-b-5">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" ng-click="selectCustomer('offices')"><i class="fa fa-user-plus"></i> Dodaj urzędnika</a>
                                        </div>

                                        <div uib-dropdown class="m-b-5" auto-close="outsideClick">
                                            <a href="javascript:void(0);" class="btn card_nav dropdown-toggle" uib-dropdown-toggle><i class="fa fa-flag"></i> Wniosek o wydanie decyzji</a>

                                            <div uib-dropdown-menu class="custom_pop_up">
                                                <div class="custom_pop_up_header text-center">
                                                    <span></span>
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
                                                    <div class="input-group custom-datapicker-input">
                                                        <input type="text" class="form-control" uib-datepicker-popup="yyyy/MM/dd" ng-model="card_deadline.date" is-open="date[1].opened" show-button-bar="false" datepicker-options="dateOptions" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" ng-click="calendarOpen(1)"><i class="glyphicon glyphicon-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" />
                                                </div>

                                                <button type="button" aria-hidden="true" class="btn btn-primary" ng-click="saveCardDeadline()">
                                                    Zapisz
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="delete_card">
                                        <a href="javascript:void(0);" class="btn btn-danger card_nav" ng-click="deleteCard()">Zarchiwizuj</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       </div>

       <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
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

    <script type="text/ng-template" id="SelectCustomer.html">
        <div class="modal-header modal-header-primary" ng-init="initList()">
           <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
           <h3><i class="fa fa-user m-r-5"></i> @{{ modal_title }}</h3>
        </div>

        <div class="modal-body">
           <div class="row">
                <div class="col-md-12">
                    <div class="modal_content_header">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Szukaj</label>
                                        <input type="text" class="form-control" name="search_input" placeholder="Szukaj" ng-model="searchInput" />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <button class="btn btn-add pull-right" ng-click="addCustomer()">
                                        <i class="fa fa-plus"></i> @{{ modal_add_customer }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="customers_table" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="info">
                                    <th>Nazwa firmy</th>
                                    <th>Numer NIP</th>
                                    <th>Miejscowosc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="customer in customers | filter:searchInput">
                                    <td><a href="javascript:void(0);" ng-click="getCustomer(customer)">@{{ customer.company_name }}</a></td>
                                    <td>@{{ customer.nip }}</td>
                                    <td>@{{ customer.invoice_town }}</td>
                                </tr>
                            </tbody>
                       </table>

                       <!--footer class="table-footer">
                            <div class="row">
                                <div class="col-md-offset-6 col-md-6 text-right pagination-container">
                                    <pagination
                                        ng-model="currentPage"
                                        total-items="todos.length"
                                        max-size="maxSize"
                                        boundary-links="true">
                                    </pagination>
                                </div>
                            </div>
                        </footer-->
                    </div>
                </div>
            </div>
       </div>

       <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
       </div>
    </script>

    <script type="text/ng-template" id="CreateCustomer.html">
        <div class="modal-header modal-header-primary" ng-init="initList()">
           <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
           <h3><i class="fa fa-user m-r-5"></i> Utwórz Kontrahenta</h3>
        </div>

        <div class="modal-body">
           <div class="row">
                <div class="col-md-12">
                    <form class="no-transition" name="form" method="post" novalidate="novalidate">
                        <div class="row">
                            <div class="col-sm-12 mb-30">
                                <h3 class="modal_h3">Informacje podstawowe</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nazwa firmy</label><span class="req_field"> *</span>
                                            <input type="text" class="form-control" name="company_name" ng-model="customers.company_name" required />
                                        </div>

                                        <div class="form-group">
                                            <label>Numer NIP</label>
                                            <input type="text" class="form-control" name="nip" ng-model="customers.nip" />
                                        </div>

                                        <div class="form-group">
                                            <label>Osoba kontaktowa</label>
                                            <input type="text" class="form-control" name="contact_person" ng-model="customers.contact_person" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Telefon</label>
                                            <input type="text" class="form-control" name="phone_number" ng-model="customers.phone_number" />
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email" ng-model="customers.email" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-30">
                                <h3 class="modal_h3">Informacje adresowe do faktury</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Ulica</label>
                                            <input type="text" class="form-control" name="invoice_street" ng-model="customers.invoice_street" />
                                        </div>

                                        <div class="form-group">
                                            <label>Skrytka Pocztowa do faktury</label>
                                            <input type="text" class="form-control" name="invoice_mailbox" ng-model="customers.invoice_mailbox" />
                                        </div>

                                        <div class="form-group">
                                            <label>Miejscowosc</label>
                                            <input type="text" class="form-control" name="invoice_town" ng-model="customers.invoice_town" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Wojewodztwo</label>
                                            <input type="text" class="form-control" name="invoice_province" ng-model="customers.invoice_province"  />
                                        </div>

                                        <div class="form-group">
                                            <label>Kod</label>
                                            <input type="text" class="form-control" name="invoice_post_code" ng-model="customers.invoice_post_code" />
                                        </div>

                                        <div class="form-group">
                                            <label>Kraj</label>
                                            <input type="text" class="form-control" name="invoice_region" ng-model="customers.invoice_region" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h3 class="modal_h3">Informacje adresowe do wysylki</h3>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Ulica - Adres wysylki</label>
                                            <input type="text" class="form-control" name="send_street" ng-model="customers.send_street" />
                                        </div>

                                        <div class="form-group">
                                            <label>Skrytka Pocztowa do wysylki</label>
                                            <input type="text" class="form-control" name="send_mailbox" ng-model="customers.send_mailbox" />
                                        </div>

                                        <div class="form-group">
                                            <label>Miejscowosc - Adres wysylki</label>
                                            <input type="text" class="form-control" name="send_town" ng-model="customers.send_town" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Wojewodztwo - Adres wysylki</label>
                                            <input type="text" class="form-control" name="send_province" ng-model="customers.send_province" />
                                        </div>

                                        <div class="form-group">
                                            <label>Kod - Adres wysylki</label>
                                            <input type="text" class="form-control" name="send_post_code" ng-model="customers.send_post_code" />
                                        </div>

                                        <div class="form-group">
                                            <label>Kraj - Adres wysylki</label>
                                            <input type="text" class="form-control" name="send_region" ng-model="customers.send_region" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-add" ng-click="saveCustomer()">{{ __('Dodaj nowego kontrahenta') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
       </div>

       <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Anuluj</button>
       </div>
    </script>

</div>