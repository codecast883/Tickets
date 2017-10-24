<?php require_once "head.php" ?>

<!--[if lte IE 9]>
<p class="browserupgrade">Вы используете <strong>устаревший</strong> браузер. Пожалуйста обновите ваш браузер.</p>

<![endif]-->

<?php require_once "header-inc.php" ?>
<main>

    <ul class="main-menu-items">
        <li class="tickets-list"><span>Запись на квест</span></li>
        <li class="menu-description"><span>Описание</span></li>
        <li class="menu-photo"><span>Фото</span></li>
    </ul>


    <div class="tickets-container">
        <div class="tickets-list-wrapper">
            <?php foreach ($list as $date => $tickets) : ?>

                <section class="tickets-day">
                    <div class="tickets-day-period">


                           <span class="tickets-date">
                               <?= app\DB\Day::dateFormat($date)[0] ?>
                               <?= app\DB\Day::dateFormat($date)[1] ?>
                           </span>
                        <span class="tickets-dweek">
                               <?= app\DB\Day::dateFormat($date)[2] ?>

                           </span>
                    </div>
                    <div class="tickets-day-items">

                        <?php foreach ($tickets as $ticket) : ?>
                            <div class="tickets-item">

                                <div class="<?php if (app\DB\Tickets::isDisabled($date)) {
                                    echo 'no-title';
//                                } elseif ($reservedCookie) {
//                                    foreach ($reservedCookie as $value) {
//                                        if ($value['id'] == $ticket->id and $value['event_id'] == $ticket->event_id) {
//                                            echo 'no-title';
//                                        }
//                                    }
                                } else {
                                    echo "tickets-item-time";
                                }
                                ?>

                                "><a href="/tickets/request/<?= $ticket->id ?>?getiframe=<?= $this->hash ?>&id=<?= $this->eventId ?>"><span <?php if ($ticket->no_time) {
                                            echo 'class="no-time"';
                                        } ?>>

                                      <?php if (!$ticket->no_time) {
                                          echo app\DB\Tickets::timeFormat($ticket->time);
                                      } else {
                                          echo 'Без' . '<br>' . 'времени';
                                      } ?>

                                   </span></a>


                                </div>
                                <div class="tickets-item-price">
                                    <span><?= $ticket->price ?>р</span>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </section>

            <?php endforeach; ?>
        </div>
        <div class="description-wrapper" style="display: none"><?= $this->eventData->description; ?></div>
        <div class="photo-wrapper" style="display: none"></div>
    </div>
</main>

<?php require_once "footer-inc.php" ?>
