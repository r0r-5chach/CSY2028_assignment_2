<ul>
    <li><a href="/">Home</a></li>
    <li>Jobs
        <ul>
            <?php foreach($cats as $cat) { ?>
                <li>
                    <a href="/jobs/category?page=<?=urlencode($cat->name)?>"><?=$cat->name?></a>
                </li>
            <?php } ?>    
        </ul>
    </li>
    <li><a href="/jobs/faq">FAQ</a></li>
    <li><a href="/jobs/about">About Us</a></li>
    <?php if (isset($_SESSION['loggedin'])) {?>
        <li><a href="/user/logout">Logout</a></li>
    <?php } 
    else {?>
        <li><a href="/user/login">Login</a></li>
    <?php } ?>
</ul>


