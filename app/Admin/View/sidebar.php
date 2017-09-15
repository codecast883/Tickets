<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="/admin/events/requestlist/<?= $this->eventId ?>">
                        Просмотр заявок
                    </a>
                    <?php
                    if ($count = app\Components\TicketsApp::getDataAdmin('getCountNewTickets', 'Tickets', $this->eventId)) {

                        echo '<span class="badge">' . $count . '</span>';

                    }
                    ?>


                </li>
                <li class="list-group-item"><a href="/admin/events/tickets/<?= $this->eventId ?>">Опубликованные
                        билеты</a></li>

            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/admin/events/pulloptions/<?= $this->eventId ?>">Пул билетов</a></li>
                <li><a href="/admin/events/options/<?= $this->eventId ?>">Описание</a></li>
                <li><a href="/admin/events/services/<?= $this->eventId ?>">Услуги</a></li>
                <br><br>
                <li class="go-back"><a href="/admin">НАЗАД</a></li>

            </ul>

        </div>