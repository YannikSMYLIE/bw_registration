<?php
namespace BoergenerWebdesign\BwRegistration\Utility;

class CsvUtility {
    /**
     * Gibt
     * @param array $data
     * @param string $filename
     */
    public static function write(array $data, string $filename = "data") : void {
        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');

        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        foreach($data as $line) {
            fputcsv($output, self::utf8_decode_array($line), ";");
        }
        die();
    }

    /**
     * Dekodiert ein gegebenes Array.
     * @param array $data
     * @return array
     */
    private static function utf8_decode_array(array $data) : array {
        $decoded = [];
        foreach($data as $key => $line) {
            $decoded[utf8_decode($key)] = utf8_decode($line);
        }
        return $decoded;
    }
}