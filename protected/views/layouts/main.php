<?php
$this->beginContent('//layouts/base');

$items = array(
    array('label' => Yii::t('app', 'Search'), 'url' => array('/')),
    array('label' => Yii::t('app', 'Comparison'), 'url' => array('/vertailu')),
);
$this->widget('bootstrap.widgets.TbNavbar', array(
    'brand' => false,
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $items,
        )
    )
));
?>
<div class="container top-container">
    <?php echo $content; ?>

    <div class="row" id="feedback-row">
        <div class="span12">
            <div class="well">
                <?php echo Yii::t('app', 'You can send feedback about the service to: '); ?> <a href='mailto: <?php echo Yii::app()->params['feedbackEmailAddress']; ?>'><?php echo Yii::app()->params['feedbackEmailAddress']; ?></a>
            </div>
        </div>
    </div>
</div>
<?php
$this->endContent();