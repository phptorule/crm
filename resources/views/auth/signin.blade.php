<div class="login-wrapper" ng-controller="AuthCtrl">
    <!--div class="back-link">
        <a href="/" class="btn btn-add">Back to Dashboard</a>
    </div-->

    <div class="container-center">
	    <div class="login-area">
	        <div class="panel panel-bd panel-custom">
	            <div class="panel-heading">
	                <div class="view-header">
	                    <div class="header-icon">
	                        <i class="pe-7s-unlock"></i>
	                    </div>

	                    <div class="header-title">
	                        <h3>Sign in</h3>
	                        <small><strong>Please enter your credentials to login.</strong></small>
	                    </div>
	                </div>
	            </div>

	            <div class="panel-body">
	                <form id="loginForm" name="form" method="post" novalidate="novalidate">
	                    <div class="form-group">
	                        <label class="control-label" for="users_email">Email</label>
	                        <input  type="email"
									name="users_email"
									class="form-control input-lg"
									placeholder="{{ __('Email') }}"
									ng-model="auth.users_email"
									required="required"
									class="form-control" />
	                        <span class="help-block small">Your unique username to app</span>
	                    </div>

	                    <div class="form-group">
	                        <label class="control-label" for="password">Password</label>
	                        <input type="password"
								   name="password"
								   class="form-control input-lg"
								   placeholder="{{ __('Password') }}"
								   ng-model="auth.password"
								   required="required"
								   class="form-control" />
	                        <span class="help-block small">Your strong password</span>
	                    </div>

	                    <div>
	                        <button type="submit" class="btn btn-add" ng-click="signin()">{{ __('Sign in') }}</button>
	                        <a href="/auth/signup/" class="btn btn-warning">Register</a>
	                    </div>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>