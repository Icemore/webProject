<div id="post_it_adv">
    <table style="background: <?php echo $block->bgcolor ?>">
        <tbody>
        <tr>
            <td width="35">
                <button onclick="getPrev()"><</button>
            </td>
            <td width="100">
                <a style="color: <?php echo $block->txtcolor ?>" href="<?php echo $adv[0]->url ?>"> <?php echo $adv[0]->text?> </a>
            </td>
            <td width="35">
                <button onclick="getNext()">></button>
            </td>
        </tr>
        </tbody>
    </table>
</div>