<main class="home">
    <form method="post" action="/portal/addCategory">
        <label>Enter Category Name</label>
        <?php if($update) { ?>
            <input type="text" name="name" value="<?=$cat->name?>"/>
            <input type="hidden" name="id" value="<?=$cat->id?>"/>
            <input type="submit" name="submit" value="Update"/>
        <?php }
            else { ?>
                <input type="text" name="name"/>
                <input type="submit" name="submit" value="Create"/>
        <?php } ?>

    </form>
</main>