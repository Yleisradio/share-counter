# Social Links
Web Analytics tool that visualizes the number of social interactions that link to a website.
Tracks Facebook, Twitter and LinkedIn actions.

## Requirements
- Yii Framework 1.1.14 ( http://www.yiiframework.com/download/ )
- PHP 5.1.6 or newer
- php5-curl
- MySQL-database
- Apache mod_rewrite plugin

## Installation
- git clone ssh://git@github.com/Yleisradio/social-links.git
- run the following commands:
```
cd social-links/protected
chmod o+x deploy.sh
./deploy.sh
```
- Modify the yii framework path in shared/config/bootstrap.php line 10
- Create MySQL priviledges and a database
- Add the database connection information to shared/config/commond.php lines 37-41
- run the following command:
```
./deploy.sh
```
- Add the next three rows to crontab (correct the paths if necessary)
```
*/5 * * * * php5 /var/www/social-links/protected/yiic.php update
*/5 * * * * php5 /var/www/social-links/protected/yiic.php addsites
0 3 * * * php5 /var/www/social-links/protected/yiic.php DeleteWeekOldLogs
```

## Update
- run the following commands:
```
git reset --hard
git pull ssh://git@github.com/Yleisradio/social-links.git
cd social-links/protected
./deploy.sh
```

