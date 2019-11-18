<?php /** @var  $params */ ?>
<?php if (isset($params['roles'])) : ?>
    <div class="container">
        <!-- add role form -->
        <h3>Add a role</h3>
        <div class="box">
            <form action="<?php echo URL; ?>role/addRole" method="POST">
                <label>Role name</label>
                <input type="text" name="role" value="" required/>
                <input type="submit" name="submit_add_role" value="Submit"/>
            </form>
        </div>
        <!-- main content output -->
        <div class="box">
            <h3>List of roles</h3>
            <table>
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Id</td>
                    <td>Role</td>
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
                        <td><?php if (isset($role->role)) echo htmlspecialchars($role->role, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($role->deleted)) echo htmlspecialchars($role->deleted, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <?php /** @var  $roleIdCountUsers */ ?>
                            <?php if (isset($params['roleIdCountUsers'])) : ?>
                                <?php $roleIdCountUsers = $params['roleIdCountUsers'] ?>
                                <?php $countUser = false; ?>
                                <?php foreach ($roleIdCountUsers as $roleIdCountUser) : ?>
                                    <?php if ($roleIdCountUser->role_id == $role->id) : ?>
                                        <?php echo $roleIdCountUser->countUsers; ?>
                                        <?php $countUser = true; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!$countUser) : ?>
                                <?php echo "0"; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$role->deleted) : ?>
                                <a href="<?php echo URL . 'role/softDeleteRole/' . htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8'); ?>">soft
                                    delete</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo URL . 'role/editRole/' . htmlspecialchars($role->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
