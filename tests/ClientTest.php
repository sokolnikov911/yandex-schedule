<?php

namespace sokolnikov911\YandexSchedule;

use PHPUnit\Framework\TestCase;

class FeedTest extends TestCase
{
    const KEY = '1234f5be-e67a-890f-1234-afa456dff879';
    const API_URL = 'https://api.rasp.yandex.net/';

    protected $client;

    protected function setUp()
    {
        $this->client = new Client(self::KEY);
    }

    public function testDefaultFormat()
    {
        $this->assertAttributeSame(Client::DATA_FORMAT_JSON, 'dataFormat', $this->client);
    }

    public function testSetDataFormatJSON()
    {
        $this->client->setDataFormat(Client::DATA_FORMAT_JSON);
        $this->assertAttributeSame(Client::DATA_FORMAT_JSON, 'dataFormat', $this->client);
    }

    public function testSetDataFormatXML()
    {
        $this->client->setDataFormat(Client::DATA_FORMAT_XML);
        $this->assertAttributeSame(Client::DATA_FORMAT_XML, 'dataFormat', $this->client);
    }

    public function testDefaultLanguage()
    {
        $this->assertAttributeSame(Client::DATA_LANG_RU, 'lang', $this->client);
    }

    public function testSetLanguage()
    {
        $this->client->setLanguage(Client::DATA_LANG_UK);
        $this->assertAttributeSame(Client::DATA_LANG_UK, 'lang', $this->client);
    }

    public function testGetScheduleBetweenStations()
    {
        $data = $this->client->getScheduleBetweenStations('NYC', 'LED', Client::TRANSPORT_TYPE_PLANE, Client::SYSTEM_IATA);
        $data = json_decode($data, true);

        $this->assertArrayHasKey('pagination', $data);
        $this->assertArrayHasKey('to', $data['search']);
        $this->assertArrayHasKey('from', $data['search']);
        $this->assertArrayHasKey('code', $data['search']['to']);
        $this->assertArrayHasKey('type', $data['search']['to']);
        $this->assertArrayHasKey('popular_title', $data['search']['to']);
        $this->assertArrayHasKey('short_title', $data['search']['to']);
        $this->assertArrayHasKey('title', $data['search']['to']);
    }

    public function testGetScheduleOnStation()
    {
        $data = $this->client->getScheduleOnStation('KBP', Client::TRANSPORT_TYPE_PLANE, Client::SYSTEM_IATA);
        $data = json_decode($data, true);

        $this->assertArrayHasKey('pagination', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('station', $data);
        $this->assertArrayHasKey('code', $data['station']);
        $this->assertArrayHasKey('schedule', $data);
    }

    public function testGetListStationsRoute()
    {
        $data = $this->client->getListStationsRoute('PS-773_0_c139_547');
        $data = json_decode($data, true);

        $this->assertArrayHasKey('except_days', $data);
        $this->assertArrayHasKey('uid', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('start_time', $data);
        $this->assertArrayHasKey('number', $data);
        $this->assertArrayHasKey('short_title', $data);
        $this->assertArrayHasKey('days', $data);
        $this->assertArrayHasKey('carrier', $data);
        $this->assertArrayHasKey('stops', $data);
        $this->assertArrayHasKey('transport_type', $data);
        $this->assertArrayHasKey('code', $data['carrier']);
        $this->assertArrayHasKey('codes', $data['carrier']);
        $this->assertArrayHasKey('title', $data['carrier']);
    }

    public function testGetCarrier()
    {
        $data = $this->client->getCarrier('TK', Client::SYSTEM_IATA);
        $data = json_decode($data, true);

        $this->assertArrayHasKey('carriers', $data);
        $this->assertArrayHasKey('code', $data['carriers'][0]);
        $this->assertArrayHasKey('title', $data['carriers'][0]);
        $this->assertArrayHasKey('url', $data['carriers'][0]);
        $this->assertArrayHasKey('contacts', $data['carriers'][0]);
        $this->assertArrayHasKey('codes', $data['carriers'][0]);
        $this->assertArrayHasKey('address', $data['carriers'][0]);
        $this->assertArrayHasKey('logo', $data['carriers'][0]);
        $this->assertArrayHasKey('email', $data['carriers'][0]);
    }

    public function testGetNearestStations()
    {
        $data = $this->client->getNearestStations('50.440046', '40.4882367', '40');
        $data = json_decode($data, true);

        $this->assertArrayHasKey('pagination', $data);
        $this->assertArrayHasKey('stations', $data);
        $this->assertArrayHasKey('distance', $data['stations'][0]);
        $this->assertArrayHasKey('code', $data['stations'][0]);
        $this->assertArrayHasKey('title', $data['stations'][0]);
        $this->assertArrayHasKey('station_type', $data['stations'][0]);
        $this->assertArrayHasKey('popular_title', $data['stations'][0]);
        $this->assertArrayHasKey('short_title', $data['stations'][0]);
        $this->assertArrayHasKey('transport_type', $data['stations'][0]);
        $this->assertArrayHasKey('lat', $data['stations'][0]);
        $this->assertArrayHasKey('lng', $data['stations'][0]);
        $this->assertArrayHasKey('type', $data['stations'][0]);
    }

    public function testGetCopyright()
    {
        $data = $this->client->getCopyright();
        $data = json_decode($data, true);

        $this->assertArrayHasKey('copyright', $data);
        $this->assertArrayHasKey('logo_vm', $data['copyright']);
        $this->assertArrayHasKey('logo_hd', $data['copyright']);
        $this->assertArrayHasKey('logo_vy', $data['copyright']);
        $this->assertArrayHasKey('logo_vd', $data['copyright']);
        $this->assertArrayHasKey('logo_hm', $data['copyright']);
        $this->assertArrayHasKey('logo_hy', $data['copyright']);
        $this->assertArrayHasKey('url', $data['copyright']);
        $this->assertArrayHasKey('text', $data['copyright']);
    }

    public function testGetCopyrightXML()
    {
        $this->client->setDataFormat(Client::DATA_FORMAT_XML);
        $data = $this->client->getCopyright();

        $p = xml_parser_create();
        xml_parse_into_struct($p, $data, $array);
        xml_parser_free($p);

        $this->assertTrue(array_search('COPYRIGHT', array_column($array, 'tag')) ? true : false);
        $this->assertTrue(array_search('LOGO_VY', array_column($array, 'tag')) ? true : false);
    }

    public function testGetApiVersion()
    {
        $data = $this->client->getApiVersion();

        $this->assertEquals('v1.0', $data);
    }
}