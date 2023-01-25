<h2>Applicants for job</h2>
<table>
	<thead>
		<tr>
		    <th style="width: 10%">Name</th>
			<th style="width: 10%">Email</th>
			<th style="width: 65%">Details</th>
			<th style="width: 15%">CV</th>
		</tr>
		<?php foreach ($apps as $app) { ?>
			<tr>
				<td><?=$app->name?></td>
				<td><?=$app->email?></td>
				<td><?=$app->details?></td>
				<td><a href="/cvs/<?=$app->cv?>">Download CV</a></td>
			</tr>
		<?php } ?>
	</thead>
</table>