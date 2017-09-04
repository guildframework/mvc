<?php

namespace Guild\File;


class Csv
{

    public function getCsvOutput($data)
    {
        ob_start();
        $out = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($out, $row);
        }
        return ob_get_contents();
    }

    public function getData($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('File not found.');
        }
        $fileHandler = fopen($filePath, "r");
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

    public function parseCsv($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception('File not found.');
        }
        $fileHandler = fopen($filePath, "r");
        $array = array();
        while (!feof($fileHandler)) {
            $array[] = fgetcsv($fileHandler);
        }
        fclose($fileHandler);
        return $array;
    }

    public function writeFile($filePath, $data)
    {
        $newFile = fopen($filePath, 'w+');
        if (!file_exists($filePath)) {
            throw new \Exception('New file could not be generated');
        }
        foreach ($data as $row) {
            fputcsv($newFile, $row);
        }
        fclose($newFile);
    }

}