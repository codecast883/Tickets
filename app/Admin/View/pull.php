<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <div class="jumbotron"><h3>Настройка пула билетов</h3>
    </div>

    <button class="btn btn-primary btn-lg btn-add" data-toggle="modal" data-target="#myModal">
        Добавить билет
    </button>
    <?php if (empty($this->ticketsGateway->getAllTickets($this->eventId))): ?>
        <button class="btn btn-danger btn-lg btn-save-and-pull">
            Сохранить изменения и завершить установку
        </button>
    <?php endif; ?>

    <div class="table-responsive table-tickets">
        <form id="saveWeek" role="form" name="updateTickets" action="" method="post">
            <?php
            $week = [
                'Понедельник',
                'Вторник',
                'Среда',
                'Четверг',
                'Пятница',
                'Суббота',
                'Воскресенье',
            ];
            $i = 0;
            ?>

            <?php foreach ($fullOptions as $number => $tickets) : ?>

                <table class="table table-striped">

                    <h3 class="title-data">


                        <div class="panel panel-success">
                            <div class="panel-body">

                            </div>
                            <div class="panel-footer"> <?= $week[$i++]; ?></div>
                        </div>


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

                        <tr id="<?= $ticket->id ?>">

                            <td><?= ++$key ?></td>
                            <td><input id="time1" class="times form-control" name="<?= $key ?>_time_<?= $number ?>"
                                       value="<?php if (!$ticket->no_time) {
                                           echo app\DB\Tickets::timeFormat($ticket->time);
                                       } ?>"></td>
                            <td><input type="number" class="form-control" name="<?= $key ?>_price_<?= $number ?>"
                                       value="<?= $ticket->price ?>"></td>
                            <td><input type="checkbox" <?php if ($ticket->no_time) {
                                    echo 'checked';
                                } ?> class="checking" name="<?= $key ?>_noTime_<?= $number ?>" value="1"></td>

                            <td>
                                <button type="button" class="btn btn-danger btn-lg btn-delete"
                                        id="<?= $ticket->id . 'd' ?>" role="button">Удалить
                                </button>
                            </td>

                        </tr>


                    <?php endforeach; ?>

                    </tbody>

                </table>

                <button type="button" class="btn btn-default btn-save">Сохранить изменения</button>
            <?php endforeach; ?>


        </form>

        <div class="results"></div>

        <!-- Button trigger modal -->


        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Шаблон готов</h4>
                    </div>
                    <div class="modal-body">
                        <p>Настройте шаблон в разрезе недели так как вам необходимо. Билеты будут генерироваться
                            согласно нему каждый день, при необходимости его можно будет изменить в любое время. После
                            завершения настройки нажимте кнопку "Сохранить изменения и завершить установку".</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php if ($_SERVER['HTTP_REFERER'] == 'https://' . $_SERVER['SERVER_NAME'] . '/admin/events/add'): ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#Modal').modal({
                    keyboard: false
                })
            });
        </script>
    <?php endif; ?>

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
                    <form role="form" name="day" action="/admin/pulloptions/add/<?= $this->eventId ?>" method="post">
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
                                    <p><select size="1" name="day">
                                            <option disabled>Выберите день</option>

                                            <?php foreach ($week as $key => $value): ?>
                                                <option value="<?= ++$key ?>"><?= $value ?></option>
                                            <?php endforeach; ?>

                                        </select></p>
                                </td>
                                <td><input type="text" class="times" name="time" value=""></td>
                                <td><input requiredtype="number" name="price" value=""></td>
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


</div>
</div>
</div>
</div>

<?php if (isset($_GET['add'])): ?>

    <script type="text/javascript">
        $(document).ready(function () {
            alertify.success("Билет добавлен");
        });
    </script>

<?php endif; ?>
<script type="text/javascript">
    $(function () {
        $('.times').datetimepicker(
            {pickDate: false, language: 'ru'}
        );
    });


    $(".btn-save").click(function () {
        alertify.confirm("Сохранить изменения?", function (e) {
            if (e) {
                var msg = $('#saveWeek').serialize();
                $.ajax({
                    type: "POST",
                    url: "/admin/events/pulloption" + "s/<?=$this->eventId?>",
                    data: msg,
                    cache: false,
                    success: function (data) {

                        alertify.success("Изменения сохранены");
                    }

                });
            } else {
                // user clicked "cancel"
            }
        });

    });

    $(".btn-save-and-pull").click(function () {

        $.ajax({
            type: "GET",
            url: "/action/add/<?=$this->eventId; ?>",

            cache: false,
            success: function () {
                $('.btn-save-and-pull').css('display', 'none');
                alertify.alert("Готово! Данные сохранены и сгенерирована ваша ссылка для встраивания, найти её можно в настройках.");
            }

        });
    });


    $(document).ready(function () {
        $('.btn-delete').click(function () {
            var id = $(this).attr('id');
            var s = parseInt(id, 10);

            $(document).ajaxSend(function () {
                $('#' + s).css('opacity', '0.4');
                console.log(s);

            });

            $(document).ajaxError(function (thrownError) {
                alertify.error('Ошибка');

            });
            $.ajax({
                url: "/admin/pulloptions/delete/" + s,

                success: function (data) {
                    $('#' + s).fadeOut("slow", function () {
                        $('#' + s).remove();
                    });


                    alertify.success("Билет успешно удалён");
                }

            });


        })
    });

</script>

<!-- Modal -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script> -->

</body>
</html>