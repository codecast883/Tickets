<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebarDefault.php'; ?>


<div class="container">

    <div class="row">
        <div class="col-md-6">
            <h2 class="new-event-title">Настройка шаблона недели</h2>

        </div>
        <div class="col-md-6">
            <h3 class="new-event-title step">Шаг 2 из 2</h3>
        </div>


    </div>

    <div class="alert alert-dangers" style = "<?=$styleError?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?=$errorinfo?>
    </div>

    <form role="form" action="" method="post">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Количество выводимых дней</label>
                <div class="form-group day-amount  has-feedback">

                    <input  pattern="\d+" type="text" placeholder="1-30" name="daysAmount" class="form-control "
                           required autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Примерное кол-во билетов в день</label>
                <div class=" day-amount form-group has-feedback">

                    <input type="text" pattern="\d+"  placeholder="1-40"name="ticketsAmount" class="form-control" required>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Интервал времени</label>
                <div class="row">
                    <div class="col-md-5">
                        <div class=" times  form-group has-feedback">

                            <input type="text" name="from" class="form-control" placeholder="От" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class=" times  form-group has-feedback">

                            <input type="text" name="to" class="form-control" placeholder="До" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">Цена</label>
                <div class=" day-amount form-group has-feedback">

                    <input type="text" pattern="\d+"  name="ticketsPrice" class="form-control" required>
                </div>
            </div>

        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Сгенерировать шаблон</button>
    </form>



<script type="text/javascript">
    $(function () {
        $('.times').datetimepicker(
            {pickDate: false, language: 'ru'}
        );
    });


</script>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script> -->

</body>
</html>