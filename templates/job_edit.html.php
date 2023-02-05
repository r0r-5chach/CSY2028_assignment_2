<main class="home">
    <h2>Update <?=$job->title?></h2>
    <form method="post" action="/portal/secondHome">
        <?php if ($job->archived == 'y') { ?>
            <label>Enter new Closing Date</label>
            <input type="date" name="closingDate"/>
            <input type="hidden" name="archived" value="n"/>
            <input type="hidden" name="jobId" value="<?=$job->id?>"/>
        <?php } ?>
        <input type="submit" name="submit" value="Update"/>
    </form>
</main>