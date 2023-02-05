<h2>Enquiries</h2>
<table>
    <thead>
	    <tr>
			<th>Name</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Enquiry</th>
            <th>Completed</th>
            <th>Handled by</th>
			<th style="width: 5%">&nbsp;</th>
			<th style="width: 5%">&nbsp;</th>
        </tr>
		<?php foreach ($enqs as $enq) { ?>
		    <tr>
				<td><?=$enq->name?></td>
				<td><?=$enq->email?></td>
				<td><?=$enq->telephone?></td>
				<td><?=$enq->enquiry?></td>
				<td><?=$enq->completed?></td>
				<td>
                    <?php 
                        if ($enq->getAdmin() == 'N/A') {
                            echo 'N/A';
                        }
                        else {
                            echo $enq->getAdmin()->username;
                        }
                    ?>
                </td>
				<?php if($enq->completed == 'n') { ?>
					<td>
						<form method="post" action="/portal/enquiries">
				    		<input type="hidden" name="enq_id" value="<?=$enq->id?>" />
				    		<input type="submit" name="submit" value="Complete" />
						</form>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</thead>
</table>