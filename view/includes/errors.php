<?php /**
 * @var array $params
 */ ?>
<?php if (!empty($params['errors'])) : ?>
    <?php $errors = $params['errors'] ?>
    <?php foreach ($errors as $error) : ?>
        <div class="text-left">
            <h4 class="alert alert-dismissible alert-danger">
                <?= $error; ?>
            </h4>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
