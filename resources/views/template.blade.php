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
        <link href="/theme/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/themify-icons/themify-icons.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/emojionearea/emojionearea.min.css" rel="stylesheet" type="text/css"/>
        <link href="/theme/plugins/monthly/monthly.css" rel="stylesheet" type="text/css"/>
        <link href="/css/app.css" rel="stylesheet" type="text/css"/>
        <link href="/css/app_old.css" rel="stylesheet" />
        <link href="/theme/plugins/NotificationStyles/css/ns-style-attached.css" rel="stylesheet" type="text/css" />
    </head>

    <body data-ng-app="app" class="hold-transition sidebar-mini" data-ng-class="[{'nav-collapsed-min': admin.menu === 'collapsed'}, body_class]" data-ng-controller="AppCtrl" data-ng-init="token('{{ csrf_token() }}')" data-custom-page>
        <div id="preloader">
            <div id="status"></div>
        </div>

        <div class="wrapper">
            <header class="main-header" id="header">
                <a href="index.html" class="logo">
                    <span class="logo-mini">
                        <img src="/img/mini-logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="/img/logo.png" alt="">
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
                            <button type="submit" class="btn btn-add">Search...</button>
                        </form>
                    </div>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/img/avatar5.png" class="img-circle" width="45" height="45" alt="user">
                                </a>

                                <ul class="dropdown-menu" >
                                    <li><a href="profile.html"><i class="fa fa-user"></i> User Profile</a></li>
                                    <li><a href="#"><i class="fa fa-inbox"></i> Inbox</a></li>
                                    <li><a href="javascript:void(0);" ng-click="signout()"><i class="fa fa-sign-out"></i> Signout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar" >
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-dashboard"></i>
                    </div>

                    <div class="header-title">
                        <h1>CRM Admin Dashboard</h1>
                        <small>Very detailed & featured admin.</small>
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
        <script src="/theme/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="/theme/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/lobipanel/lobipanel.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/counterup/waypoints.js" type="text/javascript"></script>
        <script src="/theme/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="/theme/plugins/monthly/monthly.js" type="text/javascript"></script>
        <script src="/js/custom.js" type="text/javascript"></script>
        <script src="/js/dashboard.js" type="text/javascript"></script>
        <script src="/theme/plugins/NotificationStyles/js/notificationFx.js" type="text/javascript"></script>

        <!--<script>
            function dash() {
            // single bar chart
            var ctx = document.getElementById("singelBarChart");
            var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
            datasets: [
            {
            label: "My First dataset",
            data: [40, 55, 75, 81, 56, 55, 40],
            borderColor: "rgba(0, 150, 136, 0.8)",
            width: "1",
            borderWidth: "0",
            backgroundColor: "rgba(0, 150, 136, 0.8)"
            }
            ]
            },
            options: {
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
            }
            }
            });
                  //monthly calender
                  $('#m_calendar').monthly({
                    mode: 'event',
                    //jsonUrl: 'events.json',
                    //dataType: 'json'
                    xmlUrl: 'events.xml'
                });

            //bar chart
            var ctx = document.getElementById("barChart");
            var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "august", "september","october", "Nobemver", "December"],
            datasets: [
            {
            label: "My First dataset",
            data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
            borderColor: "rgba(0, 150, 136, 0.8)",
            width: "1",
            borderWidth: "0",
            backgroundColor: "rgba(0, 150, 136, 0.8)"
            },
            {
            label: "My Second dataset",
            data: [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86],
            borderColor: "rgba(51, 51, 51, 0.55)",
            width: "1",
            borderWidth: "0",
            backgroundColor: "rgba(51, 51, 51, 0.55)"
            }
            ]
            },
            options: {
            scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
            }
            }
            });
                //counter
                $('.count-number').counterUp({
                    delay: 10,
                    time: 5000
                });
            }
            dash();
        </script>-->
    </body>
</html>

