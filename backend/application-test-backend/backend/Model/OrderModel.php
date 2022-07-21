<?php
class OrderModel
{
   
    /**************************************************
    * Conver actual_data.csv file to json file to read Data
    **************************************************/
    public function converCsvToJsonFile():void {
        header('Content-type: application/json; charset=UTF-8');
        try {
                if($this->fileExists("actual_data.csv"))
                {
                        $file = PROJECT_ROOT_PATH .'/dataSource/actual_data.csv'; 
                        $content = array_map("str_getcsv", explode("\n", file_get_contents($file)));
                        $headers = $content[0]; $json = $tempArray = $newArray = [] ;
                        foreach ($content as $row_index => $row_data) {
                            if($row_index === 0) continue;
                            foreach ($row_data as $col_idx => $col_val) {
                                $label = $headers[$col_idx];
                                $json[$row_index][$label] = $col_val;
                            }
                        }
                        foreach($json as $key => $tempArray){
                            $newArray []  = $tempArray;
                        }
                        //write to JSON file
                        $newfilePath =  PROJECT_ROOT_PATH .'/dataSource';
                        $fp = fopen($newfilePath.'/orderDetails.json', 'w');
                        fwrite($fp, json_encode($newArray, true));
                        fclose($fp);
                }
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage();
        }
    }
    
    /*************************************************
     *  Read all order details prasent in json file
     **************************************************/
    public function readJson(): array {
        try {
            $filePath = PROJECT_ROOT_PATH .'/dataSource/orderDetails.json'; 
            if(!file_exists($filePath)){$this->converCsvToJsonFile();}
            $rawJson = json_decode(file_get_contents($filePath), true);
            usort($rawJson, function($a, $b) { 
                return $a['id'] <=> $b['id'];
            });
            return $rawJson;
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage();
        }
    }

    
   /*************************************************
     *  Add order details to json file
     **************************************************/
    public function addSetOfArrayElementToJsonFile($new_arr): array {
        try {
            $filePath = PROJECT_ROOT_PATH .'/dataSource';
            $newArray = array_merge(json_decode(file_get_contents($filePath .'/orderDetails.json'), TRUE),$new_arr);
            file_put_contents($filePath .'/orderDetails.json', json_encode($newArray));
            return $this->readJson();
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage();
        }
    }

    /*************************************************
     *  Update order details to json file
     **************************************************/
    public function updateAJsonElement($new_arr):array{
        try {
            $filePath = PROJECT_ROOT_PATH .'/dataSource';
            $json_arr = json_decode(file_get_contents($filePath .'/orderDetails.json'), TRUE);
            $arr_index = array();
            foreach ($json_arr as $key => $value)
            {
                if ($value['id'] == $new_arr[0]['id'])
                {
                    $update_index[] = $key;
                    $arr_index[$value['id']]['id'] =  $new_arr[0]['id'];
                    $arr_index[$value['id']]['name'] =  $new_arr[0]['name'];
                    $arr_index[$value['id']]['state'] =  $new_arr[0]['state'];
                    $arr_index[$value['id']]['zip'] =  $new_arr[0]['zip'];
                    $arr_index[$value['id']]['amount'] =  $new_arr[0]['amount'];
                    $arr_index[$value['id']]['qty'] =  $new_arr[0]['qty'];
                    $arr_index[$value['id']]['item'] =  $new_arr[0]['item'];
                }
            }
            foreach ($update_index as $i){ unset($json_arr[$i]); }
            file_put_contents($filePath .'/orderDetails.json', json_encode(array_merge($json_arr,$arr_index)));
            return $this->readJson();
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage();
        }
    }

    /*************************************************
     *  Delete order detail from json file
     **************************************************/
    public function deleteAArrayElementFromJsonFile($id):array{
        try {
            $filePath = PROJECT_ROOT_PATH .'/dataSource';
            $json_arr = json_decode(file_get_contents($filePath .'/orderDetails.json'), TRUE);
            $arr_index = array();
            foreach ($json_arr as $key => $value)
            {
                if ($value['id'] == $id)
                {
                    $arr_index[] = $key;
                }
            }
            foreach ($arr_index as $i){ unset($json_arr[$i]); }
            file_put_contents($filePath .'/orderDetails.json', json_encode(array_values($json_arr)));
            return $this->readJson();
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage();
        }
    }

    public function fileExists($fileName){
        $filePath = PROJECT_ROOT_PATH .'/dataSource/'.$fileName;
        return file_exists($filePath) ? true : false;
    }


}

?>