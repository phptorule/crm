<div class="page" data-ng-controller="UsersCtrl">
	<h2>{{ __("Profile") }}</h2>

    <section class="panel panel-default table-dynamic">
        <div class="panel-body">
        	<input type="file" ngf-select ng-model="profile.file" ngf-pattern="'image/*'" ngf-accept="'image/*'" ngf-max-size="20MB" ngf-resize="{width: 100, height: 100}" />
			<a href="javascript:void(0);" class="btn btn-primary" ng-click="saveProfile()">{{ __("Save") }}</a>
        </div>
	</section>
</div>