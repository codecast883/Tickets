<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <?php require_once('includeHeader.php'); ?>
    <script type="text/javascript">
        $(window).load(function () {
            $('#featured').orbit();
        });
    </script>
</head>

<body>


<div class="frame">
    <h2><?= $this->header->title ?></h2>


    <div class="contact">
        <p>
            <span class="small_icon phone"><?= $this->header->phone; ?></span>
        </p>
    </div>
</div>
<?php if (empty($this->headerImg)): ?>
    <div class="not-images">
        <span>Нет изображения</span>
    </div>
<?php else: ?>
<div id="featured">

    <?php foreach ($this->headerImg as $value): ?>
        <?php echo '<img src="' . $value->pic_src . '" style="width:683px"/>' ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>







		
	