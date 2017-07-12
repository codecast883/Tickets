<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/style/bootstrap.min.css">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/orbit.css">
    <link rel="stylesheet" href="/style/style_edit.css">

    <script type="text/javascript" src="/js/jquery-1.12.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jquery.orbit-1.2.3.js"></script>


    <meta name="viewport" content="width=device-width">
    <script type="text/javascript">
        $(window).load(function () {
            $('#featured').orbit();
        });
    </script>
</head>

<body>


<div class="frame">
    <h2><?= app\Components\TicketsApp::getDataAdmin('getOptions','Options')->title ?></h2>


    <div class="contact">
        <p>
            <span class="small_icon phone"><?= app\Components\TicketsApp::getDataAdmin('getOptions','Options')->phone; ?></span>
        </p>
    </div>
</div>

<div id="featured">
    <?php foreach (app\Components\TicketsApp::getDataAdmin('getAllHeaderImages','Options') as $value): ?>
        <?php echo '<img src="' . $value->pic_src . '" style="width:683px"/>' ?>
    <?php endforeach; ?>
</div>







		
	