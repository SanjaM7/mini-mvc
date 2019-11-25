<?php /** @var  $params */ ?>
<?php if (isset($params['role'])) : ?>
    <?php $role = $params['role'] ?>
    <div class="container">
        <!-- add role form -->
        <h3>Edit a role</h3>
        <form action="<?php echo URL; ?>role/updateRole" method="POST">
            <label>Role</label>
            <input autofocus type="text" name="role"
                   value="<?php echo htmlspecialchars($role->name, ENT_QUOTES, 'UTF-8'); ?>" required/>
            <input type="hidden" name="role_id"
                   value="<?php echo htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8'); ?>"/>
            <input type="submit" name="submit_update_role" value="Update"/>
        </form>
        <?php require ROOT . 'view/includes/errors.php'; ?>
    </div>
<?php endif; ?>
