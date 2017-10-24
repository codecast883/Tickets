<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>

<?php require_once ROOT . '/../app/Admin/View/sidebar.php'; ?>


<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h2 class="sub-header">Заявки</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата события</th>
                <th>Время события</th>
                <th>Цена</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Телефон</th>
                <th>Город</th>
                <th>Дата рождения</th>
                <th>Университет</th>

                <th>VK ID</th>
                <th>Заметка</th>
                <th>Услуги</th>
                <th>Кол-во человек</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listRequest as $key => $value): ?>
                <?php $services = $this->requestGateway->getRequestService($value->id) ?>

                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $value->date ?></td>
                    <td><?= $value->time ?></td>
                    <td><?= $value->price ?></td>
                    <td><?= $value->name ?></td>
                    <td><?= $value->second_name ?></td>
                    <td><?= $value->phone ?></td>
                    <td><?= $value->city ?></td>
                    <td><?= $value->date_of_birth ?></td>
                    <td><?= $value->university_name?></td>

                    <td><?= $value->vkId ?></td>
                    <td><?= $value->note ?></td>
                    <td><? if ($services): ?>
                            <?php foreach ($services as $obj): ?>
                                <?php echo (new \app\Admin\DB\ServicesGateway)->getService($obj->service_id)[0]->title . '<br>' ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $value->count_peoples ?></td>

                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   <script src="/js/bootstrap.min.js"></script> -->

</body>
</html>