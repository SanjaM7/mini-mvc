<?php /** @var  $params */ ?>
<?php if (isset($params['roles'])) : ?>
    <div class="container">
        <!-- add role form -->
        <h3>Add a role</h3>
        <form action="<?php echo URL; ?>role/addRole" method="POST">
            <label>Role name</label>
            <input type="text" name="role" value="" required/>
            <input type="submit" name="submit_add_role" value="Submit"/>
        </form>
        <?php require ROOT . 'view/includes/errors.php'; ?>
        <!-- main content output -->
        <div class="box">
            <h3>List of roles</h3>
            <table>
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Id</td>
                    <td>Role Name</td>
                    <td>Deleted</td>
                    <td>Count of users</td>
                    <td>SOFT DELETE</td>
                    <td>EDIT</td>
                </tr>
                </thead>
                <tbody>
                <?php $roles = $params['roles'] ?>
                <?php foreach ($roles as $role) { ?>
                    <tr>
                        <td><?php if (isset($role->id)) echo htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($role->name)) echo htmlspecialchars($role->name, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($role->deleted)) echo htmlspecialchars($role->deleted, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($role->countOfUsers)) echo htmlspecialchars($role->countOfUsers, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php if (!$role->deleted) : ?>
                                <a href="<?php echo URL . 'role/' . htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8') . '/softDeleteRole'; ?>">soft
                                    delete</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo URL . 'role/' . htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8') . '/editRole'; ?>">edit</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
