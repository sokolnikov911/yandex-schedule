PHP Yandex Schedule (rasp) API client
=====================================


Yandex Schedule (rasp) API client.


## Examples

**Retrieving schedule between two stations (for example: New Your airport and Moscow Sheremetyevo)**

```
$client = new Client('yourApiKeyHere');

echo $client->getScheduleBetweenStations('NYC', 'SVO',
    Client::TRANSPORT_TYPE_PLANE, Client::SYSTEM_IATA);
```


**Retrieving schedule by station (for example: Kyiv-Passazhyrsky railway station)**

```
echo $client->getScheduleOnStation('2200001', Client::TRANSPORT_TYPE_TRAIN, Client::SYSTEM_EXPRESS);
```

**Retrieving schedule by station (for example: train Berdyansk - Kiev)**

```
echo $client->getListStationsRoute('228P_1_2');
```

**Retrieving carrier information (for example: Turkish Airlines)**

```
echo $client->getCarrier('TK', Client::SYSTEM_IATA);
```

**Retrieving nearest stations**

```
echo $client->getNearestStations('50.440046', '40.4882367', '40');
```

**Retrieving yandex copyright block**

```
echo $client->getCopyright();
```


**Switching between data formats (XML and JSON available) and language versions (russian, ukrainian, turkish)**

By default using JSON format and russian language.


```
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

This client requires at least PHP7 (yeahh, type hinting!) and [Guzzle](https://github.com/guzzle/guzzle) 6.2.3.


## License

This library is licensed under the MIT License.