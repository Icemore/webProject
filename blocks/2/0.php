<div id="post_it_adv">
    <table style="background: <?php echo $block->bgcolor ?>">
        <tbody>
        <tr>
            <td width="35">
                <button onclick="getPrev()"><</button>
            </td>
            <td width="80">
                <a href="<?php echo $adv[0]->url ?>">
                    <img src="http://localhost/adv_images/<?php echo $adv[0]->adv_id?>" width="50" height="50" alt="" title="Прокрутить влево">
                </a>
                <a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[0]->url ?>"> <?php echo $adv[0]->caption?> </a>
            </td>
            <td width="35">
                <button onclick="getNext()">></button>
            </td>
        </tr>
        </tbody>
    </table>
</div>