<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <?php require_once('includeHeader.php'); ?>

</head>

<body>

<div class="container">
    <?php foreach ($events as $key => $value): ?>
        <?php $imgSrc = \app\Components\TicketsApp::getDataAdmin('getAllEventsImages', 'Events', $value->event_id)[0]->pic_src; ?>
        <div class="col-md-12 event-item"
             style="background: url('<? if (!empty($imgSrc)) echo $imgSrc; ?>') 50%  no-repeat; background-color: white;
                     background-size: cover;">

        <span class="event-title">
            <?= '"' . $value->title . '"' ?>
        </span>
            <a href="event?getiframe=<?= $this->hash . '&id=' . $value->event_id . '&viewer_id=' . $_GET['viewer_id'] ?>"
               class="event-link"></a>
        </div>

    <?php endforeach; ?>

</div>


</body>

</html>