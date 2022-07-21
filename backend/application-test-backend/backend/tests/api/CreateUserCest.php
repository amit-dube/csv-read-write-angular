<?php

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    // tests
    public function testOrderDetailsViaGetAPICall(\ApiTester $I)
    {
        $I->sendGet('/order/list');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseIsValidOnJsonSchemaString('{"type":"array"}');
        $validResponseJsonSchema = json_encode(
            [
                 [
                    'id'         => ['type' => 'integer'],
                    'name'       => ['type' => 'string'],
                    'state' =>      ['type' => 'string'],
                    'zip' =>        ['type' => 'integer'],
                    'amount' =>     ['type' => 'integer'],
                    'qty' =>        ['type' => 'integer'],
                    'item' =>       ['type' => 'string']
                ]
            ]
        );
        $I->seeResponseIsValidOnJsonSchemaString($validResponseJsonSchema);
    }

    public function testAddOrderDetailsViaPostAPICall(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $oderDetails = json_encode([
                                    'id'         => '2',
                                    'name'       => "davert",
                                    'state' =>      "NY",
                                    'zip' =>        "33434",
                                    'amount' =>     "4545",
                                    'qty' =>        '3',
                                    'item' =>       'iio9'
                                ]);
        $I->sendPost('/order/add', $oderDetails);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }


    public function testUpdateOrderDetailsViaPatchAPICall(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $oderDetails = json_encode([
                                    'id'         => '1',
                                    'name'       => "davert",
                                    'state' =>      "NY",
                                    'zip' =>        "33434",
                                    'amount' =>     "4545",
                                    'qty' =>        '3',
                                    'item' =>       'iio9'
                                ]);
        $I->sendPatch('/order/edit?id=3', $oderDetails);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    public function testDeleteOrderDetailsViaDeleteAPICall(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/order/delete?id=3');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }
}
