 <?php

function renderPunditContent ($s, $pos = null) {

?>
    <div class="feed-header pundit-disable-annotation">

        <?php if ($prev = $s->getPrev($pos)) { ?>
            <span class="label label-info prev">
                <a href="<?php echo $prev ?>"><i class="icon-chevron-left"></i>Previous</a>
            </span>
        <?php } ?>
        <?php if ($s->type=='Page' && $book = $s->getBookLink()) { ?>
            <span class="label label-important prev">
                <a href="<?php echo $book ?>"><i class="icon-chevron-up"></i>Entire work</a>
            </span>
        <?php } ?>    
            <span>
                <span class="label label-warning"><?php echo $s->getLabel() ?></span>
                <a href="#" rel="popover" title="<?php echo $s->getDomain() ?>" data-placement="right" data-content="<?php echo $s->getComment() ?>"><i class="icon-info-sign"></i></a>
            </span>

        <?php if ($next = $s->getNext($pos)) { ?>
            <span class="label label-info next">
                <a href="<?php echo $next ?>">Next <i class=" icon-chevron-right"></i></a>
            </span>
        <?php } ?>

    </div>
    <div class="feed-container clearfix"> 
        <?php echo $s->getContent(); ?>        
    </div>
    
<?php
}
