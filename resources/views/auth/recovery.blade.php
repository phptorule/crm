<div class="page-forgot" ng-controller="AuthCtrl">

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
                    <div class="panel panel-default">
                        <div class="form-container">
                            <div class="additional-info text-center">
                                <p class="text-small">{{ __("Enter your email address that you used to register. We'll send you an email with your username and a link to reset your password.") }}</p>
                            </div>
                            <div class="form-container text-center">
                                <form class="form-horizontal" name="form" method="post" novalidate="novalidate">
                                    <div class="form-group">
                                        <div class="input-group input-group-first">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                            </span>
                                            <input type="email"
                                                   class="form-control input-lg"
                                                   placeholder="{{ __('Email') }}"
                                                   ng-model="users_email"
                                                   required="required"
                                                   name = "users_email"
                                                   />
                                        </div>
                                    </div>
                                    <div class="form-group form-group_margin">
                                        <button type="submit"
                                                class="btn btn-success btn-lg btn-block text-center"
                                                ng-click="reset()">{{ __('Reset') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>