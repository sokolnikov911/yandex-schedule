PHP Yandex Schedule (rasp) API client
=====================================

[![Latest Stable Version](https://poser.pugx.org/sokolnikov911/yandex-schedule/v/stable)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![Total Downloads](https://poser.pugx.org/sokolnikov911/yandex-schedule/downloads)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![Latest Unstable Version](https://poser.pugx.org/sokolnikov911/yandex-schedule/v/unstable)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![License](https://poser.pugx.org/sokolnikov911/yandex-schedule/license)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![composer.lock](https://poser.pugx.org/sokolnikov911/yandex-schedule/composerlock)](https://packagist.org/packages/sokolnikov911/yandex-schedule)


Russian version of README you can find here: [README_RU.md](https://github.com/sokolnikov911/yandex-schedule/blob/master/README_RU.md).

Yandex Schedule (rasp) API client.


## Examples

**Retrieving schedule between two stations (for example: New Your airport and Moscow Sheremetyevo)**

```php
$client = new Client('yourApiKeyHere');

echo $client->getScheduleBetweenStations('NYC', 'SVO',
    Client::TRANSPORT_TYPE_PLANE, Client::SYSTEM_IATA);
```


**Retrieving schedule by station (for example: Kyiv-Passazhyrsky railway station)**

```php
echo $client->getScheduleOnStation('2200001', Client::TRANSPORT_TYPE_TRAIN, Client::SYSTEM_EXPRESS);
```

**Retrieving stations list for selected route (for example: train Berdyansk - Kiev)**

```php
echo $client->getListStationsRoute('228P_1_2');
```

**Retrieving carrier information (for example: Turkish Airlines)**

```php
echo $client->getCarrier('TK', Client::SYSTEM_IATA);
```

**Retrieving nearest stations**

```php
echo $client->getNearestStations('50.440046', '40.4882367', '40');
```

**Retrieving yandex copyright block**

```php
echo $client->getCopyright();
```


**Switching between data formats (XML and JSON available) and language versions (russian, ukrainian, turkish)**

By default using JSON format and russian language.


```php
$client->setDataFormat(Client::DATA_FORMAT_XML);
$client->setLanguage(Client::DATA_LANG_UK);
```



## Installing


```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of **yandex-schedule**

```bash
php composer.phar require sokolnikov911/yandex-schedule
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update **yandex-schedule** using composer:

 ```bash
composer.phar update
 ```
 
 
## Requirements

This client requires at least PHP7 (yeahh, type hinting!) and [Guzzle](https://github.com/guzzle/guzzle) 6.


## License

This library is licensed under the MIT License.