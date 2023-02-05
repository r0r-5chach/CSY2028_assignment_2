<main class="home">
    <form method="post" action="/portal/addJob">
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
    </form>
</main>