
<div class="title"><h5>接口列表</h5></div>
<?php foreach ($data as $k=>$v):?>
<div class="widget first">
            <div class="head"><h5 class="iCreate"><?=$k?></h5></div>
            <div class="body">
                <?php foreach ($v as $link):?>
                <h5 class="pt10"><a href="<?=$link?>" target="_blank"><?=$link?></a></h5>
                <?php endforeach;?>
            </div>
</div>
<?php endforeach;?>
