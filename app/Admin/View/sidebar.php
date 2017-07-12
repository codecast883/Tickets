<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="/admin/profile">
                        Просмотр заявок
                    </a>
                    <?php
                    if ($count = app\Components\TicketsApp::getDataAdmin('getCountNewTickets','Tickets')) {

                        echo '<span class="badge">' . $count . '</span>';

                    }
                    ?>


                </li>
                <li class="list-group-item"><a href="/admin/tickets">Опубликованные билеты</a></li>

            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/admin/pulloptions">Настройка пула билетов</a></li>
                <li><a href="/admin/options">Общие настройки</a></li>

            </ul>

        </div>