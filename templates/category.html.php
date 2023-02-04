<main class = "sidebar">
    <section class="left">
        <ul>
			<?php foreach($cats as $cat) { ?>
        		<li>
            		<a href="/jobs/category?page=<?=urlencode($cat->name)?>"><?=$cat->name?></a>
        		</li>
    		<?php } ?> 
		</ul>
    </section>

    <section class="right">
        <h1> <?=$heading?> Jobs</h1>
        <form method="get" action="/jobs/category">
	        <label for="filter">Filter:</label>
	        <select name="filter">
		        <?php foreach ($jobs as $job) { ?>
			        <option value="<?=$job->location?>"><?=$job->location?></option>
		        <?php } ?>
	        </select>
			<input type="hidden" name="page" value="<?=$_GET['page']?>" />
	        <input type="submit" name="submit" value="filter" />
        </form>
        <ul class="listing">
            <?php require 'job.html.php';?>
        </ul>
    </section>
</main>