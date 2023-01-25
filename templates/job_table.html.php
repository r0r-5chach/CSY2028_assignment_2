<h2>Jobs</h2>
<a class="new" href="addjob.php">Add new job</a>
<table>
    <thead>
	    <tr>
		    <th>Title</th>
			<th style="width: 15%">Salary</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 15%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
		</tr>
        <?php foreach ($jobs as $job) { ?>
		    <tr>
				<td><?=$job->title?></td>
				<td><?=$job->salary?></td>
				<td><a style="float: right" href="portal/edit?id=<?=$job->id?>">Edit</a></td>
				<td><a style="float: right" href="applicants.php?id=<?=$job->id?>">View applicants (count)</a></td>
				<td><form method="post" action="portal/delete">
				    <input type="hidden" name="id" value="<?=$job->id?>" />
				    <input type="submit" name="submit" value="Delete" />
				</form></td>
			</tr>
		<?php } ?>
	</thead>
</table>