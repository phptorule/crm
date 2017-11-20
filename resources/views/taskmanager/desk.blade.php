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
    <div class="modal-header modal-header-primary" ng-init="getCard()">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <p ng-show="card_title" ng-click="status_card_title_edit()">@{{card.name}}</p>
       <input type="text" ng-show="card_title_edit" ng-blur="status_card_title_edit();saveCardTitle(card.id,card.name)" ng-model="card.name">
    </div>


        


   <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form class="no-transition">
                        <div class="row">

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <p>
                                        Users:<span ng-repeat="users_in_card in card.users_in_card">@{{users_in_card.users_first_name}}, </span> <span class="btn_add">+</span>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <p ng-show="status_description" ng-click="show_description()">@{{card.description}}</p>
                                    <textarea class="form-control resize" ng-show="status_description_textarea" ng-model="card.description"></textarea>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" ng-click="saveCard(); show_description();">Save</button>
                                    <button class="btn btn-danger" ng-If="card.description.length > 1" ng-click="reset(card.id)">Cancel</button>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <p class="text-center">Add</p>
                                <p ng-click="users_teams=!users_teams" class="card_nav"><i class="fa fa-user m-r-5"></i>Users</p>
                                <div ng-show="users_teams">


                                    <div class="row">
                                        <div class="col-sm-8">
                                            <select class="form-control" ng-model="user.users_id_select">
                                                <option ng-repeat="users in card.users" ng-model="users.users_id">@{{ users.users_id }}</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" ng-click="addToCard(user.users_id_select)">
                                               <i class="fa fa-plus"></i>
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