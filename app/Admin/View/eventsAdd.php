<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>
<?php require_once ROOT . '/../app/Admin/View/sidebarDefault.php'; ?>
<div class="container">

    <div class="row">

        <div class="col-md-6">
            <h2 class="new-event-title">Создание нового квеста(мероприятия)</h2>

            <?php if ($this->alert){die($this->alert);}?>
        </div>
        <div class="col-md-6">
            <h3 class="new-event-title step">Шаг 1 из 2</h3>
        </div>


    </div>
<form role="form" name="updateTickets" enctype="multipart/form-data" action="" method="post">
<div class="col-md-5">



        <div class="form-group  has-feedback">
            <label class="form-label">Название события</label>
            <input type="text" name="title" value="" class="form-control "
                   required autofocus>
        </div>
        <div class="form-group has-feedback">
            <label class="form-label">Описание</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="form-group has-feedback">
            <label class="form-label">Телефон для связи</label>
            <input type="text" name="phone" class="form-control" required>
        </div>


</div>

<div class="col-md-6 form-images-download">

    <div class="row"><label>Загрузка файлов верхнего слайдера:</label><br>
        <span>Выделите нужные вам файлы и нажмите добавить</span><br>

        <label class="form-label">Изображения должны быть размером 700х200 пикселей</label>
        <input type="file" id="fileMulti" name="fileMulti[]" multiple/><br><br>


        <div class="row"><span id="outputMulti"></span></div>
    </div>

    <br>

</div>
<button class="btn btn-lg btn-primary btn-block" type="submit">Продолжить</button>
</form>

</div>
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

    document.getElementById('fileMulti').addEventListener('change', handleFileSelectMulti, false);
</script>