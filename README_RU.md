PHP клиент API Яндекс расписаний
=====================================

[![Latest Stable Version](https://poser.pugx.org/sokolnikov911/yandex-schedule/v/stable)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![Total Downloads](https://poser.pugx.org/sokolnikov911/yandex-schedule/downloads)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![Latest Unstable Version](https://poser.pugx.org/sokolnikov911/yandex-schedule/v/unstable)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![License](https://poser.pugx.org/sokolnikov911/yandex-schedule/license)](https://packagist.org/packages/sokolnikov911/yandex-schedule)
[![composer.lock](https://poser.pugx.org/sokolnikov911/yandex-schedule/composerlock)](https://packagist.org/packages/sokolnikov911/yandex-schedule)


PHP клиент API Яндекс расписаний.


## Примеры использования

**Получние раcписания движения транспорта между двумя заданными станциями (например: между аэропортом Нью-Йорка и московским Шереметьево**

```php
$client = new Client('yourApiKeyHere');

echo $client->getScheduleBetweenStations('NYC', 'SVO',
    Client::TRANSPORT_TYPE_PLANE, Client::SYSTEM_IATA);
```


**Получение раcписания для заданной станции (например: ж/д вокзал Киев-пассажирский)**

```php
echo $client->getScheduleOnStation('2200001', Client::TRANSPORT_TYPE_TRAIN, Client::SYSTEM_EXPRESS);
```


**Получение списка станций для заданного маршрута (например: ж/д маршрут Бердянск - Киев)**

```php
echo $client->getListStationsRoute('228P_1_2');
```


**Получение информации о перевозчике (например: Turkish Airlines)**

```php
echo $client->getCarrier('TK', Client::SYSTEM_IATA);
```


**Получение ближайших станций по заданным координатам**

```php
echo $client->getNearestStations('50.440046', '40.4882367', '40');
```


**Получение блока с копирайтом Яндекса**

```php
echo $client->getCopyright();
```


**Переключение между форматом загрузки данных (доступные форматы: XML и JSON ) и языковыми версяими (русский, украинский, турецкий)**

По-умолчанию используется формат JSON и русский язык.

```php
$client->setDataFormat(Client::DATA_FORMAT_XML);
$client->setLanguage(Client::DATA_LANG_UK);
```



## Установка

Устанавливаем Composer

```bash
curl -sS https://getcomposer.org/installer | php
```

Потом, запускаем команду композера для установки последней стабильной версии **yandex-schedule**

```bash
php composer.phar require sokolnikov911/yandex-schedule
```

После установки подключаем автолоадер композера:

```php
require 'vendor/autoload.php';
```

Позже вы можете обновлять **yandex-schedule** используя композер:

 ```bash
composer.phar update
 ```
 
 
## Требования

Этот API-клиент разработан для PHP7 (используется строгая типизация) и [Guzzle](https://github.com/guzzle/guzzle) 6.


## Лицензия

This library is licensed under the MIT License.