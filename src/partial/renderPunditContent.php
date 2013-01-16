 <?php

function renderPunditContent ($s) {

?>
    <div class="feed-header pundit-disable-annotation">
            <span class="label label-warning"><?php echo $s->getLabel() ?></span>
            <a href="#" rel="popover" title="<?php echo $s->getDomain() ?>" data-placement="right" data-content="<?php echo $s->getComment() ?>"><i class="icon-info-sign"></i></a><br/>
    </div>
        <div class="feed-container clearfix"> 
 <?php echo $s->getPunditContent(); ?>
        </div>
<?php
}
