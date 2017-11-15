<script>
    // в этой задаче неважно, как именно прятать элемент
    // например через style.display:
    document.getElementById('link_add').onclick = function() {
        document.getElementById('link_add').style.display = 'none';
    }
</script>

<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">
   
    <form class="no-transition" name="form" method="post" novalidate="novalidate">

        <div class="col-sm-4" ng-repeat="task in tasks">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <p>@{{task.name}} <button class="btn-danger pull-right" ng-click="deleteTask(task.id)">X</button></p>
                    <p ng-repeat-"card_names in task.cards">@{{card_names.name}}</p>
                </div>


                <div class="panel panel-bd lobidrag_task_manager">
                    <div class="panel-heading">
                        <p><a href='' ng-click="show_input_task=true" nh-show="add_task" id="link_add">add</a></p>
                        <input type="text" class="form-control" ng-model="card.name_card" ng-show="show_input_task" name="name_card" placeholder="Введить назву" required />
                        <br>
                        <button class="btn btn-primary" ng-show="show_input_task" ng-click="createCard()">add</button>
                        <button class="btn btn-danger"  ng-show="show_input_task" ng-click="show_input_task=false">X</button>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <input type="text" class="form-control" placeholder="Введить назву" ng-model="list.name_task_block" name="name_task_block" required />
                    <br>
                    <button class="btn btn-primary" ng-click="initTask()" type="reset">add</button>
                    <button class="btn btn-danger" ng-click="deleteTask()">X</button>
                </div>
            </div>
        </div>

    </form>
</div>