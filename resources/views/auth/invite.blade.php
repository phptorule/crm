<div class="page-signup" ng-controller="AuthCtrl" ng-init="getInvite()">
    <div class="signup-header">
        <section class="logo text-center">
			<div class="wrap-logo">
				<a href="/">
					<img src="/img/logo.png" alt="BugGira" />
				</a>
			</div>
        </section>
    </div>

    <div class="signup-body">
        <div class="container">
			<div class="row">
				<div class="col-md-12">
					<div uib-alert class="alert-info text-center" ng-show="inviteAlert != ''">
						@{{ inviteAlert }}
			  		</div>

					<div class="panel panel-default">
						<div class="form-container">
							<section>
								<form class="form-horizontal" name="form" method="post" novalidate="novalidate">
									<div class="form-group  input-group-first">
										<div class="input-group ">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
											</span>
											<input  type="email"
													class="form-control input-lg"
													placeholder="{{ __('Email') }}"
													ng-model="auth.users_email"
													required="required"
													name="users_email"
													readonly="readonly"
													/>
										</div>
									</div>

									<div class="form-group" ng-show="invite.users_active == '0'">
										<div class="input-group ">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
											</span>
											<input  type="password"
													class="form-control input-lg"
													placeholder="{{ __('Password') }}"
													ng-model="auth.password"
													required="required"
													name="password"
													/>
										</div>
									</div>

									<div class="form-group">
										<div class="input-group ">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
											</span>
											<input  type="text"
													class="form-control input-lg"
													placeholder="{{ __('Username') }}"
													ng-model="auth.users_name"
													required="required"
													name="users_name"
													/>
										</div>
									</div>

									<div class="form-group form-group_margin">
										<button type="submit"
												class="btn btn-success btn-lg btn-block text-center"
												ng-click="confirm()">{{ __('Confirm Invitation') }}
										</button>
									</div>
								</form>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>