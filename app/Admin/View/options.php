<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <div class="jumbotron"><h3>Настройки описания приложения</h3></div>

    <div class="col-md-5">
        <?= $this->alert ?>

        <form role="form" name="updateTickets" enctype="multipart/form-data" action="" method="post">
            Название проекта<br>
            <input type="text" value="<?= $optionsData->title ?>" class="form-control" placeholder="Название проекта"
                   name="title" value="">
            <br>
            Телефон организатора<br>
            <input type="number" value="<?= $optionsData->phone ?>" class="form-control"
                   placeholder="Телефон организатора" name="phone" value="">
            <br>
            О проекте<br>
            <textarea class="form-control" placeholder="Описание проекта"
                      name="description"><?= $optionsData->description ?></textarea>
            <br>
            <div class="row"><label>Загрузка файлов верхнего слайдера:</label><br>


                <input type="hidden" name="MAX_FILE_SIZE" value="3145728"/>
                <input type="file" id="file" name="file"/><br><br>

                <span id="outputMulti"></span>


                <div class="row"><span id="outputMulti"></span></div>
            </div>

            <br>
            <button type="submit" class="btn btn-default">Сохранить</button>
        </form>
    </div>
    <div class="col-md-6">
        <div class="col-md-12 slider-preview">
            <?php if (!empty($allImages)): ?>
                <?php foreach ($allImages as $value): ?>
                    <?php echo '<img src="' . $value->pic_src . '" />' ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php if (isset($_GET['saveOpt'])): ?>

    <script type="text/javascript">
        $(document).ready(function () {
            alertify.success("Изменения сохранены");
        });
    </script>

<?php endif; ?>
<?php if ($errors): ?>
    <script>
        <?php
        foreach ($fileErrors as $value) {
            echo 'alertify.error("' . $value . '");';
        }
        ?>
    </script>
<?php endif; ?>
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
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script> -->

</body>
</html>