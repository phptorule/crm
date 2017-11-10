<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>crm</title>

        <link rel="shortcut icon" href="/img/ico/favicon.png" type="image/x-icon">
        <link href="/theme/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/lobipanel/lobipanel.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/pace/flash.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/icheck/skins/all.css" rel="stylesheet">
        <link href="/theme/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/monthly/monthly.css" rel="stylesheet" type="text/css"/>
        <link href="/css/app.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/NotificationStyles/css/ns-style-attached.css" rel="stylesheet" type="text/css" />
    </head>

    <body data-ng-app="app" class="hold-transition sidebar-mini" data-ng-controller="AppCtrl" data-ng-init="token('{{ csrf_token() }}')">
        <div id="preloader">
            <div id="status"></div>
        </div>

        <div class="wrapper">
            <header class="main-header" id="header">
                <a href="index.html" class="logo">
                    <span class="logo-mini" ng-show="false">
                        <img src="/img/mini-logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="/img/logo.jpg" alt="">
                    </span>
                </a>

                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-angle-left-circle"></span>
                    </a>

                    <a href="#search"><span class="pe-7s-search"></span></a>
                    <div id="search">
                        <button type="button" class="close">×</button>

                        <form>
                            <input type="search" value="" placeholder="Search.." />
                            <button type="submit" class="btn btn-add">Szukaj...</button>
                        </form>
                    </div>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="nav-username">
                                <span class="hidden-xs">
                                    <span>@{{ user.users_first_name + ' ' + user.users_last_name}}</span><span ng-show="current_team"> (@{{ current_team.teams_name }})</span>
                                </span>
                            </li>
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/img/avatar5.png" class="img-circle" width="45" height="45" alt="user">
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="profile.html"><i class="fa fa-user"></i> User Profile</a></li>
                                    <li><a href="/teams/list"><i class="fa fa-users"></i> Teams</a></li>
                                    <li><a href="javascript:void(0);" ng-click="signout()"><i class="fa fa-sign-out"></i> Signout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li ng-class="{'active': activeSidebar()}">
                            <a href="/">
                                <i class="fa fa-tachometer"></i>
                                <span>{{ __("Dashbaord") }}</span>
                            </a>
                        </li>

                        <!--li ng-class="{'active': activeSidebar('teams')}">
                            <a href="/teams/list">
                                <i class="fa fa-users"></i>
                                <span>{{ __("Teams") }}</span>
                            </a>
                        </li-->

                        <li class="nav-title" ng-show="sidebar.plugins.length">
                            <span>{{ __("Plugins") }}</span>
                        </li>

                        <li class="treeview" ng-show="sidebar.plugins.indexOf('Customers') != -1">
                            <a href="javascript:void(0)">
                                <i class="fa fa-cogs"></i>
                                <span>Kontrahent</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/customers/add" ng-class="getClass('/customers/add/')">Utwórz Kontrahenta</a></li>
                                <li><a href="/customers/list" ng-class="getClass('/customers/list/')">Lista kontrahentów</a></li>
                            </ul>
                        </li>

                        <li class="treeview" ng-show="sidebar.plugins.indexOf('Finances') != -1">
                            <a href="javascript:void(0)">
                                <i class="fa fa-cogs"></i>
                                <span>Finanse</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/finances/add" ng-class="getClass('/finances/add/')">Wystaw fakturę</a></li>
                                <li><a href="/finances/list" ng-class="getClass('/finances/list/')">Wystawione faktury</a></li>
                                <li class="menu_line"></li>
                                <li><a href="/finances/register" ng-class="getClass('/finances/register/')">Zarejestruj fakturę</a></li>
                                <li><a href="/finances/registered_list" ng-class="getClass('/finances/registered_list/')">Zarejestrowane faktury</a></li>
                            </ul>
                        </li>

                        <li class="treeview no-treeview" ng-show="sidebar.plugins.indexOf('Task Manager') != -1">
                            <a href="/task_manager/desk">
                                <i class="fa fa-cogs"></i>
                                <span>Task Manager</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="@{{ Page.icon() }}"></i>
                    </div>

                    <div class="header-title">
                        <h1>@{{ Page.title() }}</h1>
                    </div>
                </section>

                <section class="content" id="content" data-ng-view>
                </section>
            </div>

            <footer class="main-footer">
                <strong>Copyright &copy; 2016-2017 <a href="#">Thememinister</a>.</strong> All rights reserved.
            </footer>
        </div>

        <script src="/js/vendor.js"></script>
        <script data-require="angular-ui-bootstrap@0.3.0" data-semver="0.3.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.3.0.min.js"></script>
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
        <script src="/js/controllers/customers.js"></script>
        <script src="/theme/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="/theme/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/tableExport.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/jquery.base64.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/html2canvas.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/sprintf.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/jspdf.js" type="text/javascript"></script>
        <script src="/theme/plugins/table-export/base64.js" type="text/javascript"></script>
        <script src="/theme/plugins/datatables/dataTables.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/counterup/waypoints.js" type="text/javascript"></script>
        <script src="/theme/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/monthly/monthly.js" type="text/javascript"></script>
        <script src="/theme/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <script src="/js/custom.js" type="text/javascript"></script>
        <script src="/js/dashboard.js" type="text/javascript"></script>
    </body>
</html>

