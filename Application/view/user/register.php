<div class="jumbotron text-center">
    <h3>REGISTER</h3>
    <p>It’s quick and easy.</p>
    <form action="<?php echo URL; ?>user/postRegister" method="POST">
        <div class="form-group">
            <label for="username">
                <input type="text" name="username" class="form-control" placeholder="Username..." >
            </label>
        </div>
        <div class="form-group">
            <label for="email">
                <input type="text" name="email" class="form-control" placeholder="Email...">
            </label>
        </div>
        <div class="form-group">
            <label for="password">
                <input type="password" name="password" class="form-control" placeholder="Password...">
            </label>
        </div>
        <div class="form-group">
            <label for="passwordRepeat">
                <input type="password" name="passwordRepeat" class="form-control" placeholder="Repeat password...">
            </label>
        </div>
        <button type="submit" name="submit_register" class="btn btn-secondary">Register</button><br>
    </form>
</div>
</div>

