<div class="row" data-ng-controller="Task_managerCtrl" ng-init="init()">


    
    <form class="no-transition" name="form" method="post" novalidate="novalidate">
        

        <div class="col-sm-3">


            <div class="panel panel-bd lobidrag">

                <div class="panel-heading">

                    <div class="btn-group" id="buttonlist">
                        <h6>Informacje podstawowe</h6>
                    </div>

                    <div class="custom_panel_block" ng-show="finances_id">
                        <div class="custom_panel_item pull-right">
                            <a href="javascript:void(0);" ng-show=" ! edit_general" ng-click="editFinances('general')">Edytuj dane <i class="panel-control-icon ti-pencil"></i></a>
                        </div>

                        <div class="custom_panel_item" ng-show="edit_general">
                            <a href="javascript:void(0);" ng-click="saveProduct()">Zapisz <i class="fa fa-floppy-o"></i></a>
                        </div>

                        <div class="custom_panel_item pull-right" ng-show="edit_general">
                            <a href="javascript:void(0);" ng-click="cancelEdit('general')">Anuluj</a>
                        </div>
                    </div>

                </div>


                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-group">
                                <label>Zaplacona</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_paid == '0'">Nie</span>
                                        <span class="form-span" ng-show=" ! edit_general && finances_id && finances_paid == '1'">Tak</span>
                                        <select class="form-control" ng-show="edit_general || ! finances_id" ng-model="finances_paid">
                                            <option value="0">Nie</option>
                                            <option value="1">Tak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-add" ng-click="saveProduct()">Zapisz</button>
                </div>



            </div>

        </div>

        <div class="col-sm-3">


            <div class="panel panel-bd lobidrag_task_manager">

                <div class="panel-heading">

                    <span></span>
                    <input type="text" class="form-control" placeholder="Введить назву" ng-model="name_task_block" name="name_task_block" required />
                    <br>
                    <button class="btn btn-primary" ng-click="name_task_block=true">add</button>
                    <button class="btn btn-danger" ng-click="name_task_block=false">X</button>
                    <task></task>

                </div>
            </div>
        </div>

        <div class="col-sm-3">


            <div class="panel panel-bd lobidrag">

                <div class="panel-heading">

                    <span></span>
                    <input type="text" class="form-control" placeholder="Введить назву" name="name_task_block" required />
                    <br>
                    <button class="btn btn-primary">add</button>
                    <button class="btn btn-danger">X</button>

                </div>
            </div>
        </div>

        


    <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-add" ng-click="saveProduct()">Zapisz</button>
    </div>
</div>


<script type="text/javacript">

    angular.module('app', []);

    angular.module('app').
        directive('task', function(){
            return {
                restrict: 'E',
                controller: function(){
                    this.user = {
                        name : 'Sasha',
                        year : '24',
                        email : 'itsaninho@gmail.com'
                    };
                },
                controllerAs:'task',
                templateUrl:'block_new_task.php',
                link: function(scope){
                    scope.users = [
                        {
                            name:'Sasha',
                            year:'24'
                        },
                        {
                            name:'Sasha1',
                            year:'23'
                        },
                        {
                            name:'Sasha2',
                            year:'22'
                        }
                    ];
                },
            }
        });


</script>









<script type="text/ng-template" id="SelectCustomer.html">
<div class="row" data-ng-controller="FinancesCtrl" ng-init="init()">
    <div class="row" data-ng-controller="FinancesCtrl" data-ng-init="initList()">
    <form class="no-transition" name="form" method="post" novalidate="novalidate">