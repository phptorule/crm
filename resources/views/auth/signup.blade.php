<div class="page-signup" ng-controller="AuthCtrl">
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
													/>
										</div>
									</div>
									 <div class="form-group">
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
												ng-click="signup()">{{ __('Sign up') }}
										</button>
									</div>
								</form>
							</section>
							<section class="additional-info">
								<p class="text-right">
									<a href="/" class="additional-info_password">{{ __('Sign in') }}</a>
								</p>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>