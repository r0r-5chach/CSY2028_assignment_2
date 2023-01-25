<main class="sidebar">
    <section class="left">
		<ul>
			<?=require 'nav.html.php'?>
		</ul>
	</section>

	<section class="right">
        <h2>Apply for <?=$job->title?></h2>
		<form action="/jobs/apply" method="POST" enctype="multipart/form-data">
			<label>Your name</label>
			<input type="text" name="name" />

		    <label>E-mail address</label>
			<input type="text" name="email" />

			<label>Cover letter</label>
			<textarea name="details"></textarea>

			<label>CV</label>
			<input type="file" name="cv" />

			<input type="hidden" name="jobId" value="<?=$job->id?>" />

			<input type="submit" name="submit" value="Apply" />

		</form>
</section>
</main>