<?php
/****************************************************************************************************************************************************
 * Order Details request Handler controller
 * Controller handling 4 type of request GET,POST,PATCH,DELETE
 * For each request responding with valid json with http status code
****************************************************************************************************************************************************/

class OrderDetailsController extends AppController
{
    // public function __construct(){
    //     $this->jsonToCSV();
    // }
    /****************************************************************************************************************************************************
     * "/orderDetails/list" Endpoint - Get list of orderDetails from orderDetails model class
     /****************************************************************************************************************************************************/
    public function listAction() : string
    {
        
        $requestMethod = $_SERVER["REQUEST_METHOD"]; $strErrorDesc = '';
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $orderModel = new OrderModel();
                $responseData = json_encode($orderModel->readJson());
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // respond with output
        if (!$strErrorDesc) {
            $this->jsonToCSV();
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
        }
    }


    /****************************************************************************************************************************************************
     * Add Order details
     /****************************************************************************************************************************************************/  
    public function addAction() : string
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $errors = array();
        if (strtoupper($requestMethod) == 'POST') {
            try {
                $orderModel = new OrderModel();
                $_POST = json_decode(file_get_contents('php://input'), true);
                $validation = $this->validation($_POST);
                if($validation['validationStatus']){
                    $record_count = count((array)json_decode(json_encode($orderModel->readJson()))); 
                    $json_arr[] = array('id'=> $record_count+1,
                                        'name'=> $_POST['name'] ?? '' ,
                                        'state'=> $_POST['state'] ?? '', 
                                        'zip'=> $_POST['zip'] ?? '',
                                        'amount'=> $_POST['amount'] ?? '',
                                        'qty'=> $_POST['qty'] ?? '', 
                                        'item'=> $_POST['item'] ?? '');
                    $responseData = json_encode($orderModel->addSetOfArrayElementToJsonFile($json_arr));
                }else if(!$validation['validationStatus']){
                    $responseData = json_encode($validation['errors']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // respond with output
        if (!$strErrorDesc) {
            $this->jsonToCSV();
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
        }
    }

    public function validation($postData)
    {
        $errors = array(); $returnResult = false;
        if(empty($postData['name'])){
            $errors['name'] = ['Id field required'];
        }else if(strlen($postData['name'])<3){
            $errors['name'] = ['Id field must be 3 charectors long.'];
        }
        if(empty($postData['state'])){
            $errors['state'] = ['State field required'];
        }else if(strlen($postData['state'])<2){
            $errors['state'] = ['State field must be 2 charectors long.'];
        }
        if(empty($postData['zip'])){
            $errors['zip'] = ['zip field required'];
        }else if(strlen($postData['zip']) < 5 ){
            $errors['zip'] = ['zip field must be 5 digit long.'];
        }
        if(!preg_match("/^[0-9]+$/", $postData['zip'])){
            $errors['zip'] = ['zip field must be numeric.'];
        }
        if(empty($postData['amount'])){
            $errors['amount'] = ['Amount field required'];
        }else if(!preg_match("/^[0-9]+$/", $postData['amount'])){
            $errors['amount'] = ['Amount must be in digit.'];
        }

        if(empty($postData['qty'])){
            $errors['qty'] = ['Quantity field required'];
        }else if(!preg_match("/^[0-9]+$/", $postData['qty'])){
            $errors['qty'] = ['Quantity must be in digits.'];
        }
        if(empty($postData['item'])){
            $errors['item'] = ['Item field required'];
        }else if(strlen( $postData['item'] ) < 3){
            $errors['item'] = ['Item field must be 3 charectors long.'];
        }
        $returnResult = empty($errors) ? true : false;
        return array('validationStatus'=>$returnResult,'errors'=> $errors);
    }


    /****************************************************************************************************************************************************
     * edit Order details
     ****************************************************************************************************************************************************/  
    public function editAction() : string
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'PATCH') {
            try {
                $orderModel = new OrderModel();
                $_POST = json_decode(file_get_contents('php://input'), true);
                $validation = $this->validation($_POST);
                if($validation['validationStatus']){
                    $record_count = count((array)json_decode(json_encode($orderModel->readJson()))); 
                    $json_arr[] = array('id'=> $_POST['id'],
                                        'name'=> $_POST['name'] ?? '',
                                        'state'=> $_POST['state'] ?? '', 
                                        'zip'=> $_POST['zip'] ?? '',
                                        'amount'=> $_POST['amount'] ?? '',
                                        'qty'=> $_POST['qty'] ?? '', 
                                        'item'=> $_POST['item'] ?? '');
                    $responseData = json_encode($orderModel->updateAJsonElement($json_arr));
                }else if(!$validation['validationStatus']){
                    $responseData = json_encode($validation['errors']);
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // respond with output
        if (!$strErrorDesc) {
            $this->jsonToCSV();
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
        }
    }

    /****************************************************************************************************************************************************
     * Delete Order details
     ****************************************************************************************************************************************************/  
    public function deleteAction() : string
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'DELETE') {
            try {
                $orderModel = new OrderModel();
                $_POST_ID = json_decode(file_get_contents('php://input'), true);
                if(empty($_POST_ID)){ $_POST_ID = $_GET['id']; }
                if(!empty($_POST_ID)){
                    $responseData = json_encode($orderModel->deleteAArrayElementFromJsonFile($_POST_ID));
                }else{
                    $responseData = json_encode("id Field is required to delete a record");
                }
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // respond with output
        if (!$strErrorDesc) {
            $this->jsonToCSV();
            $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), array('Content-Type: application/json', $strErrorHeader));
        }
    }
}