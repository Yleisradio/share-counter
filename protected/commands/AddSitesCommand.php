<?php

/**
 * This command reads RSS feeds and adds the new websites found to the database. Should be run every 5 minutes by crontab.
 */
class AddSitesCommand extends CConsoleCommand
{

    private $sites = array();

    public function run($args)
    {

        foreach (Yii::app()->params['feeds'] as $url) {
            var_dump($url);
            $rss = Curl::get($url);
            libxml_use_internal_errors(true);
            $rss = simplexml_load_string($rss);
            $this->parseRss($rss);
        }
        $this->getSites();
    }

    /**
     * Parse links, titles and publish time from RSS
     * @param type $rss
     */
    public function parseRss($rss)
    {
        if ($rss) {
            $rss = $rss->channel->item;
            foreach ($rss as $newsItem) {
                $site = array(
                    'url' => $newsItem->link,
                    'title' => $newsItem->title,
                    'published' => $newsItem->pubDate,
                );
                $this->sites[] = $site;
            }
        }
    }

    /**
     * Get canonical url of a web page by requesting the page and parsing the content of canonical html element
     * @param type $url
     * @return type
     */
    private function getCanonical($url)
    {
        if (isset(Yii::app()->params['skipCanonical'])) {
            foreach (Yii::app()->params['skipCanonical'] as $skipCanonical) {
                if (strpos($url, $skipCanonical) !== false) {
                    return $url;
                }
            }

            $parsedUrl = parse_url($url);
            $html = Curl::get($url, array(), array('log' => 'error'));
            $canonical = null;
            if (strpos($html, '<link rel="canonical" href="') !== 'false') {
                $canonical = strstr($html, '<link rel="canonical" href="');
                $canonical = substr($canonical, 28);
                $canonical = strstr($canonical, '"', true);
                $parsedCanonical = parse_url($canonical);
            }
            //Reconstruct canonical URL because it might be relative
            if ($canonical) {
                if (isset($parsedCanonical['scheme']))
                    $scheme = $parsedCanonical['scheme'];
                else
                    $scheme = $parsedUrl['scheme'];
                if (isset($parsedCanonical['host']))
                    $host = $parsedCanonical['host'];
                else
                    $host = $parsedUrl['host'];
                if (isset($parsedCanonical['path']))
                    $path = $parsedCanonical['path'];
                else
                    $path = $parsedUrl['path'];

                return $scheme . '://' . $host . $path;
            }
        }
        return $url;
    }

    /**
     * Save all the found sites to the database
     */
    public function getSites()
    {
        foreach ($this->sites as $siteData) {
            $url = Site::trimUrl($siteData['url']);
            if (strpos($url, '?') !== false) {
                $url = substr($url, 0, strpos($url, '?'));
            }
            $url = $this->getCanonical($url);
//            var_dump($url);
            $site = Site::model()->findByAttributes(array('url' => $url));
            $published = strtotime($siteData['published']);
            //If site is added manually it might be missing title and published. Add them now.
            if ($site) {
                if (!$site->published)
                    $site->published = $published;
                if (!$site->title)
                    $site->title;
            }
            else {
                $site = new Site();
                $site->url = $url;

                $site->title = $siteData['title'];
                $site->published = $published;
                //var_dump($site->attributes);
                $site->save();
                $site->id = Yii::app()->db->lastInsertId;
            }
        }
    }

}
