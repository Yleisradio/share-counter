<?php

/**
 * Filter UI component
 */
class Filter extends CWidget
{
    public $from;
    public $to;
    public $active;
    
    public function init()
    {
    }

    public function run()
    {
        $filter = new FilterForm();
        $filter->from = $this->from;
        $filter->to = $this->to;
        $filter->dateRange = date('d', $filter->from) . '.' .  date('m', $filter->from) . '.' . date('Y', $filter->from) . ' - ' . date('d', $filter->to) . '.' .  date('m', $filter->to) . '.' . date('Y', $filter->to);
        $filter->startDate = date('Y', $filter->from) . date('m', $filter->from) . date('d', $filter->from);
        $filter->endDate = date('Y', $filter->to) . date('m', $filter->to) . date('d', $filter->to);
        $this->render('filter', array(
            'filter' => $filter,
        ));
    }

}