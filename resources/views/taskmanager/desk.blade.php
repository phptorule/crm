<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">

   
    <form class="no-transition" name="form" method="post" novalidate="novalidate">



        <div class="col-sm-3" ng-repeat="task in tasks">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <span></span>
                    <p></p>
                    <br>
                    <button class="btn btn-primary" ng-click="initTask()">add</button>
                    <button class="btn btn-danger" ng-click="deleteTask()">X</button>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <span></span>
                    <input type="text" class="form-control" placeholder="Введить назву" ng-model="list.name_task_block" name="name_task_block" required />
                    <br>
                    <button class="btn btn-primary" ng-click="initTask()">add</button>
                    <button class="btn btn-danger" ng-click="deleteTask()">X</button>
                </div>
            </div>
        </div>

    </form>
</div>