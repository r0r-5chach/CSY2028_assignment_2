<main class="sidebar">
	<section class="left">
		<ul>
			<li><a href="/portal">Jobs</a></li>
			<?php if ($_SESSION['userType'] == 'admin') { ?>
				<li><a href="/portal/categories">Categories</a></li>
				<li><a href="/portal/users">Users</a></li>
			<?php } ?>
		</ul>
	</section>
	<section class="right">
	    <?php require $table?>
    </section>
</main>