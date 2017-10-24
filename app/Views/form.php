<?php require_once "head.php" ?>
<?php require_once "header-inc.php" ?>

    <div class="form-container">
        <div class="form-wrapper">
            <form class="form-reserve" role="form" action="" method="post">

                <div class="section-services clearfix">

                    <div class="section-services-one">
                        <div class="date"><span>Дата:</span><span>
                                <?= app\DB\Day::dateFormat($ticketData->date)[0] ?>
                                <?= app\DB\Day::dateFormat($ticketData->date)[1] ?>
                                в <?php if (!$ticketData->no_time): ?>

                                    <?= app\DB\Tickets::timeFormat($ticketData->time); ?>

                                <?php else: ?>
                                любое время
                            <?php endif ?></div>
                        <div class="count-peoples">
                            <span>Кол-во человек:</span>
                            <select size="1" name="countPeoples" class="select-count-peoples">
                                <?php for ($i = $this->eventData->min_people; $i <= $this->eventData->max_people; $i++): ?>


                                    <option value="<?= $i ?>"><?= $i ?></option>

                                <?php endfor; ?>

                            </select>
                            <span class="count-peoples-summ"> <?= $this->eventData->min_people ?></span>
                            <div class="count-peoples-control">
                                <div class="count-peoples-add"> +</div>
                                <div class="count-peoples-reduce"> -</div>
                            </div>

                        </div>
                        <div class="price"><span>Цена:</span><span
                                    class="pricevalue"> <?= $ticketData->price ?></span><span
                                    class="currency"> р.</span></div>
                    </div>
                    <div class="section-services-two">
                        <div class="service-title">Дополнительные услуги</div>
                        <div class="service-items">

                            <?php foreach ($services as $number => $sevice): ?>
                                <input type="checkbox" id="<?= $sevice->id ?>" name="<?= $sevice->id ?>"
                                       value="<?= $sevice->price ?>">

                                <label for="<?= $sevice->id ?>" class="service-item">

                                    <div class="service-item-title">"<?= $sevice->title ?>"</div>
                                    <div class="service-item-price">+<?= $sevice->price ?>р</div>
                                </label>

                            <?php endforeach; ?>


                        </div>

                    </div>
                </div>

                <div class="section-userdata">
                    <div class="userdata-container">
                        <div class="userdata-hidden-line"></div>
                        <div class="userdata-input name">
                            <input type="text" id="form-nickname" placeholder="Ваше имя" name="name">
                        </div>
                    </div>
                    <div class="userdata-container">
                        <div class="userdata-hidden-line"></div>
                        <div class="userdata-input telephone">
                            <div class="telephone-prev">+7</div>
                            <input type="text" id="form-telephone"  placeholder="(999)999-99-99" name="phone">
                        </div>
                    </div>
                    <div class="userdata-container">
                        <div class="userdata-hidden-line"></div>
                        <div class="userdata-input note">
                            <input type="text" id="form-note" placeholder="Примечание" name="note">
                        </div>
                    </div>

                </div>
                <input type="hidden" id="hiddenID" name="vkId" value="0">
                <input type="hidden" id="hiddenSurname" name="surname" value="0">
                <input type="hidden" id="bdate" name="bdate" value="0">
                <input type="hidden" id="university_name" name="university_name" value="0">
                <input type="hidden" id="faculty_name" name="faculty_name" value="0">
                <input type="hidden" id="city" name="city" value="0">
                <button type="button" disabled class="button-reserve button-disabled ">Забронировать</button>
            </form>

            <div class="reserve-successful">
                <div class="reserve-successful-text">
                    <h1>Вы успешно забронированы!</h1>
                </div>
            </div>
        </div>
    </div>

<?php require_once "footer-inc.php" ?>