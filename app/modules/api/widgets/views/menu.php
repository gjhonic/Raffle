<?php

/* @var $navigations array */
?>

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
    <span>
        <i class="fa fa-cloud"></i>
        API
    </span>
</h6>

<?php foreach ($navigations as $elem){
    ?>
    <li class="nav-item">
        <a class="nav-link" href="<?=$elem['href']?>"><?=$elem['label']?>
        </a>
    </li>
<?php } ?>