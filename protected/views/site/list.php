<script type="text/javascript">
    setInterval(function() {
        $.fn.yiiGridView.update('all-sites-grid');
    }, 1000 * 60)
</script>

<h2><?php Yii::t('app', 'Social Media Comparison') ?></h2>
<p><?php Yii::t('app', 'Data is updated every 15 minutes.') ?></p>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array_merge(array(
    'id' => 'all-sites-grid',
    'dataProvider' => $allSites->search(),
    'filter' => $allSites,
                ), $gridViewSettings));
?>