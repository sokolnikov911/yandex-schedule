<?php

namespace sokolnikov911\YandexSchedule;

require_once dirname(__DIR__) . '/vendor/autoload.php';


$client = new Client('1234f5be-e67a-890f-1234-afa456dff879');

echo $client->getScheduleOnStation('2200001111', Client::TRANSPORT_TYPE_TRAIN, Client::SYSTEM_EXPRESS);
