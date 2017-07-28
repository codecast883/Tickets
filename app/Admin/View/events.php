<?php require_once ROOT . '/../app/Admin/View/header.php'; ?>
<?php require_once ROOT . '/../app/Admin/View/sidebarDefault.php'; ?>

<a href="/admin/events/add" class="btn btn-primary btn-lg add-event"  role="button">Добавить мероприятие</a>
<div class="container">

<!--    <a href="" class="btn btn-primary btn-lg add-event">Добавить мероприятие</a>-->
    <?php if (!$this->eventsGateway->isEventsExist($this->id)):?>
    <h1 class="events-alert">События отсутствуют</h1>
    <?php endif;?>
    <div id="form"></div>


<!--<script type="text/javascript">-->
<!--    $('.add-event').bind('click', function(){-->
<!---->
<!--        $.ajax({-->
<!--            type: "GET",-->
<!--            url: "/admin/events/add",-->
<!--            cache:false,-->
<!---->
<!--            success: function(html){-->
<!--                $('#foo').removeClass('active');-->
<!--                $(".events-alert").remove();-->
<!--                $("#form").html(html);-->
<!--            }-->
<!---->
<!--        });-->
<!--        $('#foo').addClass('active');-->
<!--            return false;-->
<!---->
<!--    });-->
<!---->
<!--</script>-->

<!--    <div id="foo"><img src="/src/pictures/5.gif"></div>-->
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   <script src="/js/bootstrap.min.js"></script> -->

</body>
</html>