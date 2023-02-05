<main class="home">
    <form method="post" action="/portal/addJob">
           <?php if ($update) {?>
                <input type="hidden" name="archived" value="<?=$job->archived?>"/>
                <label>Enter Job Title</label>
                <input type="text" name="title" value="<?=$job->title?>"/>
                <label>Enter Job Description</label>
                <input type="text" name="description" value="<?=$job->description?>"/>
                <label>Enter Salary</label>
                <input type="text" name="salary" value="<?=$job->salary?>"/>
                <label>Enter Closing Date</label>
                <input type="date" name="closingDate" value="<?=$job->closingDate?>"/>
                <label>Enter Category Name</label>
                <input type="text" name="categoryName" value="<?=$job->getCat()->name?>"/>
                <label>Enter Location</label>
                <input type="text" name="location" value="<?=$job->location?>"/>
                <input type="hidden" name="client_id" value="<?=$job->clientId?>" />
                <input type="hidden" name="jobId" value="<?=$job->id?>"/>
                <input type="submit" name="submit" value="Update"/>
        <?php }
            else if ($archive) { ?>
                <input type="hidden" name="archived" value="n"/>
        <?php }
            else { ?>
                <input type="hidden" name="archived" value="n"/>
                <label>Enter Job Title</label>
                <input type="text" name="title"/>
                <label>Enter Job Description</label>
                <input type="text" name="description"/>
                <label>Enter Salary</label>
                <input type="text" name="salary"/>
                <label>Enter Closing Date</label>
                <input type="date" name="closingDate"/>
                <label>Enter Category Name</label>
                <input type="text" name="categoryName"/>
                <label>Enter Location</label>
                <input type="text" name="location"/>
                <input type="hidden" name="client_id" value="<?=$_SESSION['loggedin']?>" />
                <input type="submit" name="submit" value="Create"/>
        <?php } ?>
    </form>
</main>