<?php /** @var  $params */ ?>
<div class="container">
    <!-- main content output -->
    <?php if (isset($params['count_of_users'])) : ?>
        <?php $count_of_users = $params['count_of_users'] ?>
        <h3>Count of users:
        <span>
            <?php echo $count_of_users ?>
        </span>
        </h3>
    <?php endif; ?>
    <div class="box">
        <?php if (isset($params['users'])) : ?>
        <?php $users = $params['users'] ?>
        <?php if (empty($users)) : ?>
            <p>There are no users</p>
        <?php else : ?>
            <h3>List of users</h3>
            <table>
                <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Id</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>EDIT USER ROLE</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php if (isset($user->id)) echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($user->username)) echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php if (isset($user->email)) echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php if (isset($params['roles'])) : ?>
                            <?php $roles = $params['roles'] ?>
                            <?php foreach ($roles as $role) : ?>
                                <?php if ($user->role_id == $role->id) : ?>
                                    <td>
                                        <?php if (isset($user->role_id)) echo htmlspecialchars($role->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo URL . 'user/' . htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8') . '/editUserRole'; ?>">edit</a>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>
</div>
