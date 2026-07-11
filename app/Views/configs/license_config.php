<?php
/**
 * @var array $licenses
 */
?>

<?= form_open('', ['id' => 'license_config_form', 'enctype' => 'multipart/form-data', 'class' => 'config-form']) ?>
    <div class="config-wrapper">
        

            <?php
            $counter = 0;
            foreach ($licenses as $license) {
            ?>
                <div class="form-group mb-4">
                    <?= form_label($license['title'], 'license', ['class' => 'form-label']) ?>
                    <div>
                        <?= form_textarea([
                            'name'     => 'license',
                            'id'       => 'license_' . $counter++,    // TODO: String Interpolation
                            'class'    => 'form-control font-monospace',
                            'rows'     => '14',
                            'readonly' => '',
                            'value'    => $license['text']
                        ]) ?>
                    </div>
                </div>
            <?php } ?>

        
    </div>
<?= form_close() ?>
