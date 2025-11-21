<?php
    $page = ceil($total / $limit);
    $active = (($offset / $limit ) +1 );
?>

<ul class="pagination">
    <?php if($page > 1) : ?>
        <li class="page-item previous <?= ($active == 1) ? 'disabled' : '' ?>"><a href="<?= $url.'/'.($offset - $limit).$parameter; ?>" class="page-link"><i class="previous"></i></a></li>
        <?php for($i = 1; $i <= $page; $i++) { ?>
        <li class="page-item <?= ($active == $i) ? 'active' : ''; ?>"><a href="<?= $url.'/'.(($i - 1) * $limit).$parameter; ?>" class="page-link"><?= $i; ?></a></li>
        <?php } ?>
        <li class="page-item next <?= ($active >= $page) ? 'disabled' : '' ?>"><a href="<?= $url.'/'.($offset + $limit).$parameter; ?>"  class="page-link"><i class="next"></i></a></li>
    <?php else : ?>
        <li class="page-item active"><a class="page-link">1</a></li>
    <?php endif;?>
</ul>