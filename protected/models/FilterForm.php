<?php

class FilterForm extends CFormModel
{

    public $from;
    public $to;
    public $startDate;
    public $endDate;
    public $dateRange;

    public function attributeLabels()
    {
        return array(
            'dateRange' => Yii::t('app', 'Time Period'),
        );
    }

}