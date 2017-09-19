<?php require_once __DIR__ . '/header.php'; ?>
<a class="button-back" href="<?= 'https://' . $_SERVER['SERVER_NAME'] . '/tickets/list?getiframe=' . $this->hash ?>">Назад</a>
<div class="menu-tab">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Запись на квест</a></li>
        <li class="center"><a href="#profile" data-toggle="tab">Описание</a></li>
        <li class="right"><a href="#messages" data-toggle="tab">Фото участников</a></li>

    </ul>
</div>
<div class="container">

    <div class="tab-content">
        <div class="tab-pane active" id="home">
            <div class="wrap">

                <?php foreach ($list as $date => $tickets) : ?>
                    <div class="shRow">
                        <div class="shDate qad6">

                            <?= app\DB\Day::dateFormat($date)[0] ?>
                            <?= app\DB\Day::dateFormat($date)[1] ?>
                            <span><?= app\DB\Day::dateFormat($date)[2] ?></span>
                        </div>

                        <div class="shSlots">

                            <?php foreach ($tickets as $ticket) : ?>
                                <div class="shSlot">
                                    <div class="shTime <?php if ($ticket->no_time) {
                                        echo 'noTime';
                                    } ?> <?php if (app\DB\Tickets::actionDisabled($date)) {
                                        echo 'disabledDate';
                                    } ?>">

                                        <a href="/tickets/request/<?= $ticket->id ?>?getiframe=<?= $this->hash ?>&id=<?= $this->eventId ?>"
                                           class="shTimeHref"><?php if (!$ticket->no_time) {
                                                echo app\DB\Tickets::timeFormat($ticket->time);
                                            } else {
                                                echo 'Без' . '<br>' . 'времени';
                                            } ?></a>
                                    </div>
                                    <div class="shPrice"><?= $ticket->price ?> р</div>
                                </div>
                            <?php endforeach; ?>

                        </div>

                    </div>
                <?php endforeach; ?>


            </div>

        </div>


        <div class="tab-pane fade"
             id="profile"><?=
            $this->header->description; ?></div>
        <div class="tab-pane fade" id="messages"></div>

    </div>

</div>

</body>

</html>