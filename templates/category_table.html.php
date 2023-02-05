<h2>Categories</h2>
<a class="new" href="/portal/addCategory">Add new category</a>
<table>
    <thead>
	    <tr>
			<th>Name</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
        </tr>
		<?php foreach ($cats as $cat) { ?>
		    <tr>
				<td><?=$cat->name?></td>
				<td><a style="float: right" href="/portal/edit?cat_id=<?=$cat->id?>">Edit</a></td>
				<td><form method="post" action="/portal/">
				    <input type="hidden" name="cat_id" value="<?=$cat->id?>" />
				    <input type="submit" name="submit" value="Delete" />
				</form></td>
			</tr>
		<?php } ?>
	</thead>
</table>