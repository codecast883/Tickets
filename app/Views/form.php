<?php require_once __DIR__ . '/header.php'; ?>
<div class="container container-form">
    <div class="form-wrapper">
        <div class="parameters">
            <p><span class='datetitle'>Дата</span>
                <span class='dateday'>
				<?= app\DB\Day::dateFormat($ticketData->date)[0] ?>
                <?= app\DB\Day::dateFormat($ticketData->date)[1] ?>
			</span>
                <?php if (!$ticketData->no_time): ?>
                    в <span class='datetime'>
			 <?= app\DB\Tickets::timeFormat($ticketData->time); ?>
			 </span>
                <?php else: ?>
                    в любое время
                <?php endif ?>
        </div>
        <div class="parameters">
            <p><span class='pricetitle'>Цена</span> <span class='pricevalue'> <?= $ticketData->price ?></span>
        </div>
        <form class="form-horizontal" role="form" action="" method="post">

            <div class="form-group">

                <label for="check1" class="col-sm-2  control-label">Ваше имя</label>
                <div class="col-sm-3 <?= $error[0]['name'] ?>">
                    <?= $error[1]['name'] ?>
                    <input type="text" class="form-control " value="<?= $formData['name'] ?>" name="name"
                           placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="check2" class="col-sm-2 control-label">Телефон</label>
                <div class="col-sm-3 <?= $error[0]['phone'] ?>">
                    <?= $error[1]['phone'] ?>
                    <input type="text" class="form-control" value="<?= $formData['phone'] ?>" name="phone"
                           placeholder="+7(9__)">
                </div>
            </div>

            <div class="form-group">
                <label for="check3" class="col-sm-2 control-label">Почта</label>
                <div class="col-sm-3 <?= $error[0]['email'] ?>">
                    <?= $error[1]['email'] ?>
                    <input type="email" value="<?= $formData['email'] ?>" class="form-control" name="email"
                           placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Заметка</label>
                <div class="col-sm-3 <?= $error[0]['note'] ?>">
                    <?= $error[1]['note'] ?>
                    <input type="text" class="form-control" value="<?= $formData['note'] ?>" name="note">

                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default btn-ticket">Забронировать</button>
                </div>
            </div>
        </form>
    </div>
</div>