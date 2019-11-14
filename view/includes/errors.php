<?php
/**
 * @var array $errors
 */
foreach ($errors as $error) : ?>
    <h4 class="alert alert-dismissible alert-danger">
        <?= $error; ?>
    </h4>
<?php endforeach; ?>