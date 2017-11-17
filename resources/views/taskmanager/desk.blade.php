<script>
    // в этой задаче неважно, как именно прятать элемент
    // например через style.display:
    document.getElementById('link_add').onclick = function() {
        document.getElementById('link_add').style.display = 'none';
    }
</script>

<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">

    <form class="no-transition" name="form" method="post" novalidate="novalidate">
        <div class="list_block" ng-repeat="task in tasks">
            <div class="col-sm-4">
                <div class="panel panel-bd lobidrag_task_manager" data-sortable="true">
                    <div class="panel-heading">
                        <p>@{{task.name}} <button class="btn-danger pull-right" ng-click="deleteTask(task.id)">X</button></p>
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