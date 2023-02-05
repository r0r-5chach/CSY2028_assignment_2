<h2>Jobs</h2>
<a class="new" href="/portal/addJob">Add new job</a>
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
				<td><a style="float: right" href="portal/applicants?job_id=<?=$job->id?>">View applicants (<?=count($job->getApps())?>)</a></td>
				<td>
					<form method="post" action="portal/">
						<input type="hidden" name="job_id" value="<?=$job->id?>" />
						<?php if (date('y-m-d', strtotime($job->closingDate)) > date('y-m-d')) { ?>
							<input type="submit" name="submit" value="Archive" />
						<?php } 
							else { ?>
								<input type="submit" name="submit" value="List" />
						<?php } ?>
					</form>
				</td>
			</tr>
		<?php } ?>
	</thead>
</table>