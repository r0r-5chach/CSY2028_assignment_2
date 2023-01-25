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
    <?php if (isset($_SESSION['loggedin'])) {
        if ($_SESSION['userType'] == 'admin') {?>
            <li><a href="/admin">Admin Portal</a></li>
        <?php } 
        else if ($_SESSION['userType'] == 'client') {?>
            <li><a href="/client">Client Portal</a></li>
        <?php } ?>
        <li><a href="/user/logout">Logout</a></li>
    <?php } 
    else {?>
        <li><a href="/user/login">Login</a></li>
    <?php } ?>
</ul>


