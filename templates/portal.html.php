<main class="sidebar">
	<section class="left">
		<ul>
			<li><a href="/portal">Jobs</a></li>
			<?php if ($_SESSION['userType'] == 'admin') { ?>
				<li><a href="/portal/categories">Categories</a></li>
			<?php } ?>
		</ul>
	</section>
	<section class="right">
	    <?=require $table;?>
    </section>
</main>