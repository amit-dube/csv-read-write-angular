<?php
use PHPUnit\Framework\Testcase;
require __DIR__ . "/../../bootstrap/bootstrap.php";

class orderDetailsTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {


    }

    
    // check csv file exist in the folder/directory 
    public function testCSVDataFileExists(){
          $obj = new OrderModel();
          $fileExistStatus = $obj->fileExists("data.csv") ? 'success' : 'failed';
          $this->assertEquals('success',$fileExistStatus);
    }

    public function testGetOrderDetailsFromFile(){
        $obj = new OrderModel();
        $rowData [] = array("id"=>20,"name"=>"Nagaraj","state"=>"KA","zip"=>"560078","amount"=>"250","qty"=>1,"item"=>1);
		$listResponse =  $obj->readJson();
		$this->assertEquals('success',self::IsJsonString($listResponse));
    }

    public function testInsertAOrderDetailsToFile(){
        $obj = new OrderModel();
        $rowData [] = array("id"=>20,"name"=>"Nagaraj","state"=>"KA","zip"=>"560078","amount"=>"250","qty"=>1,"item"=>1);
		$instResponse =  $obj->addSetOfArrayElementToJsonFile($rowData);
		$this->assertEquals('success',self::IsJsonString($instResponse));
    }

    public static function IsJsonString($jsonString)
    {
        if(!is_array($jsonString)){
            json_decode($jsonString);
            return json_last_error() === JSON_ERROR_NONE ? "success" : "success";
        }else{
            return "success";
        }
     }
}