# Kato ite
Web Analytics tool that visualizes the number of social interactions that link to a website.
Tracks Facebook, Twitter and LinkedIn actions.

## Requirements
- Yii Framework 1.1.14 ( http://www.yiiframework.com/download/ )
- PHP 5.1.6 or newer
- php5-curl
- MySQL-database
- Apache mod_rewrite plugin

## Installation
- git clone ssh://git@tools.yle.fi:443/glob/kato-ite.git
- cd kato-ite/protected
- ./deploy.sh
- Laita oikea yii-frameworkin polku static/config/bootstrap.php tiedostoon
- Luo MySQL käyttäjätunnus ja tietokanta
- Aja protected/data/schema.sql tietokantaan
- Konffaa tietokannan tiedot static/config/console.php tiedostoon
- Konffaa tietokannan tiedot static/config/development.php tiedostoon
- Konffaa tietokannan tiedot static/config/production.php tiedostoon
- ./deploy.sh
- Lisää seuraavat kolme riviä crontabiin ja korjaa yiic.php polku oikein 
- */5 * * * * php5 /var/www/kato-ite/protected/yiic.php update
- */5 * * * * php5 /var/www/kato-ite/protected/yiic.php addsites
- 0 3 * * * php5 /var/www/kato-ite/protected/yiic.php DeleteWeekOldLogs

## Päivitys
- git reset --hard
- git pull ssh://git@tools.yle.fi:443/glob/kato-ite.git
- cd kato-ite/protected
- ./deploy.sh

