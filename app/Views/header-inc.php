<header class="main-header" style="background: url('<? if (!empty($this->headerImg)) echo $this->headerImg[0]->pic_src; ?>') 10% 20%  no-repeat;background-size: cover;">
    <div class="main-header-title">
        <span>
            <?= $this->eventData->title; ?>
        </span>
    </div>

    <div class="main-header-phone">
        <span>
            <?= $this->eventData->phone; ?>
        </span>
    </div>
<div class="button-back"><a href="<?= 'https://' . $_SERVER['SERVER_NAME'] . '/tickets/list?getiframe=' . $this->hash ?>">НАЗАД</a><div>
</header>