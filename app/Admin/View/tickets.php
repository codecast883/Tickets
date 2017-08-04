<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">



    <?php if (empty($ticketsList)): ?>
        <h1 class="events-alert">Билеты отсутствуют</h1>
    <?php else: ?>
        <h2 class="sub-header">Опубликованные билеты</h2>
        <?=  $this->alert ?>
        <div class="table-responsive table-tickets">
            <button class="btn btn-primary btn-lg btn-add" data-toggle="modal" data-target="#myModal">
                Добавить билет
            </button>
            <br>
            <form role="form" id="updateTickets" name="updateTickets" action="" method="post">


                <?php foreach ($ticketsList as $date => $tickets) : ?>

                    <table class="table table-striped">

                        <h3 class="title-data">

                            <?= app\DB\Day::dateFormat($date)[0] ?>
                            <?= app\DB\Day::dateFormat($date)[1] . ',' ?>
                            <span><?= app\DB\Day::dateFormat($date)[2] ?></span>


                        </h3>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Время события</th>
                            <th>Цена,р.</th>
                            <th>Без времени</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($tickets as $key => $ticket) : ?>

                            <tr>

                                <td><?= ++$key ?></td>
                                <td><input id="time1" class="times form-control" name="<?= $key ?>_time_<?= $date ?>"
                                           value="<?php if (!$ticket->no_time) {
                                               echo app\DB\Tickets::timeFormat($ticket->time);
                                           } ?>"></td>
                                <td><input type="number" class="form-control" name="<?= $key ?>_price_<?= $date ?>"
                                           value="<?= $ticket->price ?>"></td>
                                <td><input type="checkbox" <?php if ($ticket->no_time) {
                                        echo 'checked';
                                    } ?> class="checking" name="<?= $key ?>_noTime_<?= $date ?>" value="1"></td>

                                <td><a href="/admin/tickets/delete/<?= $ticket->id ?>" class="btn btn-danger btn-lg"
                                       role="button">Удалить</a></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                    <button type="button" class="btn btn-default btn-save">Сохранить изменения</button>
                <?php endforeach; ?>


            </form>


            <script type="text/javascript">


                $(".btn-save").click(function () {

                    var msg = $('#updateTickets').serialize();
                    $.ajax({
                        type: "POST",
                        url: "/admin/tickets",
                        data: msg,
                        cache: false,
                        success: function (data) {

                            alertify.success("Изменения сохранены");
                        }

                    });
                });

            </script>


            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Добавить новый билет</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" name="addTickets" action="/admin/tickets/add" method="post">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Время события</th>
                                        <th>Цена,р.</th>
                                        <th>Без времени</th>

                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p><select size="1" name="date">
                                                    <option disabled>Выберите дату</option>

                                                    <?php foreach ($this->ticketsGateway->getAllday($this->id) as $value) : ?>
                                                        <option value="<?= $value ?>"><?= $value ?></option>
                                                    <?php endforeach; ?>

                                                </select></p>
                                        </td>
                                        <td><input type="text" class="times" name="time" value=""></td>
                                        <td><input type="number" name="price" value=""></td>
                                        <td><input type="checkbox" name="noTime" value="1"></td>
                                    </tr>
                                    </tbody>
                                </table>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>


                            <button type="submit" class="btn btn-primary btn-lg">Сохранить</button>

                        </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <script type="text/javascript">
                $(function () {
                    $('.times').datetimepicker(
                        {pickDate: false, language: 'ru'}
                    );
                });
            </script>


        </div>
    <?php endif; ?>


</div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script> -->

</body>
</html>