$adv=getAdv(1);

?>
<?php echo $adv[0]->adv_id ?>
<p><a href="http://localhost/api/click.php?block_id=<?php echo $block->block_id ?>&adv_id=<?php echo $adv[0]->adv_id?>">go!</a></p>

<?php

