<?php

/**
 * This is the model class for table "metric".
 *
 * The followings are the available columns in table 'metric':
 * @property integer $id
 * @property integer $timestamp
 * @property integer $type
 * @property integer $value
 * 
 * The followings are the available model relations:
 * @property Site[] $site
 */
class Metric extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'metric';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('timestamp, type, value', 'required'),
            array('timestamp, type, value', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, timestamp, type, value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Metric the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function updateMetric($value = null)
    {
        $this->type = static::$_type;
        $this->timestamp = time();
        if (isset($value)) {
            $this->value = $value;
        } else {
            $this->value = $this->fetchValue();
        }
        $this->save();
        return $this->value;
    }

    public function toArray()
    {
        return array(
            'value' => (int) $this->value,
            'timestamp' => (int) $this->timestamp,
        );
    }

    public static function findAllBySiteId($siteId, $from, $to)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'site_id = :site_id AND type = :type';
        $criteria->params = array(
            'site_id' => $siteId,
            'type' => static::$_type,
        );
        if ($from) {
            $criteria->addCondition('timestamp >= :from');
            $criteria->params['from'] = $from;
        }
        if ($to) {
            $criteria->addCondition('timestamp <= :to');
            $criteria->params['to'] = $to + 60 * 60 * 24;
        }
        return self::model()->findAll($criteria);
    }

}
