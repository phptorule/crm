<div class="login-wrapper accept_page" ng-controller="AuthCtrl" ng-init="getInvite()">
    <!--div class="back-link">
        <a href="/" class="btn btn-add">Back to Dashboard</a>
    </div-->

    <div class="signin-header">
        <section class="logo text-center">
            <div class="wrap-logo">
                <a href="/">
                    <img src="/img/logo.png" alt="CRM" />
                </a>
            </div>
        </section>

        <div uib-alert class="alert-info text-center" ng-show="inviteAlert != ''">
			@{{ inviteAlert }}
  		</div>
    </div>

    <div class="container-center">
        <div class="login-area">
            <div class="panel panel-bd panel-custom">
                <div class="panel-heading">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe-7s-add-user"></i>
                        </div>

                        <div class="header-title">
                            <h3>Join to the @{{ teams_name }} team</h3>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <form id="loginForm" name="form" method="post" novalidate="novalidate">
                        <fieldset>
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

							<div class="form-group form-group_margin">
								<button type="submit"
										class="btn btn-success btn-lg btn-block text-center"
										ng-click="confirm()">{{ __('Confirm Invitation') }}
								</button>
							</div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>