<ul>
<?php foreach ($jobs as $job) { ?>
    <li>
        <div class="details">
            <h2><?=$job->title?></h2>
            <h3><?=$job->salary?></h2>
            <p><?=nl2br($job->description)?></p>
            <a class="more" href="/apply.php">Apply for this job</a>
        </div>
    </li>
<?php } ?>
</ul>