<?php /** @var  $params */ ?>
<?php if (isset($params['user'])) : ?>
    <?php $user = $params['user'] ?>
    <div class="container">
        <h3>Edit a user role</h3>
        <div class="box">
            <form action="<?php echo URL; ?>user/updateUserRole" method="POST">
                <?php if (isset($params['roles'])) : ?>
                    <?php $roles = $params['roles'] ?>
                    <label>User role</label>
                    <select name="role_id">
                        <?php foreach ($roles as $role) : ?>
                            <option value="<?php echo $role->id; ?>" <?php echo ($role->id == $user->role_id) ? "selected" : "";?> >
                                <?php echo $role->role; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <input type="hidden" name="user_id"
                       value="<?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?>"/>
                <input type="submit" name="submit_update_user_role" value="Update"/>
            </form>
        </div>
    </div>
<?php endif; ?>
