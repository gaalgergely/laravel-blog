<?php if ($showLabel && $showField): ?>
<?php if ($options['wrapper'] !== false): ?>
<div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($showLabel && $options['label'] !== false && $options['label_show']): ?>
    <?= Form::customLabel($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

    <?php if ($showField): ?>
    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
            <img src="{{ $options['value'] }}">
        </div>
        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
        <div>
            <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><?= Form::input('file', $name, $options['value'], $options['attr']) ?></span>
            <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
        </div>
    </div>

    <?php include  resource_path('views') . '/vendor/laravel-form-builder/help_block.php' ?>
<?php endif; ?>

    <?php include  resource_path('views') . '/vendor/laravel-form-builder/errors.php' ?>

    <?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
</div>
<?php endif; ?>
<?php endif; ?>