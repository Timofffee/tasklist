<div class="container">
    <h1>Sign in</h1>
    <form action="/auth" method="post">
        <input type="text" placeholder="Login" name="login" value="<?=$data['login']?>">
        <input type="password" placeholder="Password" name="pass" value="<?=$data['pass']?>">
        <?php if ($data['error'] == 1): ?> 
            <p class="error"> Fill in all fields </p>
        <? elseif ($data['error'] == 2): ?>
            <p class="error"> Incorrect password </p>
        <? endif; ?>
        <input type="submit" value="Login" name="submit">
    </form>
</div>

