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
        <link rel="stylesheet" href="/css/app_old.css" />
    </head>

    <body data-ng-app="app" class="hold-transition sidebar-mini" data-ng-controller="AppCtrl" data-ng-init="token('{{ csrf_token() }}')">
        <section class="content auth-content" data-ng-view>
        </section>

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
    </body>
</html>

