<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Панель управления</title>
    <!-- ... -->
    <!-- 1. Подключить библиотеку jQuery -->
    <script type="text/javascript" src="/admin_src/js/jquery-1.12.4.min.js"></script>
    <!-- 2. Подключить скрипт moment-with-locales.min.js для работы с датами -->
    <script type="text/javascript" src="/admin_src/js/moment-with-locales.min.js"></script>
    <!-- 3. Подключить скрипт платформы Twitter Bootstrap 3 -->
    <script type="text/javascript" src="/admin_src/js/bootstrap.min.js"></script>
    <!-- 4. Подключить скрипт виджета "Bootstrap datetimepicker" -->
    <script type="text/javascript" src="/admin_src/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/admin_src/js/alertify.min.js"></script>

    <!-- 5. Подключить CSS платформы Twitter Bootstrap 3 -->
    <link rel="stylesheet" href="/admin_src/style/bootstrap.min.css"/>
    <!-- 6. Подключить CSS виджета "Bootstrap datetimepicker" -->
    <link rel="stylesheet" href="/admin_src/style/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="/admin_src/style/alertify.core.css"/>
    <link rel="stylesheet" href="/admin_src/style/alertify.default.css"/>


    <!-- Custom styles for this template -->
    <link href="/admin_src/style/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Панель управления</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown"><?= $this->userName; ?> <b
                                class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/logout">Выйти</a></li>




                    </ul>
                </li>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</div>