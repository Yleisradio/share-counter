<div class="row" id="escenic-search">
    <div class="span6">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'search-form',
            'htmlOptions' => array(
                'class' => 'well',
            ),
        ));
        ?>

        <?php echo $form->textFieldRow($author, 'username', array( 'class' => 'span5', 'prepend' => '<i class="icon-user"></i>', 'labelOptions' => array('required' => false))); ?>
        <div>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => Yii::t('app', 'Find Articles'))); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>

    <div class="span6">
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'search-form',
            'htmlOptions' => array(
                'class' => 'well',
            ),
        ));
        ?>

        <?php echo $form->textFieldRow($organization, 'name', array('data-placement' => 'right', 'data-toggle' => 'tooltip', 'title' => 'esim. 4921', 'class' => 'span5', 'prepend' => '<i class="icon-building"></i>')); ?>
        <div>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => Yii::t('app', 'Find Articles'))); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
