<div class="page page-table" data-ng-controller="FinancesCtrl" data-ng-init="init()">
	<h2>
		<div class="pull-right">
    		<button type="button" class="btn btn-success" ng-click="add()"><i class="fa fa-plus-circle"></i> {{ __("Add New Record") }}</button>
    	</div>

		{{ __("Finances") }}
		<div class="btn-group" uib-dropdown ng-show="teams.length > 1">
			<button id="btn-append-to-single-button" type="button" class="btn btn-default" uib-dropdown-toggle>
				@{{ currentTeam.teams_name }} <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" uib-dropdown-menu role="menu" aria-labelledby="btn-append-to-single-button">
				<li role="menuitem" ng-repeat="t in teams" ng-class="{'active': t.teams_id == currentTeam.teams_id}"><a href="javascript:void(0);" ng-click="changeTeam(t.teams_id)">@{{ t.teams_name }}</a></li>
			</ul>
		</div>

		<span class="small">{{ __('Balance') }}: @{{ balance.toFixed(2) }} <span ng-bind-html="getCurrencySign(false, true)"></span>
	</h2>

	<div class="filter-box form-group form-inline">
		<select class="form-control pull-right" ng-model="filter.payer" ng-change="get()">
			<option value="">{{ __('All payers') }}</option>
			<option ng-repeat="(key, payer) in payers" value="@{{ payer }}" ng-bind="payer"></option>
		</select>

		<select class="form-control" ng-model="filter.type" ng-change="get()">
			<option ng-repeat="(key, type) in types_list" value="@{{ key }}" ng-bind="type"></option>
		</select>

		<select class="form-control" ng-model="filter.month" ng-show="filter.type == 0" ng-change="get()">
			<option ng-repeat="(key, month) in months_list" value="@{{ key }}" ng-bind="month"></option>
		</select>

		<select class="form-control" ng-model="filter.year" ng-show="filter.type <= 1" ng-change="get()">
			<option ng-repeat="year in getYearRange()" value="@{{ year }}" ng-bind="year"></option>
		</select>

		<div class="input-group" ng-show="filter.type == 2">
			<input type="text" class="form-control" name="from" uib-datepicker-popup="dd/MM/yyyy" ng-model="filter.from" is-open="from.opened" show-button-bar="false" datepicker-options="dateOptions" ng-change="get()" />
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="calendarOpen('from')"><i class="glyphicon glyphicon-calendar"></i></button>
			</span>
		</div>

		<div class="input-group" ng-show="filter.type == 2">
			<input type="text" class="form-control" name="to" uib-datepicker-popup="dd/MM/yyyy" ng-model="filter.to" is-open="to.opened" show-button-bar="false" datepicker-options="dateOptions" ng-change="get()" />
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="calendarOpen('to')"><i class="glyphicon glyphicon-calendar"></i></button>
			</span>
		</div>
	</div>

	<div uib-alert class="alert-info" ng-show=" ! pagesList.length">
		{{ __("You haven't any records yet. To add new finances record click on \"Add New Record\" button") }}
	</div>

    <section class="panel panel-default table-dynamic" ng-show="pagesList.length">
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
					<th class="td-id">
						<div class="th">
							{{ __("#ID") }}
						</div>
					</th>

					<th class="td-badge">
						<div class="th">
							{{ __("Date") }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('finances_date')"
								  data-ng-class="{active: row == 'finances_date'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-finances_date')"
								  data-ng-class="{active: row == '-finances_date'}"></span>
						</div>
					</th>

					<th class="td-amount">
						<div class="th">
							{{ __("Amount,") }} @{{ getCurrencyName(false, true) }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('finances_amount_uah')"
								  data-ng-class="{active: row == 'finances_amount_uah'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-finances_amount_uah')"
								  data-ng-class="{active: row == '-finances_amount_uah'}"></span>
						</div>
					</th>

					<th class="td-amount">
						<div class="th">
							{{ __("Amount") }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('finances_amount')"
								  data-ng-class="{active: row == 'finances_amount'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-finances_amount')"
								  data-ng-class="{active: row == '-finances_amount'}"></span>
						</div>
					</th>

					<th>
						<div class="th">
							{{ __("Payer") }}
							<span class="fa fa-angle-up"
								  data-ng-click="order('finaces_payer')"
								  data-ng-class="{active: row == 'finaces_payer'}"></span>
							<span class="fa fa-angle-down"
								  data-ng-click="order('-finaces_payer')"
								  data-ng-class="{active: row == '-finaces_payer'}"></span>
						</div>
					</th>

					<th>
						<div class="th">
							{{ __("Description") }}
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
                <tr ng-repeat="finance in pagesList">
					<td class="td-id">
						@{{ finance.finances_id }}
					</td>

					<td class="td-badge">
						@{{ toDate(finance.finances_date) | date:'dd MMM' }}
					</td>

                    <td class="td-amount">
                    	<div ng-class="{'text-danger': finance.finances_type == '0', 'text-success': finance.finances_type == '1'}">
                    		@{{ (finance.finances_type == '0' ? '-' : '+') + (finance.finances_amount_uah * 1).toFixed(2) }} <span ng-bind-html="getCurrencySign(false, true)"></span>
                    	</div>
                    </td>

                    <td class="td-amount">
                    	<div ng-class="{'text-danger': finance.finances_type == '0', 'text-success': finance.finances_type == '1'}">
                    		@{{ (finance.finances_type == '0' ? '-' : '+') + (finance.finances_amount * 1).toFixed(2) }} <span ng-bind-html="getCurrencySign(finance.currency_id)"></span> <span ng-show="finance.finances_course > 1">(@{{ (finance.finances_course * 1).toFixed(2) }})</span>
                    	</div>
                    </td>

                    <td>
                    	@{{ finance.finances_payer }}
                    </td>

                    <td>
                    	@{{ finance.finances_desc }}
                    </td>

                    <td class="td-button">
						<a href="javascript:void(0);" class="a-icon text-primary" ng-click="add(finance.finances_id)">
							<i class="fa fa-cog"></i>
						</a>
					</td>

                	<td class="td-button">
						<a href="javascript:void(0);" class="a-icon text-danger" ng-click="remove(finance.finances_id)">
							<i class="fa fa-trash"></i>
						</a>
					</td>
                </tr>
            </tbody>

            <tfoot>
            	<tr>
            		<td colspan="2" class="text-right">
            			<b>{{ __('Summary') }}:</b>
            		</td>

            		<td colspan="6">
            			<div ng-class="{'text-danger': summary.all < 0, 'text-success': summary.all > 0}">
            				<div class="pull-right">
            					<span class="text-success">@{{ summary.plus.toFixed(2) }} <span ng-bind-html="getCurrencySign(false, true)"></span></span>
            					/
            					<span class="text-danger">@{{ summary.minus.toFixed(2) }} <span ng-bind-html="getCurrencySign(false, true)"></span></span>
            				</div>
                    		@{{ summary.all.toFixed(2) }} <span ng-bind-html="getCurrencySign(false, true)"></span>
                    	</div>
            		</td>
            	</tr>
            </tfoot>
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

    <script type="text/ng-template" id="FinancesAdd.html">
    	<form name="form" method="post" novalidate="novalidate">
		    <div class="modal-header" ng-if=" ! view">
		        <h3 class="modal-title" ng-show=" ! finance.finances_id">{{ __("Add New Record") }}</h3>
		        <h3 class="modal-title" ng-show="finance.finances_id">{{ __("Edit Existing Record") }}</h3>
		    </div>

		    <div class="modal-body">
		    	<div class="row">
		    		<div class="col-sm-6 col-xs-12">
		    			<div class="form-group">
			    			<label>{{ __("Amount") }}</label>

					    	<div class="input-group">
								<input type="number" class="form-control" name="finances_amount" ng-model="finance.finances_amount" required="required" />

								<div class="input-group-btn" uib-dropdown>
									<button type="button" class="btn btn-default dropdown-toggle" uib-dropdown-toggle><span ng-bind-html="currentCurrecy().currency_sign"></span> (@{{ currentCurrecy().currency_name }}) <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right" uib-dropdown-menu>
										<li ng-repeat="c in currency | orderBy:'currency_name'" ng-class="{'active': c.currency_id == finance.currency_id}"><a href="javascript:void(0);" ng-click="setCurrency(c.currency_id)"><span ng-bind-html="c.currency_sign"></span> (@{{ c.currency_name }})</a></li>
									</ul>
								</div>
							</div>
						</div>
				    </div>

				    <div class="col-sm-6 col-xs-12">
				    	<div class="form-group">
							<label>{{ __("Type") }}</label>
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="button" class="btn" ng-class="{'btn-default': finance.finances_type == '0', 'btn-success': finance.finances_type == '1'}" ng-click="setType(1)">{{ __("In") }}</button>
								</div>

								<div class="btn-group" role="group">
									<button type="button" class="btn" ng-class="{'btn-default': finance.finances_type == '1', 'btn-danger': finance.finances_type == '0'}" ng-click="setType(0)">{{ __("Out") }}</button>
								</div>
							</div>
				    	</div>
				    </div>

				    <div class="col-sm-6 col-xs-12">
		    			<div class="form-group">
			    			<label>{{ __("Date") }}</label>

					    	<div class="input-group">
								<input type="text" class="form-control" name="finances_date" uib-datepicker-popup="dd/MM/yyyy" ng-model="dt" is-open="calendar.opened" show-button-bar="false" datepicker-options="dateOptions" required="required" />
								<span class="input-group-btn">
									<button type="button" class="btn btn-default" ng-click="calendarOpen()"><i class="glyphicon glyphicon-calendar"></i></button>
								</span>
							</div>
						</div>
				    </div>

				    <div class="col-sm-6 col-xs-12">
		    			<div class="form-group">
			    			<label>{{ __("Payer") }}</label>

							<input type="text" class="form-control" name="finances_payer" autocomplete="off" ng-model="finance.finances_payer" typeahead-show-hint="true" uib-typeahead="p for p in payers | filter:$viewValue | limitTo:8" typeahead-min-length="0" required="required" />
						</div>
				    </div>

				    <div class="col-xs-12">
		    			<div class="form-group">
			    			<label>{{ __("Description") }}</label>

			    			<div class="form-group">
								<textarea class="form-control" name="finances_desc" ng-model="finance.finances_desc" required="required"></textarea>
							</div>

							<button class="btn btn-default btn-descs" ng-repeat="d in descs" ng-click="finance.finances_desc = d">@{{ d }}</button>
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