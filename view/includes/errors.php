<?php /**
 * @var array $params
 */?>
<?php if(!empty($params)) : ?>
<?php $errors = $params['errors']  ?>
<?php foreach ($errors as $error) : ?>
    <div class="text-center">
    <h4 class="alert alert-dismissible alert-danger">
        <?= $error; ?>
    </h4>
    </div>
<?php endforeach; ?>
<?php endif; ?>
