<?php

/**
 * This is the model class for table "site".
 *
 * The followings are the available columns in table 'site':
 * @property integer $id
 * @property string $url
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Metric[] $metrics
 */
class Site extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'site';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url', 'required'),
            array('updated', 'numerical', 'integerOnly' => true),
            array('url', 'length', 'max' => 512),
            array('facebook_shares, facebook_likes, facebook_comments, twitter_tweets, linkedin_shares, not_changed, title, published, shares_per_hour', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, url, updated,', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'metrics' => array(self::HAS_MANY, 'Metric', 'site_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'url' => Yii::t('app', 'Web Address'),
            'updated' => 'Updated',
            'facebook_shares' => Yii::t('app', 'Facebook Shares'),
            'facebook_comments' => Yii::t('app', 'Facebook Comments'),
            'facebook_likes' => Yii::t('app', 'Facebook Likes'),
            'linkedin_shares' => Yii::t('app', 'LinkedIn Shares'),
            'twitter_tweets' => Yii::t('app', 'Tweets'),
            'shares_per_hour' => Yii::t('app', 'Shares Per Hour'),
            'title' => Yii::t('app', 'Title'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Site the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateMetrics() {
        $facebookData = FacebookUpdater::updateFacebook($this->id, $this->url);
        $tweet = new Tweet();
        $tweet->site_id = $this->id;
        $twitterTweets = $tweet->updateMetric();
        $linkedInShare = new LinkedInShare();
        $linkedInShare->site_id = $this->id;
        $linkedInShares = $linkedInShare->updateMetric();
//        $googlePlusShare = new GooglePlusShare();
//        $googlePlusShare->site_id = $this->id;
//        $googlePlusShares = $googlePlusShare->updateMetric();
        //Check if number of social interactions changed
        $changed = false;
        if ($this->facebook_shares != $facebookData['share_count'])
            $changed = true;
        if ($this->facebook_likes != $facebookData['like_count'])
            $changed = true;
        if ($this->facebook_comments != $facebookData['comment_count'])
            $changed = true;
        if ($this->twitter_tweets != $twitterTweets)
            $changed = true;
        if ($this->linkedin_shares != $linkedInShares)
            $changed = true;
        if ($changed)
            $this->not_changed = 0;
        else
            $this->not_changed++;

        $newShares = $facebookData['share_count'] + $twitterTweets + $linkedInShares;
        $this->updateSharesPerHour($newShares);

        //Save number of social interactions
        $this->facebook_shares = $facebookData['share_count'];
        $this->facebook_likes = $facebookData['like_count'];
        $this->facebook_comments = $facebookData['comment_count'];
        $this->twitter_tweets = $twitterTweets;
        $this->linkedin_shares = $linkedInShares;

        $this->updated = time();
        $this->save();
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('updated', $this->updated);
        $criteria->compare('facebook_shares', $this->facebook_shares);
        $criteria->compare('facebook_comments', $this->facebook_comments);
        $criteria->compare('facebook_likes', $this->facebook_likes);
        $criteria->compare('linkedin_shares', $this->linkedin_shares);
        $criteria->compare('twitter_tweets', $this->twitter_tweets);
        $criteria->compare('shares_per_hour', $this->shares_per_hour);

        $sort = new CSort();
        $sort->defaultOrder = array(
            'shares_per_hour' => CSort::SORT_DESC,
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    public function updateSharesPerHour($newShares) {
        if ($this->updated) {
            $oldShares = $this->twitter_tweets + $this->linkedin_shares + $this->facebook_shares;
            $this->shares_per_hour = round(($newShares - $oldShares) / ((time() - $this->updated) / 60 / 60));
            if ($this->shares_per_hour < 0)
                $this->shares_per_hour = 0;

            $sharesPerHour = new SharesPerHour();
            $sharesPerHour->site_id = $this->id;
            $sharesPerHour->value = $this->shares_per_hour;
            $sharesPerHour->type = SharesPerHour::$_type;
            $sharesPerHour->timestamp = time();
            $sharesPerHour->save();
        }
        else {
            return 0;
        }
    }

    public function getTitle() {
        if ($this->title) {
            return $this->title;
        } else {
            return $this->url;
        }
    }

    /**
     * Remove trailing slash
     * Remove url parameters
     * Remove protocol
     */
    public static function trimUrl($url) {
        $parsedUrl = parse_url($url);
        $trimmedUrl = '';
        if (isset($parsedUrl['scheme']))
            $trimmedUrl = $parsedUrl['scheme'] . '://';
        if (isset($parsedUrl['host']))
            $trimmedUrl .= $parsedUrl['host'];
        if (isset($parsedUrl['path']))
            $trimmedUrl .= $parsedUrl['path'];

        //Remove trailing slash
        $trimmedUrl = rtrim($trimmedUrl, '/');

        $trimmedUrl = strtolower($trimmedUrl);
        return $trimmedUrl;
    }
    
    public static function gridViewSettings() {
        return array(
            'type' => 'striped bordered condensed',
            'summaryText' => false,
            'afterAjaxUpdate' => 'function() { jQuery("abbr.timeago").timeago(); }',
            'responsiveTable' => true,
            'columns' => array(
                array(
                    'name' => 'title',
                    'value' => 'CHtml::link(Html::truncate($data->getTitle(), 55), Yii::app()->createUrl("site/data", array("url" => $data["url"])))',
                    'type' => 'raw',
                    'headerHtmlOptions' => array(
                        'width' => '500px',
                    )
                ),
                array(
                    'header' => Yii::t('app', 'Published'),
                    'name' => 'published',
                    'value' => 'Timeago::timeagoOrUnknown($data["published"])',
                    'type' => 'raw',
                    'headerHtmlOptions' => array(
                        'width' => '150px',
                    )
                ),
                array(
                    'name' => 'shares_per_hour',
                    'value' => 'number_format($data["shares_per_hour"], 0, ",", " ")',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'facebook_shares',
                    'value' => 'number_format($data["facebook_shares"], 0, ",", " ")',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'linkedin_shares',
                    'value' => 'number_format($data["linkedin_shares"], 0, ",", " ")',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'twitter_tweets',
                    'value' => 'number_format($data["twitter_tweets"], 0, ",", " ")',
                    'type' => 'raw',
                ),
            )
        );
    }

    public function getShares() {
        return $this->facebook_shares + $this->twitter_tweets + $this->linkedin_shares;
    }

    public function getFacebookTotal() {
        return $this->facebook_shares + $this->facebook_likes + $this->facebook_comments;
    }

    public function isAttributeRequired($attribute) {
        return false;
    }

    public function getUrl() {
        if (strpos($this->url, 'http://') === false && strpos($this->url, 'https://') === false) {
            return $this->url = 'http://' . $this->url;
        } else {
            return $this->url;
        }
    }

}
