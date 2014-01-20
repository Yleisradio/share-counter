<?php
/*
 * Test checks, that AddSiteCommand work properly.
 */
class AddSitesCommandTest extends CDbTestCase {

    public $fixtures = array(
        'sites' => 'Site',
    );
    
    protected $rss = '
        <rss xmlns:content = "http://purl.org/rss/1.0/modules/content/" version = "2.0">
        <channel>
        <title>Yle Uutiset | Pääuutiset</title>
        <link>http://yle.fi/uutiset/</link>
        <description>Yle Uutiset | Pääuutiset</description>
        <category>Pääuutiset</category>
        <item>
        <title>
            Kartta: Helsingin arvopaikoille on tunkua – suurkirjasto, museoita ja vielä Guggenheim
        </title>
        <link>http://yle.fi/uutiset/kartta_helsingin_arvopaikoille_on_tunkua__suurkirjasto_museoita_ja_viela_guggenheim/6841056?origin=rss</link>
        <description>
        Helsingissä on edessä poikkeuksellisen laaja kulttuurirakentamisen buumi, jos kaikki vireillä olevat hankkeet toteutuvat. Myös Kansallismuseolla on valmis laajennussuunnitelma.
        </description>
        <pubDate>Mon, 23 Sep 2013 11:23:58 +0300</pubDate>
        <category>Uutiset</category>
        <category>Kulttuuri</category>
        <category>Helsinki</category>
        <guid isPermaLink = "false">http://yle.fi/uutiset/6841056</guid>
        </item>
        </channel>
        </rss>';

    public function testRun() {
        $addSitesCommand = new AddSitesCommand(array(), null);
        libxml_use_internal_errors(true);
        $rss = simplexml_load_string($this->rss);
        $addSitesCommand->parseRss($rss);
        $addSitesCommand->getSites();
     
      
       $this->assertNotNull(Site::model()->findByAttributes(array('url' => 'http://yle.fi/uutiset/kartta_helsingin_arvopaikoille_on_tunkua__suurkirjasto_museoita_ja_viela_guggenheim/6841056' )));
    }

}
