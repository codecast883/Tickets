<?php require_once __DIR__ . '/header.php'; ?>


<div class="container">
    <div class="jumbotron done">

        <h2> Вы успешно записаны!</h2>
        <a href="<?= 'https://' . $_SERVER['SERVER_NAME'] . '/tickets/list?getiframe=' . $this->hash ?>"
           class="go-home">Вернуться в приложение</a>
    </div>


</div>

</body>

</html>