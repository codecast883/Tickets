<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">


    <title>Войти</title>

    <!-- Bootstrap core CSS -->
    <link href="/style/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/style/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>

    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/jquery-1.12.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

</head>

<body>

<div class="container">

    <form class="form-signin" role="form" action="" method="post">

        <div class="form-group <?= $error[0]['login'] ?> has-feedback">
            <?= $error[1]['login'] ?>
            <input type="text" name="login" value="<?= $formData['login'] ?>" class="form-control " placeholder="Логин"
                   required autofocus>
        </div>

        <div class="form-group <?= $error[0]['email'] ?> has-feedback">
            <?= $error[1]['email'] ?>
            <input type="email" name="email" value="<?= $formData['email'] ?>" class="form-control" placeholder="Email" required>
        </div>

        <div class="form-group <?= $error[0]['password'] ?> has-feedback">
            <?= $error[1]['password'] ?>
            <input type="password" name="password" class="form-control" placeholder="Пароль" required>
        </div>

        <div class="form-group <?= $error[0]['passwordRetry'] ?> has-feedback">
            <?= $error[1]['passwordRetry'] ?>
            <input type="password" name="passwordRetry" class="form-control" placeholder="Повторите пароль" required>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Регистрация</button>
        <a class="btn btn-lg btn-success btn-block btn-enter" href="/admin">Вход</a>
    </form>

</div> <!-- /container -->



</body>
</html>