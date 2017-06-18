<?php

use YandexSchedule\Client;

require_once 'vendor/autoload.php';


$client = new Client('6579f3be-e11a-472f-8323-afa923dff260');

echo $client->getScheduleOnStation('2200001111', Client::TRANSPORT_TYPE_TRAIN, Client::SYSTEM_EXPRESS);
//echo $client->getCopyright();


//https://api.rasp.yandex.net/v1.0/search/?apikey=6579f3be-e11a-472f-8323-afa923dff260&format=json&from=KBP&to=NYC&lang=ru&transport_types=plane&system=iata
//https://api.rasp.yandex.net/v1.0/schedule/?lang=ru&format=json&from=IEV&to=NYC&transport_types=plane&system=iata&apikey=6579f3be-e11a-472f-8323-afa923dff260