<?php

namespace sokolnikov911\YandexSchedule;

use sokolnikov911\YandexSchedule\Exceptions\YandexException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class Client
{
    private $key;
    private $dataFormat = self::DATA_FORMAT_JSON;
    private $lang       = 'ru_RU';
    private $apiUrl     = 'https://api.rasp.yandex.net/';
    private $apiVersion = 'v3.0';

    const DATA_FORMAT_JSON = 'json';
    const DATA_FORMAT_XML  = 'xml';

    const TRANSPORT_TYPE_PLANE = 'plane';
    const TRANSPORT_TYPE_TRAIN = 'train';
    const TRANSPORT_TYPE_SUBURBAN = 'suburban';
    const TRANSPORT_TYPE_BUS   = 'bus';
    const TRANSPORT_TYPE_SEA   = 'sea';
    const TRANSPORT_TYPE_RIVER = 'river';
    const TRANSPORT_TYPE_HELICOPTER = 'helicopter';

    const SYSTEM_YANDEX  = 'yandex';
    const SYSTEM_IATA    = 'iata';
    const SYSTEM_ICAO    = 'icao';
    const SYSTEM_SIRENA  = 'sirena';
    const SYSTEM_EXPRESS = 'express';
    const SYSTEM_ESR     = 'esr';

    const ENDPOINT_SEARCH    = 'search';
    const ENDPOINT_SCHEDULE  = 'schedule';
    const ENDPOINT_THREAD    = 'thread';
    const ENDPOINT_CARRIER   = 'carrier';
    const ENDPOINT_NEAREST_STATIONS = 'nearest_stations';
    const ENDPOINT_COPYRIGHT = 'copyright';

    const EVENT_ARRIVAL = 'arrival';
    const EVENT_DEPARTURE = 'departure';

    const SHOW_SYSTEMS_ALL    = 'all';
    const SHOW_SYSTEMS_YANDEX = 'yandex';
    const SHOW_SYSTEMS_ESR    = 'esr';


    /**
     * @param string $key API key
     *
     * @see https://developer.tech.yandex.ru/
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Sets format of response data
     *
     * @param string $format json|xml
     */
    public function setDataFormat(string $format)
    {
        $this->dataFormat = $format;
    }

    /**
     * Sets language of response data
     *
     * @param string $lang Language of data.
     */
    public function setLanguage(string $lang)
    {
        $this->lang = $lang;
    }

    /**
     * @param string $from Departure station code, for example NYC (for New York airport)
     * @param string $to Arrival station code, for example LED (for Saint Petersburg airport Pulkovo)
     * @param string $date Date to which you want to receive a list of flights. Should be specified in the format "YYYY-MM-DD". By default, the list of flights for all dates will be returned.
     * @param string $transportTypes Transport type
     * @param string $system
     * @param int $offset Offset of data.
     * @param string $showSystems System Code for answer
     *
     * @see https://tech.yandex.ru/rasp/doc/reference/schedule-point-point-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getScheduleBetweenStations(string $from, string $to, string $transportTypes, string $system,
                                               string $date = '', int $offset = 0, string $showSystems = '')
    {
        $queryArray = [
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'transport_types' => $transportTypes,
            'system' => $system,
            'offset' => $offset,
            'show_systems' => $showSystems
        ];

        return $this->getData($this->getEndpointUrl(self::ENDPOINT_SEARCH, $queryArray));
    }

    /**
     * @param string $station Departure station code, for example NYC (for New York airport)
     * @param string $date Date to which you want to receive a list of flights. Should be specified in the format "YYYY-MM-DD". By default, the list of flights for all dates will be returned.
     * @param string $transportTypes Transport type
     * @param string $system
     * @param string $event Event of schedule
     * @param string $showSystems System Code for answer
     * @param string $direction
     * @param int $offset Offset of data
     *
     * @see https://tech.yandex.ru/rasp/doc/reference/schedule-on-station-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getScheduleOnStation(string $station, string $transportTypes, string $system,
                                               string $event = '', string $direction = '', string $showSystems = '',
                                               string $date = '', int $offset = 0)
    {
        $queryArray = [
            'station' => $station,
            'event' => $event,
            'date' => $date,
            'transport_types' => $transportTypes,
            'system' => $system,
            'show_systems' => $showSystems,
            'direction' => $direction,
            'offset' => $offset
        ];

        return $this->getData($this->getEndpointUrl(self::ENDPOINT_SCHEDULE, $queryArray));
    }

    /**
     * @param string $uid
     * @param string $showSystems System Code for answer
     * @param string $date Date to which you want to receive a list of flights. Should be specified in the format "YYYY-MM-DD". By default, the list of flights for all dates will be returned.
     *
     * @see https://tech.yandex.ru/rasp/doc/reference/list-stations-route-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getListStationsRoute(string $uid, string $showSystems = '', string $date = '')
    {
        $queryArray = [
            'uid' => $uid,
            'date' => $date,
            'show_systems' => $showSystems,
        ];

        return $this->getData($this->getEndpointUrl(self::ENDPOINT_THREAD, $queryArray));
    }

    /**
     * @param string $code Code of carrier
     * @param string $system
     *
     * @see https://tech.yandex.ru/rasp/doc/reference/query-carrier-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getCarrier(string $code, string $system = '')
    {
        $queryArray = [
            'code' => $code,
            'system' => $system
        ];

        return $this->getData($this->getEndpointUrl(self::ENDPOINT_CARRIER, $queryArray));
    }

    /**
     * @param string $lat Latitude according to WGS84
     * @param string $lng Longitude according to WGS84
     * @param integer $distance Radius in km (from 0 to 50).
     * @param string $stationType
     * @param string $transportTypes Transport type
     * @param int $offset Offset of data.
     *
     * @see https://tech.yandex.ru/rasp/doc/reference/query-nearest-station-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getNearestStations(string $lat, string $lng, int $distance,
                                         string $stationType = '', string $transportTypes = '',
                                         int $offset = 0)
    {
        $queryArray = [
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance,
            'station_type' => $stationType,
            'transport_types' => $transportTypes,
            'offset' => $offset
        ];

        return $this->getData($this->getEndpointUrl(self::ENDPOINT_NEAREST_STATIONS, $queryArray));
    }

    /**
     * @see https://tech.yandex.ru/rasp/doc/reference/query-copyright-docpage/
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Data
     */
    public function getCopyright()
    {
        return $this->getData($this->getEndpointUrl(self::ENDPOINT_COPYRIGHT));
    }

    /**
     * @return string Used API version
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * Sends a request
     *
     * @param string $url Full URL of end-point
     *
     * @throws YandexException
     * @throws ClientException
     *
     * @return string Response body
     */
    protected function getData(string $url): string
    {
        $client = new HttpClient();

        try {
            $response = $client->get($url);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseData = $response->getBody()->getContents();

            if ($this->dataFormat == self::DATA_FORMAT_XML) {
                $xml = simplexml_load_string($responseData);
                $responseData = json_encode($xml, JSON_UNESCAPED_UNICODE);
            }

            $dataArray = json_decode($responseData, true);

            if ($dataArray['error'] && $dataArray['error']['text']) {
                throw new YandexException($dataArray['error']['text']);
            } else throw $e;
        }

        return $response->getBody();
    }

    /**
     * Sends a request
     *
     * @param string $type Type of end-point
     * @param array $dataArray Additional data
     *
     * @return string Full end-point URL
     */
    protected function getEndpointUrl(string $type, array $dataArray = []): string
    {
        $settingsArray = [
            'lang' => $this->lang,
            'format' => $this->dataFormat,
            'apikey' => $this->key
        ];

        return $this->apiUrl . $this->apiVersion . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR .
            '?' . http_build_query(array_merge($settingsArray, $dataArray));
    }
}