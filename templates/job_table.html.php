<h2>Jobs</h2>
<a class="new" href="addjob.php">Add new job</a>
<form method="get" action="/portal">
	<label for="filter">Filter:</label>
	<select name="filter">
		<?php foreach ($cats as $cat) { ?>
			<option value="<?=$cat->id?>"><?=$cat->name?></option>
		<?php } ?>
	</select>
	<input type="submit" name="submit" value="filter" />
</form>
<table>
    <thead>
	    <tr>
		    <th>Title</th>
			<th style="width: 15%">Salary</th>
			<th>Category</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 15%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
		</tr>
        <?php foreach ($jobs as $job) { ?>
		    <tr>
				<td><?=$job->title?></td>
				<td><?=$job->salary?></td>
				<td><?=$job->getCat()->name?></td>
				<td><a style="float: right" href="portal/edit?job_id=<?=$job->id?>">Edit</a></td>
				<td><a style="float: right" href="portal/applicants?app_id=<?=$job->id?>">View applicants (count)</a></td>
				<td><form method="post" action="portal/">
				    <input type="hidden" name="job_id" value="<?=$job->id?>" />
				    <input type="submit" name="submit" value="Delete" />
				</form></td>
			</tr>
		<?php } ?>
	</thead>
</table>