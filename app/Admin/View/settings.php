<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>
<?php require_once ROOT . '/../app/Admin/View/sidebarDefault.php'; ?>
<div class="container">

    <?php if (empty($this->ticketsGateway->getAllTickets($this->id))): ?>
        <h1 class="events-alert">Шаблон не настроен</h1>
    <?php else: ?>

    <div class="jumbotron"><h3>Общие настройки аккаунта</h3>
    </div>

<form class="disabled">
    <div class="form-group  has-feedback">
        <label class="form-label">Ссылка на ваше приложение</label>
        <input id="ds" type="text" name="title" value="<?='https://'. $_SERVER['SERVER_NAME'] . '/?getiframe=' . $this->appHash?>" class="form-control ">
    </div>
</div>
</form>
<?php endif; ?>
<!--<script type="text/javascript">-->
<!--    $("#ds").prop("disabled", true);-->
<!--</script>-->

