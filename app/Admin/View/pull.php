<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="jumbotron"><h3>Настройка пула билетов</h3><br>Обновление билетов производится на каждый конец недели
    </div>
    <?= $formSuccess ?>
    <div class="table-responsive table-tickets">
        <form role="form" name="updateTickets" action="" method="post">


            <?php foreach ($fullOptions as $number => $tickets) : ?>

                <table class="table table-striped">

                    <h3 class="title-data">


                        <div class="panel panel-success">
                            <div class="panel-body">

                            </div>
                            <div class="panel-footer"> <?= $number . ' День' ?></div>
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

                        <tr>

                            <td><?= ++$key ?></td>
                            <td><input id="time1" class="times form-control" name="<?= $key ?>_time_<?= $number ?>"
                                       value="<?php if (!$ticket->no_time) {
                                           echo $ticket->time;
                                       } ?>"></td>
                            <td><input type="number" class="form-control" name="<?= $key ?>_price_<?= $number ?>"
                                       value="<?= $ticket->price ?>"></td>
                            <td><input type="checkbox" <?php if ($ticket->no_time) {
                                    echo 'checked';
                                } ?> class="checking" name="<?= $key ?>_noTime_<?= $number ?>" value="1"></td>

                            <td><a href="/admin/pulloptions/delete/<?= $ticket->id ?>" class="btn btn-danger btn-lg"
                                   role="button">Удалить</a></td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

                <button type="submit" class="btn btn-default btn-save">Сохранить изменения</button>
            <?php endforeach; ?>


        </form>


        <!--    <script type="text/javascript">
             var arr = [];
               $(".checking").change(function(){
                   arr = $(".checking:checked").map(function(i,el){
                       return $(el).val();
                   }).get();
                    $("#time1").attr("value", arr);;
               });

             </script> -->


        <!-- Button trigger modal -->
        <button class="btn btn-primary btn-lg btn-add" data-toggle="modal" data-target="#myModal">
            Добавить билет
        </button>

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
                        <form role="form" name="addTickets" action="/admin/pulloptions/add" method="post">
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

                                                <?php for ($i = 1; $i <= $this->pulloptionsGateway->countDay(); $i++): ?>
                                                    <option value="<?= $i ?>"><?= $i . ' День' ?></option>
                                                <?php endfor; ?>

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