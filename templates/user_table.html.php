<h2>Users</h2>
<a class="new" href="/portal/addUser">Add new user</a>
<table>
    <thead>
	    <tr>
			<th>Username</th>
            <th>User Type</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
        </tr>
		<?php foreach ($users as $user) { ?>
		    <tr>
				<td><?=$user->username?></td>
				<td><a style="float: right" href="/portal/addUser?user_id=<?=$user->id?>">Edit</a></td>
				<td><form method="post" action="/portal/">
				    <input type="hidden" name="user_id" value="<?=$user->id?>" />
				    <input type="hidden" name="user_type" value="<?=$user->userType?>" />
				    <input type="submit" name="submit" value="Delete" />
				</form></td>
			</tr>
		<?php } ?>
	</thead>
</table>