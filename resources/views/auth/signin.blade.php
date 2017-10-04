<div class="page-signin" ng-controller="AuthCtrl">
    <div class="signin-header">
        <section class="logo text-center">
			<div class="wrap-logo">
				<a href="/">
					<img src="/img/logo.png" alt="BugGira" />
				</a>
			</div>
        </section>
    </div>

    <div class="signin-body">
        <div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="email-send text-center" ng-show="visible" ng-model="visible">
					  	<div uib-alert ng-class="'alert-' + (alerts.type || 'info')">
					  		<p>
					  			{{ __("Your account isn't active. You should confirm your registration from the activation letter. If you didn't receive the letter you can resend it") }}
					  		</p>
					  		<button class="btn btn-info" ng-click="resend()">{{ __("Resend Confirmation Letter") }}</button>
				  		</div>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="form-container">
							<form class="form-horizontal" name="form" method="post" novalidate="novalidate">
								<fieldset>
									<div class="form-group">
										<div class="input-group input-group-first">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
											</span>
											<input 	type="email"
													name="users_email"
													class="form-control input-lg"
													placeholder="{{ __('Email') }}"
													ng-model="auth.users_email" 
													required="required"
												   />
										</div>
									</div>
									
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
											</span>
											<input type="password"
												   name="password"
												   class="form-control input-lg"
												   placeholder="{{ __('Password') }}"
												   ng-model="auth.password"
												   required="required"
												   />
										</div>
									</div>
									
									<div class="form-group form-group_margin">
										<button 
										   type="submit"
										   class="btn btn-success btn-lg btn-block text-center"
										   ng-click="signin()">{{ __('Sign in') }}</button>
									</div>
								</fieldset>
							</form>
							
							<section class="additional-info">
								<p class="text-right">
									<a href="/auth/recovery" class="additional-info_password">{{ __('Forgot your password?') }}</a>
								</p>
							</section>
						</div>
					</div>
				</div>
        	</div>
    	</div>
	</div>
</div>
					