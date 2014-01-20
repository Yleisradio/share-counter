<script type="text/javascript">
    setInterval(function() {
        if ($('#added-sites-grid').length !== 0) {
            $.fn.yiiGridView.update('added-sites-grid');
        }
    }, 1000 * 60)
</script>

<h3><?php echo Yii::t('app', 'Choose One'); ?></h3>
<div class="row">
    <div class="span12">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'site-form',
            'action' => 'site/add',
            'htmlOptions' => array(
                'class' => 'well',
            ),
        ));
        ?>

        <?php echo $form->textFieldRow($site, 'url', array('data-placement' => 'right', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Web Address'), 'class' => 'span5', 'prepend' => '<i class="icon-globe"></i>')); ?>
        <div>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => Yii::t('app', 'Find Results'))); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
if (isset($sites)) {
    if (Yii::app()->user->getState('author'))
        echo CHtml::tag('h2', array(), Yii::t('app', 'Articles of user') . Yii::app()->user->getState('author'));
    else if (Yii::app()->user->getState('organization'))
        echo CHtml::tag('h2', array(), Yii::t('app', 'Articles of organization') . Yii::app()->user->getState('organization'));

    echo CHtml::tag('p', array(), Yii::t('app', 'Data is updated every 15 minutes.'));
    $this->widget('bootstrap.widgets.TbExtendedGridView', array_merge(array(
        'id' => 'sites-grid',
        'dataProvider' => $sites,
                    ), $gridViewSettings));
}
?>


<?php if (Yii::app()->user->getState('sites')) { ?>
    <h2><?php echo Yii::t('app', 'Previously used addresses'); ?></h2>
    <p><?php Yii::t('app', 'Data is updated every 15 minutes.') ?></p>
    <?php
    $this->widget('bootstrap.widgets.TbExtendedGridView', array_merge(array(
        'id' => 'added-sites-grid',
        'dataProvider' => $addedSites,
//    'filter' => $addedSites,
                    ), $gridViewSettings));
}
?>

