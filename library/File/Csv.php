<?php

namespace Guild\File;


class Csv
{
    public function getData($file)
    {
        $fileHandler = fopen($file, "r");
        $keys = fgetcsv($fileHandler);
        $array = array();
        while (!feof($fileHandler)) {
            $row = fgetcsv($fileHandler);
            if (isset($row) && !empty($row)) {
                $array[] = array_combine($keys, $row);
            }
        }
        fclose($fileHandler);
        return $array;
    }

    public function writeFile($file, $data)
    {
        $keys = array();
        foreach ($data as $row) {
            foreach (array_keys($row) as $key){
                if(!in_array($key,$keys)){
                    $keys[]= $key;
                }
            }
//            $keys = array_merge($keys,array_keys($row));
//            $keys = array_keys($row);
        }
        $fileHandle = fopen($file, 'w+');
        fputcsv($fileHandle, $keys);
        foreach ($data as $row){
            $rowData = array();
            foreach ($keys as $key){
                if(isset($row[$key])){
                    $rowData[] = $row[$key];
                }
            }
            fputcsv($fileHandle, $rowData);
        }
        fclose($fileHandle);
//        var_dump($keys);
    }

}