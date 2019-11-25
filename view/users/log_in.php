<div class="m-3">
    <div class="row">
        <div class="col-lg-6">
            <div class="jumbotron text-center">
                <h3>LOG IN</h3>
                <p>Enter username and password.</p>
                <form action="<?php echo URL; ?>user/postLogIn" method="POST">
                    <div class="form-group">
                        <label for="username">
                            <input type="text" name="username" class="form-control" placeholder="Username...">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="password">
                            <input type="password" name="password" class="form-control" placeholder="Password...">
                        </label>
                    </div>
                    <button type="submit" name="submit_log_in" class="btn btn-secondary">Log in</button>
                    <br>
                </form>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <?php require ROOT . 'view/includes/errors.php'; ?>
        </div>
    </div>
</div>
