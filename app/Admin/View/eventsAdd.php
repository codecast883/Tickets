<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>
<?php require_once ROOT . '/../app/Admin/View/sidebarDefault.php'; ?>
<div class="col-sm-9 col-sm-offset-3  col-md-offset-2">

    <div class="row">

        <div class="col-md-6">
            <h2 class="new-event-title">Создание нового квеста(мероприятия)</h2>


        </div>


    </div>
    <form role="form" name="updateTickets" enctype="multipart/form-data" action="" method="post">
        <div class="col-md-5 event-options">


            <div class="form-group  has-feedback">
                <?php if ($errorTitle) {
                    if ($errorTitle == 1) $errorTitleMsg = 'Введено пустое поле';
                    if ($errorTitle == 2) $errorTitleMsg = 'Слишком длинное название, допустимое кол-во символов - 40';
                    if ($errorTitle == 3) $errorTitleMsg = 'Введены недопустимые символы';
                } ?>
                <?= '<span style="color:red">' . $errorTitleMsg . '</span><br>'; ?>
                <label class="form-label">Название события</label>
                <input type="text" name="title" value="" value="<?= $formOptions['title'] ?>" class="form-control "
                       required autofocus>
            </div>
            <div class="form-group has-feedback">
                <?php if ($errorDescription) {
                    if ($errorDescription == 1) $errorDescriptionMsg = 'Допустимое кол-во символов - 400';

                } ?>
                <?= '<span style="color:red">' . $errorDescriptionMsg . '</span><br>'; ?>
                <label class="form-label">Описание</label>
                <textarea rows="5" name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group has-feedback">
                <?php if ($errorPhone) {
                    if ($errorPhone == 1) $errorPhoneMsg = 'Введено пустое поле';
                    if ($errorPhone == 2) $errorPhoneMsg = 'Слишком длинный номер';
                    if ($errorPhone == 3) $errorPhoneMsg = 'Введены недопустимые символы';
                } ?>
                <?= '<span style="color:red">' . $errorPhoneMsg . '</span><br>'; ?>
                <label class="form-label">Телефон для связи</label>
                <input type="number" name="phone" class="form-control" required>
            </div>


        </div>

        <div class="col-md-6 form-images-download">

            <label>Загрузка файлов верхнего слайдера:</label><br>

            <!--                <label class="form-label">Изображения должны быть размером 700х200 пикселей</label>-->
            <input type="hidden" name="MAX_FILE_SIZE" value="3145728"/>
            <input type="file" id="file" name="file"/><br><br>


            <span id="outputMulti"></span>


        </div>


        <div class="pattern-container">
            <div class="col-md-3">
                <?php if ($errorDaysAmount) {
                    if ($errorDaysAmount == 1) $errorDaysAmountMsg = 'Введено пустое поле';
                    if ($errorDaysAmount == 2) $errorDaysAmountMsg = 'Слишком много дней';
                    if ($errorDaysAmount == 3) $errorDaysAmountMsg = 'Введены недопустимые символы';
                } ?>
                <?= '<span style="color:red">' . $errorDaysAmountMsg . '</span><br>'; ?>
                <label class="form-label">Количество выводимых дней</label>
                <div class="form-group day-amount  has-feedback">

                    <input pattern="\d+" type="number" class="pattern-input" name="daysAmount"
                           required autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <?php if ($errorTicketsAmount) {
                    if ($errorTicketsAmount == 1) $errorTicketsAmountMsg = 'Введено пустое поле';
                    if ($errorTicketsAmount == 2) $errorTicketsAmountMsg = 'Слишком много билетов';
                    if ($errorTicketsAmount == 3) $errorTicketsAmountMsg = 'Введены недопустимые символы';
                } ?>
                <?= '<span style="color:red">' . $errorTicketsAmountMsg . '</span><br>'; ?>
                <label class="form-label">Кол-во билетов в день</label>
                <div class=" day-amount form-group has-feedback">

                    <input type="number" pattern="\d+" class="pattern-input" name="ticketsAmount"
                           required>
                </div>
            </div>
            <div class="col-md-3">


                <div class="row">
                    <div class="col-md-5">
                        <div class=" times  form-group has-feedback">
                            <label class="form-label">Старт<br> времени</label>
                            <input type="text" name="from" placeholder="От" class="pattern-input" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class=" interval  form-group has-feedback">
                            <label class="form-label">Интервал времени</label>
                            <input type="text" name="to" placeholder="До" class="pattern-input" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <?php if ($errorTicketsPrice) {
                    if ($errorTicketsPrice == 1) $errorTicketsPriceMsg = 'Введено пустое поле';
                    if ($errorTicketsPrice == 2) $errorTicketsPriceMsg = 'Слишком длинное число';
                    if ($errorTicketsPrice == 3) $errorTicketsPriceMsg = 'Введены недопустимые символы';
                } ?>
                <?= '<span style="color:red">' . $errorTicketsPriceMsg . '</span><br>'; ?>
                <label class="form-label">Цена</label>
                <div class=" day-amount form-group has-feedback">

                    <input type="number" pattern="\d+" name="ticketsPrice" class="pattern-input" required>
                </div>
            </div>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Сгенерировать шаблон</button>
    </form>
</div>
<?php if ($errors): ?>
    <script>
        <?php
        foreach ($fileErrors as $value) {
            echo 'alertify.error("' . $value . '");';
        }
        ?>
    </script>
<?php endif; ?>


<script type="text/javascript">
    $(function () {
        $('.times').datetimepicker(
            {pickDate: false, language: 'ru'}
        );

        $('.interval').datetimepicker(
            {
                pickDate: false,
                language: 'ru',
                defaultDate: "00:30",
                maxDate: "05:00",
                minDate: "00:09"
            }
        );
    });


</script>
<script>
    function handleFileSelectMulti(evt) {
        var files = evt.target.files; // FileList object
        document.getElementById('outputMulti').innerHTML = "";
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                alert("Только изображения....");

            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="img-thumbnail" src="', e.target.result,
                        '" title="', escape(theFile.name), '"/>'].join('');
                    document.getElementById('outputMulti').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }

    document.getElementById('file').addEventListener('change', handleFileSelectMulti, false);
</script>