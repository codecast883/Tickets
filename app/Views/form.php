<?php require_once __DIR__ . '/header.php'; ?>


<a class="button-back" href="<?= $_SERVER['HTTP_REFERER'] ?>">Назад</a>
<div class="container container-form">
    <div class="form-wrapper">
        <form class="form-horizontal" role="form" action="" method="post">
            <div class="param">
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
                    <p><span class='pricetitle'>Цена</span>
                        <span class='pricevalue'> <?= $ticketData->price ?></span>
                    <p>
                    <p><span class='pricetitle'>Кол-во игроков</span>
                        <select size="1" name="countPeoples" class="select-count-peoples">
                            <?php for ($i = $this->header->min_people; $i <= $this->header->max_people; $i++): ?>


                                <option value="<?= $i ?>"><?= $i ?></option>

                            <?php endfor; ?>

                        </select>
                    </p>
                </div>
            </div>

            <div class="sevices">
                <span>Доп. услуги</span>
                <ul class="sevice-item">
                    <?php foreach ($services as $number => $sevice): ?>
                        <p>
                            <input type="checkbox" name="<?= $sevice->id ?>" value="<?= $sevice->price ?>">

                            <label for="test1">"<?= $sevice->title ?>"</label>
                            <label class="price" for="test2">+<?= $sevice->price ?>р</label>
                        </p>

                    <?php endforeach; ?>

                </ul>
            </div>


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


            <input type="hidden" value="<?= $_GET['viewer_id'] ?>" class="form-control" name="id"
            >


            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Заметка</label>
                <div class="col-sm-3 <?= $error[0]['note'] ?>">
                    <?= $error[1]['note'] ?>
                    <input type="text" class="form-control" value="<?= $formData['note'] ?>" name="note">

                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default btn-ticket">Забронировать</button>
                </div>
            </div>
        </form>


    </div>

    <div class="jumbotron done">

        <h2> Вы успешно записаны!</h2>
        <a href="<?= 'https://' . $_SERVER['SERVER_NAME'] . '/tickets/list?getiframe=' . $this->hash ?>"
           class="go-home">Вернуться в приложение</a>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        var dataPeoplesObject = $.parseJSON('<?=$priceCountPeoplesJson?>');

        var value = parseInt($(".pricevalue").html());
        var servicePrice = 0;

        var objPrices = {};
        var lastPrice = value;
        $(".select-count-peoples > option").each(function (index) {
            var count = +$(this).val();
            for (var key in dataPeoplesObject) {
                if (count === dataPeoplesObject[key]['count_peoples']) {
                    objPrices[count] = dataPeoplesObject[key]['price'];
                    objPrices[count] += value;
                    lastPrice = objPrices[count];
                    break;
                } else {
                    objPrices[count] = lastPrice;
                }
            }
        });

        console.log(objPrices);


        $("select").change(function () {
//
            var countOption = parseInt($(this).val());
            $(".pricevalue").html(function () {
                var totalPrice = servicePrice + objPrices[countOption];

                return totalPrice;
            }).animate({fontSize: 30}, 1000);


        });

        $(":checkbox").click(function () {
            price = $(this).attr('value');
            var totalPrice;
            if ($(this).prop('checked')) {
                servicePrice += parseInt(price);
                $(".pricevalue").html(function (i, numb) {
                    totalPrice = parseInt(numb) + parseInt(price);
                    return totalPrice;
                }).animate({fontSize: 30}, 1000);
            } else {
                servicePrice -= parseInt(price);
                $(".pricevalue").html(function (i, numb) {
                    totalPrice = parseInt(numb) - parseInt(price);
                    return totalPrice;
                });
            }


        });


        $(".btn-ticket").click(function () {
            var inputs = $('.form-horizontal').find('input[type=text],select,:checked'), object = {};
            $.each(inputs, function (num, element) {
                object[$(element).attr('name')] = $(element).val()
            });
            var prices = $.toJSON(objPrices);
            object.dataPrices = prices;


            $.ajax({
                type: "POST",
                url: window.location.href,
                data: object,
                cache: false,
                success: function (data) {
                    $(".form-wrapper").css("display", "none");
                    $(".done").css("display", "block");
                }
            });


        });


    })

</script>