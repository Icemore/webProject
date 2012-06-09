<div id="post_it_adv">
    <table style="background: <?php echo $block->bgcolor ?>">
        <tbody>
        <tr>
            <td width="80">
                <button onclick="getPrev()"><</button><button onclick="getNext()">></button>
            </td>
        </tr>
        <tr>
            <td width="80">
                <p><a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[0]->url ?>"> <?php echo $adv[0]->caption?> </a></p>
                <p><a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[0]->url ?>"> <?php echo $adv[0]->text?> </a></p>
        </tr>
        </tbody>
    </table>
</div>