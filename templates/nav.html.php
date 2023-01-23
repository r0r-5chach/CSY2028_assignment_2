<?php foreach($cats as $cat) { ?>
    <li>
        <a href="/jobs/category?page=<?=urlencode($cat->name)?>"><?=$cat->name?></a>
    </li>
<?php } ?>