<main class="home">
    <h2>Log in</h2>

    <form action="/user/login" method="post" style="padding: 40px">
        <label>Enter Username</label>
        <input type="username" name="username" />

        <label>Enter Password</label>
        <input type="password" name="password" />

        <input type="submit" name="submit" value="Log In" />
        <input type="submit" name="submit" value="Register" />

    </form>
</main>
<p><?=nl2br($response)?></p>
