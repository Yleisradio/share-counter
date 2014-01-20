<?php

/**
 * This is the model class for table "apilog".
 *
 * The followings are the available columns in table 'apilog':
 * @property integer $id
 * @property integer $service
 * @property integer $timestamp
 * @property string $request
 * @property string $response
 */
class Apilog extends CActiveRecord
{

    const SERVICE_FACEBOOK = 1;
    const SERVICE_TWITTER = 2;
    const SERVICE_LINKEDIN = 3;
    const SERVICE_DIGITAL_ANALYTIX = 4;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'apilog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request, timestamp', 'required'),
            array('service, timestamp', 'numerical', 'integerOnly' => true),
            array('response', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, service, timestamp, request, response', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'service' => 'Service',
            'timestamp' => 'Timestamp',
            'request' => 'Request',
            'response' => 'Response',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('service', $this->service);
        $criteria->compare('timestamp', $this->timestamp);
        $criteria->compare('request', $this->request, true);
        $criteria->compare('response', $this->response, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Apilog the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeValidate()
    {
        $this->timestamp = time();
        $this->service = $this->determineService($this->request);
        return true;
    }

    public static function log($request, $response, $responseCode, $totalTime, $logLevel)
    {
        if (!$logLevel) {
            $logLevel = Yii::app()->params['apiLogLevel'];
        }
        if ($logLevel == 'all' || $responseCode != 200 && $logLevel == 'error') {
            $apilog = new Apilog();
            $apilog->request = print_r($request, true);
            $apilog->response = print_r($response, true);
            $apilog->response_code = $responseCode;
            $apilog->total_time = $totalTime;
            $apilog->save();
        }
    }

    protected function determineService($request)
    {
        if (is_array($request))
            $request = $request['url'];
        $servicePatterns = array(
            self::SERVICE_FACEBOOK => '.facebook.com',
            self::SERVICE_TWITTER => '.twitter.com',
            self::SERVICE_LINKEDIN => '.linkedin.com',
            self::SERVICE_DIGITAL_ANALYTIX => '.comscore.eu',
        );
        foreach ($servicePatterns as $service => $pattern) {
            if (strstr($request, $pattern)) {
                return $service;
                break;
            }
        }
    }

}
