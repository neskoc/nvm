<?php $uriFile = basename($_SERVER["REQUEST_URI"]); ?>

<aside class="sideclass container topBottomBordersIn">
    <nav>
        <ul>
        <?php
        foreach ($pages as $key => $value) :
            if ($key < 10) {
                $key = '0' . $key;
            }
            ?>
            <li>
                <a href="?page=<?= $key ?>" class='<?= preg_match("/page=$key/", $uriFile) ? "selected" : null ?>'>
                    <?= $value["title"] ?>
                </a>
            </li>
            <?php
        endforeach;
        if ($tableName == 'Object') :
            ?>
            <li>
                <a href="?page=-1" class='<?= preg_match("/page=-1/", $uriFile) ? "selected" : null ?>'>
                    :: Visa samtliga ::
                </a>
            </li>
        <?php endif; ?>
        </ul>
    </nav>
</aside>