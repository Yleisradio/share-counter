<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'filter-form',
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'well'),
        ));


$class = 'date-button';
if (!$this->active) {
    $class .= ' btn-primary';
}
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('app', 'All Time'),
    'id' => 'whole-time-button',
    'htmlOptions' => array(
        'class' => $class,
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('app', 'Publish Day'),
    'id' => 'first-day-button',
    'htmlOptions' => array(
        'class' => 'date-button',
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('app', 'Publish Week'),
    'id' => 'first-week-button',
    'htmlOptions' => array(
        'class' => 'date-button',
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('app', 'Today'),
    'id' => 'last-day-button',
    'htmlOptions' => array(
        'class' => 'date-button',
    ),
));


$class = 'date-button';
if ($this->active == 'last-week') {
    $class .= ' btn-primary';
}
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('app', 'Past Week'),
    'id' => 'last-week-button',
    'htmlOptions' => array(
        'class' => $class,
    ),
));

echo $form->dateRangeRow($filter, 'dateRange', array(
    'prepend' => '<i class="icon-calendar"></i>',
    'options' => array(
        'language' => 'fi',
        'locale' => array(
            'applyLabel' => 'Hae',
            'clearLabel' => "Tyhjennä",
            'fromLabel' => 'Alkaa',
            'toLabel' => 'Päättyy',
            'weekLabel' => 'V',
            'firstDay' => 1,
        ),
        'format' => 'dd.MM.yyyy',
        'callback' => 'js:function(start, end){
                    filter(start, end);
		}'
    ),
));

echo $form->hiddenField($filter, 'from', array('name' => 'from'));
echo $form->hiddenField($filter, 'to', array('name' => 'to'));
echo $form->hiddenField($filter, 'startDate', array('name' => 'startDate'));
echo $form->hiddenField($filter, 'endDate', array('name' => 'endDate'));
?> <div class='clearfix'></div> <?php
$this->endWidget();
?>
<script type='text/javascript'>
    $('#whole-time-button').click(function() {
        var start = new Date(<?php echo $filter->from * 1000; ?>);
        var end = new Date(<?php echo $filter->to * 1000; ?>);
        filter(start, end, this);
    });

    $('#first-day-button').click(function() {
        var start = new Date(<?php echo $filter->from * 1000; ?>);
        var end = new Date(<?php echo $filter->from * 1000; ?>);
        filter(start, end, this);
    });

    $('#first-week-button').click(function() {
        var start = new Date(<?php echo $filter->from * 1000; ?>);
        var end = new Date(<?php echo ($filter->from + 6 * 24 * 60 * 60) * 1000; ?>);
        filter(start, end, this);
    });

    $('#last-day-button').click(function() {
        var start = new Date(<?php echo $filter->to * 1000; ?>);
        var end = new Date(<?php echo $filter->to * 1000; ?>);
        filter(start, end, this);
    });

    $('#last-week-button').click(function() {
        var start = new Date(<?php echo ($filter->to - 6 * 24 * 60 * 60) * 1000; ?>);
        var end = new Date(<?php echo $filter->to * 1000; ?>);
        filter(start, end, this);
    });



    function filter(start, end, button) {
        $('#filter-form .btn-primary').removeClass('btn-primary');
        $(button).addClass('btn-primary');
        $('#FilterForm_dateRange').val(pad(start.getDate()) + '.' + (pad(start.getMonth() + 1)) + '.' + start.getFullYear() + ' - ' + pad(end.getDate()) + '.' + (pad(end.getMonth() + 1)) + '.' + end.getFullYear());
        $("#from").val(start.getTime() / 1000);
        $("#to").val(end.getTime() / 1000);
        $("#startDate").val("" + start.getFullYear() + (pad(start.getMonth() + 1)) + pad(start.getDate()));
        $("#endDate").val("" + end.getFullYear() + (pad(end.getMonth() + 1)) + pad(end.getDate()));
        loadData();
    }

</script>