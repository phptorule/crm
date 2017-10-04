<!doctype html>
<html class="no-js">
    <head>
        <title>BugGira - Project Manager</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="BugGira - Project Manager" />
        <meta name="keywords" content="buggira project manager" />
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,400,600,300,700" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="/img/icon.png" type="image/png">
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/css/main.css" />
        <link rel="stylesheet" href="/css/app.css" />
    </head>

    <body data-ng-app="app" id="app" class="app" data-custom-page class="layout-boxed" data-ng-class="[{'nav-collapsed-min': admin.menu === 'collapsed'}, body_class]" data-ng-controller="AppCtrl" data-ng-init="token('{{ csrf_token() }}')">
        <header class="header-container header-fixed bg-white" id="header">
            <div class="top-header clearfix">
                <div class="logo" data-ng-class="{ 'toggleOn': open == 1, 'toggleOff': open == 0 }">
                    <a href="/">
                        <img src="/img/logo-white.png" class="big-img" alt="BugGira" />
                        <img src="/img/logo-white-mini.png" class="small-img" alt="BugGira" />
                    </a>
                </div>

                <div class="top-nav" data-ng-class="{ 'toggleOn': open == 1, 'toggleOff': open == 0 }">
                    <ul class="nav-left list-unstyled">
                        <li>
                            <a href="javascript:void(0);" data-ng-click="openSidebar()">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav-right pull-right list-unstyled">
                        <li class="dropdown text-normal nav-profile" uib-dropdown>
                            <a href="javascript:void(0);" class="dropdown-toggle" uib-dropdown-toggle>
                                <img ng-show="user.users_avatar != ''" src="@{{ user.users_avatar }}" alt="@{{ user.users_name }}" class="img-circle img30_30" />
                                <i class="fa fa-user-circle" aria-hidden="true" ng-show="user.users_avatar == ''"></i>
                                <span class="hidden-xs">
                                    <span>@{{ user.users_name }}</span>
                                </span>
                            </a>

                            <ul class="dropdown-menu with-arrow pull-right" uib-dropdown-menu>
                                <li>
                                    <a href="/users/profile">
                                        <i class="ti-user"></i>
                                        <span>{{ __('My Profile') }}</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:void(0);" ng-click="signout()">
                                        <i class="ti-export"></i>
                                        <span>{{ __('Sign out') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <div class="main-container">
            <aside id="nav-container" class="nav-container bg-dark nav-vertical nav-fixed sidebar" data-ng-class="{ 'toggleOn': open == 1, 'toggleOff': open == 0 }">
                <div class="nav-wrapper">
                    <ul id="nav" class="nav" data-slim-scroll data-highlight-active>
                        <li class="nav-title">
                            <span>{{ __("Navigation") }}</span>
                        </li>

                        <li ng-class="{'active': activeSidebar()}">
                            <a href="/">
                                <i class="fa fa-tachometer"></i>
                                <span>{{ __("Dashbaord") }}</span>
                            </a>
                        </li>

                        <li ng-class="{'active': activeSidebar('teams')}">
                            <a href="/teams/list">
                                <i class="fa fa-users"></i>
                                <span>{{ __("Teams") }}</span>
                            </a>
                        </li>

                        <li class="nav-title" ng-show="sidebar.plugins.length">
                            <span>{{ __("Plugins") }}</span>
                        </li>

                        <li ng-repeat="plugin in sidebar.plugins | orderBy:'plugins_name'">
                            <a href="/@{{ plugin.plugins_code.toLowerCase() }}/list">
                                <i class="@{{ plugin.plugins_icon }}"></i>
                                <span>@{{ plugin.plugins_name }}</span>
                            </a>

                            <ul>
                                <li ng-repeat="plugin in sidebar.plugins | orderBy:'plugins_name'">
                                    <a href="/@{{ plugin.plugins_code.toLowerCase() }}/list">
                                        <i class="fa fa-chevron-right"></i>
                                        <span>@{{ plugin.plugins_name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <div id="content" class="content-container" data-ng-class="{ 'toggleOn': open == 1, 'toggleOff': open == 0 }">
                <section data-ng-view class="view-container">
                </section>
            </div>

            <footer id="footer" class="app-footer" data-ng-class="{ 'toggleOn': open == 1, 'toggleOff': open == 0 }">
                <span class="pull-right">BugGira</span>
                Copyright {{ date('Y') }}
            </footer>
        </div>

        <script src="/js/vendor.js"></script>
        <script src="/js/ui.js"></script>
        <script src="/js/libs/ng-file-upload.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/factories/logger.js"></script>
        <script src="/js/factories/request.js"></script>
        <script src="/js/factories/validate.js"></script>
        <script src="/js/factories/langs.js"></script>
        <script src="/js/helpers/plugins.js"></script>
        <script src="/js/controllers/auth.js"></script>
        <script src="/js/controllers/teams.js"></script>
        <script src="/js/controllers/users.js"></script>
        <script src="/js/controllers/finances.js"></script>
    </body>
</html>