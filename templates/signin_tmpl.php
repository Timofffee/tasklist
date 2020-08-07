<?php

require_once __DIR__ . "/head_tmpl.php";

function render_page() { ?>
    <!DOCTYPE html>
    <html lang="en">
    <? render_head("Sign in") ?>
    <body>
        <body>
            <div class="container">
                <h1>Sign in</h1>
                <form action="" method="post">
                    <input type="text" placeholder="Login" name="login">
                    <input type="password" placeholder="Password" name="pass">
                    <?php if ($incorrect_pass == 1): ?> 
                        <p> Fill in all fields </p>
                    <? elseif ($incorrect_pass == 2): ?>
                        <p> Incorrect password </p>
                    <? endif; ?>
                    <input type="submit" value="Login" name="submit">
                </form>
            </div>
            
        </body>
    </body>
    </html>
<? }

