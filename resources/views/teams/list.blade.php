<div class="page page-table" data-ng-controller="TeamsCtrl" data-ng-init="get()">
	<h2>
		<div class="pull-right">
			<button type="button" class="btn btn-default" ng-click="switchTeam()">Switch team</button>
    		<button type="button" class="btn btn-success" ng-click="create()"><i class="fa fa-plus-circle"></i> {{ __("Create Own Team") }}</button>
    	</div>

		{{ __("Teams") }}
	</h2>

	<div uib-alert class="alert-info" ng-show=" ! pagesList.length">
		{{ __("You haven't any team yet. To create own team click on \"Create Own Team\" button") }}
	</div>

    <section class="panel panel-default table-dynamic" ng-show="pagesList.length">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr class="info">
					<th class="td-id">
						<div class="th">
							{{ __("#ID") }}
						</div>
					</th>

					<th class="td-badge">
						<div class="th">
							{{ __("Leader") }}
						</div>
					</th>

					<th>
						<div class="th">
							{{ __("Name") }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('teams_name')"
								  data-ng-class="{active: row == 'teams_name'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-teams_name')"
								  data-ng-class="{active: row == '-teams_name'}"></span>
						</div>
					</th>

					<th>
						<div class="th">
							{{ __("Members") }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('teams_members')"
								  data-ng-class="{active: row == 'teams_members'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-teams_members')"
								  data-ng-class="{active: row == '-teams_members'}"></span>
						</div>
					</th>

					<th>
						<div class="th">
						</div>
					</th>

                    <th>
						<div class="th">
						</div>
					</th>

					<th>
						<div class="th">
						</div>
					</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="team in pagesList">
					<td class="td-id">
						@{{team.teams_id}}
					</td>

					<td class="td-badge">
						<span class="span-badge" ng-show="team.pivot.teams_leader == '1'"><i class="fa fa-trophy text-gold"></i></span>
					</td>

                    <td>@{{team.teams_name}}</td>

                    <td>@{{team.users.length}}</td>

                    <td class="td-button">
						<a href="javascript:void(0);" ng-if="team.pivot.teams_leader == '1' && team.pivot.teams_approved == '1'" class="a-icon text-success" ng-click="plugins(team.teams_id)">
							<i class="fa fa-plug"></i>
						</a>
					</td>

                    <td class="td-button">
						<a href="javascript:void(0);" ng-if="team.pivot.teams_leader == '1' && team.pivot.teams_approved == '1'" class="a-icon text-primary" ng-click="create(team.teams_id)">
							<i class="fa fa-cog"></i>
						</a>

						<a href="javascript:void(0);" ng-if="team.pivot.teams_leader == '0' && team.pivot.teams_approved == '1'" class="a-icon text-primary" ng-click="create(team.teams_id, true)">
							<i class="fa fa-eye"></i>
						</a>

						<a href="javascript:void(0);" ng-if="team.pivot.teams_approved == '0'" class="a-icon text-success" ng-click="approve(team.teams_id)">
							<i class="fa fa-check"></i>
						</a>
					</td>

                	<td class="td-button">
						<a href="javascript:void(0);" ng-if="team.pivot.teams_leader == '1' && team.pivot.teams_approved == '1'" class="a-icon text-danger" ng-click="remove(team.teams_id)">
							<i class="fa fa-trash"></i>
						</a>

						<a href="javascript:void(0);" ng-if="team.pivot.teams_leader == '0' && team.pivot.teams_approved == '1'" class="a-icon text-danger" ng-click="leave(team.teams_id)">
							<i class="fa fa-sign-out"></i>
						</a>

						<a href="javascript:void(0);" ng-if="team.pivot.teams_approved == '0'" class="a-icon text-danger" ng-click="decline(team.teams_id)">
							<i class="fa fa-times"></i>
						</a>
					</td>
                </tr>
            </tbody>
        </table>

        <footer class="table-footer" ng-show="false">
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-right pagination-container">
                    <pagination class="pagination-sm"
                                ng-model="currentPage"
                                total-items="filteredStores.length"
                                max-size="4"
                                ng-change="changePage(currentPage)"
                                items-per-page="numPerPage"
                                rotate="false"
                                previous-text="&lsaquo;" next-text="&rsaquo;"
                                boundary-links="true"></pagination>
                </div>
            </div>
        </footer>
    </section>

    <script type="text/ng-template" id="TeamsCreate.html">
    	<form name="form" method="post" novalidate="novalidate">
		    <div class="modal-header" ng-if=" ! view">
		        <h3 class="modal-title" ng-show=" ! team.teams_id">{{ __("Create Own Team") }}</h3>
		        <h3 class="modal-title" ng-show="team.teams_id">{{ __("Edit Own Team") }}</h3>
		    </div>

		    <div class="modal-header" ng-if="view">
		        <h3 class="modal-title">@{{ team.teams_name }}</h3>
		    </div>

		    <div class="modal-body">
		    	<div class="form-group" ng-if=" ! view">
					<label>{{ __("Name") }}</label>
					<input type="text" class="form-control" name="teams_name" ng-model="team.teams_name" required="required" />
		    	</div>

		    	<div class="form-group" ng-show=" ! view">
			    	<label>{{ __("Members") }}</label>
			    	<div class="input-group">
						<input type="email" name="email" class="form-control" ng-model="email" placeholder="{{ __('To invite other user just input his email here') }}" />
						<span class="input-group-btn">
							<button class="btn btn-primary" type="button" ng-click="addMember()">{{ __('Invite') }}</button>
						</span>
					</div>
		    	</div>

		    	<div class="teams-members">
		    		<table class="table table-striped table-responsive">
		    			<thead>
		    				<tr>
		    					<th class="td-button">{{ __('Status') }}</th>
		    					<th>{{ __('User') }}</th>
		    					<th class="td-switch">{{ __('Admin') }}</th>
		    					<th class="td-button" ng-if=" ! view"></th>
		    				</tr>
		    			</thead>

		    			<tbody>
		    				<tr ng-repeat="member in members" ng-if=" ! member.removed">
		    					<td class="td-button">
		    						<i class="fa fa-check-circle text-success span-badge" uib-tooltip="{{ __('User accepted your invite') }}" ng-show="member.pivot.teams_invite == '1' && member.pivot.teams_approved == '1'"></i>
		    						<i class="fa fa-clock-o text-default span-badge" uib-tooltip="{{ __('User didn\'t accept your invite yet') }}" ng-show="member.pivot.teams_invite == '1' && member.pivot.teams_approved == '0'"></i>
		    						<i class="fa fa-envelope-o text-primary span-badge" uib-tooltip="{{ __('New user in your team') }}" ng-show="! member.pivot.teams_invite || member.pivot.teams_invite == '0'"></i>
		    					</td>

		    					<td>
		    						<span class="members-avatar">
		    							<i class="fa fa-user-circle" ng-show=" ! member.users_avatar || member.users_avatar == ''"></i>
		    							<img src="@{{ member.users_avatar }}" alt="" ng-show="member.users_avatar && member.users_avatar != ''" class="img-circle img30_30" />
		    						</span>
		    						@{{ member.users_name || member.users_email }}
		    					</td>

		    					<td class="td-switch">
		    						<label class="ui-switch" ng-if=" ! view">
		    							<input type="checkbox" ng-model="member.pivot.teams_leader" ng-checked="member.pivot.teams_leader == '1'" ng-true-value="1" ng-false-value="0" ng-disabled="member.users_id && user.users_id == member.users_id" />
		    							<i></i>
		    						</label>

		    						<span class="span-badge" ng-if="view && member.pivot.teams_leader == '1'"><i class="fa fa-trophy text-gold"></i></span>
		    					</td>

		    					<td class="td-button" ng-if=" ! view">
		    						<a href="javascript:void(0);" ng-if="member.users_id && user.users_id != member.users_id" ng-click="removeMember(member.users_id)" class="a-icon text-danger">
										<i class="fa fa-trash"></i>
									</a>
		    					</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    	</div>
		    </div>

		    <div class="modal-footer">
		    	<div ng-class="{'btn-load': request_sent}">
			    	<div class="loading-text">
						<button type="submit" class="btn btn-primary" ng-click="save()" ng-if=" ! view">{{ __('Save') }}</button>
						<button type="button" class="btn btn-default" ng-click="cancel()" ng-if=" ! view">{{ __('Cancel') }}</button>
					</div>
					<button type="button" class="btn btn-default" ng-click="cancel()" ng-if="view">{{ __('Close') }}</button>
					<i class="fa fa-spinner fa-pulse fa-3x fa-fw loading-icon"></i>
			    </div>
		    </div>
		</form>
	</script>

	<script type="text/ng-template" id="TeamsPlugins.html">
    	<form name="form" method="post" novalidate="novalidate">
		    <div class="modal-header">
		        <h3 class="modal-title">{{ __("Plugins List") }}</h3>
		    </div>

		    <div class="modal-body">
		    	<div class="teams-members">
		    		<table class="table table-striped table-responsive">
		    			<thead>
		    				<tr>
		    					<th>{{ __('Name') }}</th>
		    					<th class="td-switch">{{ __('Active') }}</th>
		    				</tr>
		    			</thead>

		    			<tbody>
		    				<tr ng-repeat="plugin in plugins">
		    					<td>
		    						@{{ plugin.plugins_name }}
		    					</td>

		    					<td class="td-switch">
		    						<label class="ui-switch">
		    							<input type="checkbox" ng-model="plugins_list[plugin.plugins_id]" ng-checked="plugins_list[plugin.plugins_id] == '1'" ng-change="setPlugin(plugin.plugins_id)" ng-true-value="1" ng-false-value="0" />
		    							<i></i>
		    						</label>
		    					</td>
		    				</tr>
		    			</tbody>
		    		</table>
		    	</div>
		    </div>

		    <div class="modal-footer">
				<button type="button" class="btn btn-default" ng-click="cancel()">{{ __('Close') }}</button>
		    </div>
		</form>
	</script>

	<script type="text/ng-template" id="SwitchTeam.html">
        <form name="form" method="post" novalidate="novalidate">
            <div class="modal-header" ng-if=" ! view">
                <h3 class="modal-title">{{ __("Switch your team") }}</h3>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>{{ __("Choose team") }}</label>
                            <select class="form-control" name="user_teams" ng-model="current_team" required="required">
                                <option value="0" disabled="disabled">Choose your team</option>
                                <option ng-repeat="team in teams" value="@{{ team.teams_id }}">@{{ team.teams_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" ng-click="save()">{{ __('Save') }}</button>
                <button type="button" class="btn btn-default" ng-click="cancel()">{{ __('Cancel') }}</button>
            </div>
        </form>
    </script>
</div>