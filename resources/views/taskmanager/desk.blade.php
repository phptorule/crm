<script>
<<<<<<< HEAD
    // в этой задаче неважно, как именно прятать элемент
    // например через style.display:
=======
>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650
    document.getElementById('link_add').onclick = function() {
        document.getElementById('link_add').style.display = 'none';
    }
</script>
<<<<<<< HEAD

<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">

    <form class="no-transition" name="form" method="post" novalidate="novalidate">
        <div class="list_block" ng-repeat="task in tasks">
            <div class="col-sm-4">
                <div class="panel panel-bd lobidrag_task_manager" data-sortable="true">
                    <div class="panel-heading">
                        <p>@{{task.name}} <button class="btn-danger pull-right" ng-click="deleteTask(task.id)">X</button></p>
                    </div>
                </div>
=======

<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">
   
    <form class="no-transition" name="form" method="post" novalidate="novalidate">

        
        <div class="col-sm-4" ng-repeat="(k,task) in tasks">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <p>task_block: @{{tasks[k].name}} <button class="btn-danger pull-right" ng-click="deleteTask(task.id)">X</button></p>
                    <hr>
                    <p ng-repeat="card in cards[k]">card: @{{card.name}}</p>
                       
                </div>


                <div class="panel panel-bd lobidrag_task_manager">
                    <div class="panel-heading">
                        
                        <p><a href='' ng-click="show_input_task=true" nh-show="add_task" id="link_add">add</a></p>
                        <input type="text" class="form-control" ng-model="card.name_card" ng-show="show_input_task" name="name_card" placeholder="Введить назву" required />
                        <br>
                        <button class="btn btn-primary" ng-show="show_input_task" ng-click="createCard(tasks[k].id)" type="reset">add</button>
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
>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650
            </div>
        </div>


        <div class="col-sm-4">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
<<<<<<< HEAD
                    <input type="text" class="form-control" placeholder="Введить назву" ng-model="list.name_task_block" name="name_task_block" required />
                    <br>
                    <button class="btn btn-primary" ng-click="initTask()" type="reset">add</button>
                    <button class="btn btn-danger" ng-click="deleteTask()">X</button>
=======
                    <div class="col-sm-4">
                        <div class="panel panel-bd lobidrag_task_manager">
                            <div class="panel-heading">
                                <p>11</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-bd lobidrag_task_manager">
                            <div class="panel-heading">
                                <p>12</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    2
>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650
                </div>
            </div>
        </div>

    </form>
</div>