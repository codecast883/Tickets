<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-6 col-sm-offset-3 sevices-list">
    <div class="jumbotron title-services"><span>Управление лополнительными услугами</span></div>

    <div class="col-md-6">

        <button class="btn btn-primary btn-add-service" data-toggle="modal" data-target="#myModal">
            Добавить услугу
        </button>
        <table class="table table-striped table-services">

            <thead>
            <tr>
                <th></th>
                <th>Название</th>
                <th>Цена, р.</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            <?php foreach ($services as $number => $service) : ?>
                <tr class="id" id="<?= $service->id ?>">
                    <td></td>
                    <td><?= $service->title ?></td>
                    <td><?= $service->price ?></td>
                    <td class="glyphicon glyphicon-pencil" style="display: none"></td>
                    <td class="glyphicon glyphicon-remove glyphicon-remove-service" id="<?= $service->id ?>id"></td>

                </tr>
            <? endforeach; ?>


            </tbody>
        </table>
    </div>
    <div class="col-md-5 sevice-right-column">
        <span>Ограничение кол-ва человек</span>

        <form class="form-horizontal" id="save-cpeople" role="form" action="" method="post">
            <div class="form-count-people">
                <label class="form-label">От</label>


                <input type="number" pattern="\d+" value="<?= $eventData->min_people ?>" class="pattern-input"
                       name="peopleMin"
                       required>

            </div>
            <div class="form-count-people">
                <label class="form-label">До</label>


                <input type="number" pattern="\d+" value="<?= $eventData->max_people ?>" class="pattern-input"
                       name="peopleMax"
                       required>

            </div>
            <button type="button" id="btn-save-cpeople" class="btn btn-primary btn-lg">
                Сохранить
            </button>
        </form>
    </div> <!-- Modal -->


    <div class="col-md-offset-7 count-people-price">
        <span>Прайс на количество участников</span>
        <br>
        <button class="btn btn-primary btn-add-price">
            Добавить цену
        </button>
        <table class="table table-striped table-cpeoples">

            <thead>
            <tr>
                <th></th>
                <th>Кол-во участников</th>
                <th>Цена, р.</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($priceCountPeoples as $number => $service) : ?>
                <tr id="count<?= $service->id ?>">
                    <td></td>
                    <td><?= $service->count_peoples ?></td>
                    <td><?= $service->price ?></td>
                    <td class="glyphicon glyphicon-pencil" style="display: none"></td>
                    <td class="glyphicon glyphicon-remove glyphicon-remove-price" id="<?= $service->id ?>id"></td>

                </tr>
            <? endforeach; ?>


            </tbody>
        </table>
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class=" modal-services">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Добавить новую услугу</h4>
                </div>
                <div class="modal-body ">
                    <form role="form" id="saveService" name="day" action="" method="post">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Цена</th>


                            </thead>
                            <tbody>
                            <tr>

                                <td><input type="text" name="title" value="" required></td>
                                <td><input type="number" name="price" value="" required></td>

                            </tr>
                            </tbody>
                        </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>


                    <div id="btn-save-service" class="btn btn-primary btn-lg">Сохранить</div>

                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade bs-example-modal-sm" id="asas" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form role="form" id="save" name="day" action="" method="post">
                    <table class="table table-striped table-prices">
                        <thead>
                        <tr>
                            <th>От кол-ва участников</th>
                            <th>Цена</th>


                        </thead>
                        <tbody>
                        <tr>

                            <td><input type="number" name="from" value="" required></td>
                            <td><input type="number" name="price" value="" required></td>

                        </tr>
                        </tbody>
                    </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>


                <div id="btn-save-price" class="btn btn-primary btn-lg">Сохранить</div>

            </div>
            </form>
        </div>
    </div>
</div>


</div>


<script type="text/javascript">
    function updateTableNumeration() {
        $('.table tbody .id').each(function (i) {
            $(this).find('td:first').text(++i + ".");
        });
    }


    $(document).ready(function () {
        $(".btn-add-price").click(function () {
            $('#asas').modal();
        });

        $(document).ajaxError(function (thrownError) {
            alertify.error('Ошибка');

        });
        updateTableNumeration();
        $("#btn-save-service").click(function () {

            var msg = $('#saveService').serialize();


            $.ajax({
                type: "POST",
                url: "/admin/services/add/<?= $this->eventId?>",
                data: msg,
                cache: false,
                success: function (data) {

                    $('#myModal').modal('hide');
                    alertify.success("Изменения сохранены");
                    if (!data['GET']['title']) {
                        alertify.error("Ошибка");
                    }
                    $(".table-services > tbody").append("<tr class='id' id='" + data['last_service']['id'] + "'><td></td> <td>" + data['GET']['title'] + "</td> <td>" + data['GET']['price'] + "</td><td class='glyphicon glyphicon-pencil' style='display: none'></td><td class='glyphicon glyphicon-remove glyphicon-remove-service' id='" + data['last_service']['id'] + "id'></td> </tr>");
                    updateTableNumeration();
                    $('#saveService')[0].reset();

                }

            });


        });

        $("#btn-save-price").click(function () {

            var msg = $('#save').serialize();


            $.ajax({
                type: "POST",
                url: "/admin/services/addprice/<?= $this->eventId?>",
                data: msg,
                cache: false,
                success: function (data) {

                    $('#asas').modal('hide');
                    alertify.success("Изменения сохранены");

                    $(".table-cpeoples > tbody").append("<tr  id='" + data['last_price']['id'] + "'><td></td> <td>" + data['last_price']['count_peoples'] + "</td> <td>" + data['last_price']['price'] + "</td><td class='glyphicon glyphicon-pencil' style='display: none'></td><td class='glyphicon glyphicon-remove glyphicon-remove-price' id='" + data['last_price']['id'] + "id'></td> </tr>");

                    updateTableNumeration();
                    $('#save')[0].reset();

                }

            });


        });
    });

    $("#btn-save-cpeople").click(function () {

        var msg = $('#save-cpeople').serialize();

        $.ajax({

            type: "POST",
            url: "/admin/services/updatecp/<?= $this->eventId?>",
            data: msg,
            cache: false,
            success: function (data) {
                alertify.success("Изменения сохранены");
            }

        });


    });

    $(document).on("click", ".glyphicon-remove-service", function () {
        var id = $(this).attr('id');
        var s = parseInt(id, 10);


        alertify.confirm("Удалить услугу?", function (e) {
            if (e) {
                $.ajax({
                    url: "/admin/services/delete/" + s + "?event=<?=$this->eventId?>",

                    success: function (data) {
                        $('#' + s).fadeOut("slow", function () {
                            $('#' + s).remove();
                        });

                        alertify.success("Билет успешно удалён");
                        updateTableNumeration();

                    }

                });
            } else {
                // user clicked "cancel"
            }
        });

    });

    $(document).on("click", ".glyphicon-remove-price", function () {
        var id = $(this).attr('id');
        var s = parseInt(id, 10);


        alertify.confirm("Удалить услугу?", function (e) {
            if (e) {
                $.ajax({
                    url: "/admin/services/deleteprice/" + s + "?event=<?=$this->eventId?>",

                    success: function (data) {
                        $('#' + 'count' + s).fadeOut("slow", function () {
                            $('#' + 'count' + s).remove();
                        });

                        alertify.success("Билет успешно удалён");


                    }

                });
            } else {
                // user clicked "cancel"
            }
        });

    });

</script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script> -->

</body>
</html>