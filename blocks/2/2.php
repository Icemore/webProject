<div id="post_it_adv">
<table style="background: <?php echo $block->bgcolor ?>">
    <tbody>
    <tr>
        <td width="35">
            <button onclick="getPrev()"><</button> <button onclick="getNext()">></button>
        </td>
    </tr>
    <tr>
        <td width="80">
            <a href="<?php echo $adv[0]->url ?>">
                <img src="http://localhost/adv_images/<?php echo $adv[0]->adv_id?>" width="50" height="50" alt="" title="Прокрутить влево">
            </a>
            <a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[0]->url ?>"> <?php echo $adv[0]->caption?> </a>
        </td>
    </tr>
    <tr>
        <td width="80">
            <a href="<?php echo $adv[1]->url ?>">
                <img src="http://localhost/adv_images/<?php echo $adv[1]->adv_id?>" width="50" height="50" alt="" title="Прокрутить влево">
            </a>
            <a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[1]->url ?>"> <?php echo $adv[1]->caption?> </a>
        </td>
    </tr>
    <tr>
        <td width="80">
            <a href="<?php echo $adv[2]->url ?>">
                <img src="http://localhost/adv_images/<?php echo $adv[2]->adv_id?>" width="50" height="50" alt="" title="Прокрутить влево">
            </a>
            <a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[2]->url ?>"> <?php echo $adv[2]->caption?> </a>
        </td>
    </tr>
    </tbody>
</table>
</div>