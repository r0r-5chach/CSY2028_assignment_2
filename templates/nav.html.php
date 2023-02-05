<ul>
    <?php foreach($cats as $cat) { ?>
        <li>
            <a href="/jobs/category?page=<?=urlencode($cat->name)?>"><?=$cat->name?></a>
        </li>
    <?php } ?>    
</ul>
<?php if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['userType'] == 'admin') {?>
        <li><a href="/portal">Admin Portal</a></li>
<?php } 
    else if ($_SESSION['userType'] == 'client') {?>
        <li><a href="/portal">Client Portal</a></li>
<?php } ?>
        <li><a href="/user/logout">Logout</a></li>
<?php } 
    else {?>
        <li><a href="/user/login">Login</a></li>
<?php } ?>