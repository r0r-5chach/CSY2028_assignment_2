<main class="home">
    <form method="post" action="/portal/addUser">
        <?php if ($update) {?>
                <label>Enter Username</label>
                <input type="username" name="username" value="<?=$user->username?>"/>
                <label>Enter Password</label>
                <input type="password" name="password" value=""/>
                <label>Enter User Type</label>
                <input type="text" name="type" value="<?=$user->userType?>"/>
                <input type="hidden" name="user_id" value="<?=$user->id?>" />
                <input type="submit" name="submit" value="Update"/>
        <?php }
            else { ?>
                <label>Enter Username</label>
                <input type="username" name="username" />
                <label>Enter Password</label>
                <input type="password" name="password" />
                <label>Enter User Type</label>
                <input type="text" name="type" />
                <input type="submit" name="submit" value="Create"/>
        <?php } ?>
    </form>
</main>