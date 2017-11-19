<script>
    document.getElementById('link_add').onclick = function() {
        document.getElementById('link_add').style.display = 'none';
    }
</script>

<div class="row" data-ng-controller="Task_managerCtrl" ng-init="getTask()">
   
    <form class="no-transition" name="form" method="post" novalidate="novalidate">

        
        <div class="col-sm-4" ng-repeat="(k,task) in tasks">
            <div class="panel panel-bd lobidrag_task_manager">
                <div class="panel-heading">
                    <p>task_block: @{{tasks[k].name}} <button class="btn-danger pull-right" ng-click="deleteTask(task.id)">X</button></p>
                    <hr>
                    <p ng-repeat="card in cards[k]" class="card_title"><a href="" ng-click="selectCard(card.id)">@{{card.name}}</a></p>
                       
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
            </div>
        </div>

    </form>
</div>


<script type="text/ng-template" id="SelectCard.html">
    <div class="modal-header modal-header-primary" ng-init="getCard()">
       <button type="button" class="close" ng-click="cancel()" aria-hidden="true">×</button>
       <h3>Card name: <input type="text" ng-model="card.name"></h3>
    </div>


        


   <div class="modal-body">
       <div class="row">
            <div class="col-md-12">
                <div class="modal_content_header">
                    <form>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <p>Users</p>
                                    <span></span><span style="padding:5px 10px; cursor:pointer; border-radius:5px; border:1px solid grey; background:#dedcdc;">+</span>
                                </div>
                                <div class="form-group">
                                    <p ng-show="description=true" ng-click="description_textarea=!description_textarea">@{{card.description}}</p>
                                    <textarea rows="5" class="form-control" ng-show="description_textarea" ng-model="card.description"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" ng-click="saveCard(); description=true; description_textarea=false;">Save</button>
                                    <button class="btn btn-danger" ng-If="card.description.length > 1">Cancel</button>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-center">Add</p>
                                <p style="padding:5px; cursor:pointer; border-radius:5px; border:1px solid grey; background:#dedcdc;"><i class="fa fa-user m-r-5"></i>Users</p>
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
      <button type="button" class="btn btn-danger pull-right" ng-click="cancel()">Cancel</button>
   </div>




    

</script>