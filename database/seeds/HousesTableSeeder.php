<?php

use Illuminate\Database\Seeder;

/**
 * Class HousesTableSeeder
 */
class HousesTableSeeder extends Seeder
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run()
    {
        $filename = storage_path('app/property-data.csv');

        if (!file_exists($filename) || !is_readable($filename)) {
            throw new \Illuminate\Contracts\Filesystem\FileNotFoundException('CSV file not found');
        }

        array_map(function ($data) {
            House::updateOrCreate($data);
        }, $this->convertCsvToArray($filename));
    }

    /**
     * @param string $filename
     * @param string $delimiter
     * @return array
     */
    public function convertCsvToArray(string $filename, string $delimiter = ',') : array
    {
        $header = null;
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine(array_map('strtolower', $header), $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
