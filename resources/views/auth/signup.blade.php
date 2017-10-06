<div class="login-wrapper" ng-controller="AuthCtrl">
    <!--div class="back-link">
        <a href="/" class="btn btn-add">Back to Dashboard</a>
    </div-->

    <div class="container-center lg">
	    <div class="login-area">
	        <div class="panel panel-bd panel-custom">
	            <div class="panel-heading">
	                <div class="view-header">
	                    <div class="header-icon">
	                        <i class="pe-7s-unlock"></i>
	                    </div>

	                    <div class="header-title">
	                        <h3>Register</h3>
	                        <small><strong>Please enter your data to register.</strong></small>
	                    </div>
	                </div>
	            </div>

	            <div class="panel-body">
	                <form name="form" method="post" novalidate="novalidate">
	                    <div class="row">
	                        <div class="form-group col-lg-6">
	                            <label>Email Address</label>
	                            <input  class="form-control"
	                            		type="email"
										placeholder="{{ __('Email') }}"
										ng-model="auth.users_email"
										required="required"
										name="users_email" />
	                            <span class="help-block small">Your address email to contact</span>
	                        </div>

	                        <div class="form-group col-lg-6">
	                            <label>Password</label>
	                            <input  class="form-control"
	                           			type="password"
										class="form-control input-lg"
										placeholder="{{ __('Password') }}"
										ng-model="auth.password"
										required="required"
										name="password" />
	                            <span class="help-block small">Your hard to guess password</span>
	                        </div>

	                        <!--<div class="form-group col-lg-6">
	                            <label>Repeat Password</label>
	                            <input type="password" value="" id="repeatpassword" class="form-control" name="repeatpassword">
	                            <span class="help-block small">Please repeat your pasword</span>
	                        </div>-->
	                    </div>

	                    <div ng-class="{'btn-load': request_sent}">
		                    <div class="loading-text">
		                        <button type="submit"
										class="btn btn-warning"
										ng-click="signup()">{{ __('Register') }}
								</button>
		                        <a class="btn btn-add" href="/">Login</a>
		                    </div>
		                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw loading-icon"></i>
	                    </div>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>