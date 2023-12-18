<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * Read csv file into laravel collection
 */
class CsvReader
{
    public static function read($file, $hasColumnsTitle = true, $delimiter = ',', $enclosure = '"', $keysToLower = true, int $limit = null): Collection
    {
        $result = collect();
        $table = fopen($file, 'r');
        if ($hasColumnsTitle) {
            $columns = fgetcsv($table, null, $delimiter);
        }
        $counter = 0;
        while (($row = fgetcsv($table, null, $delimiter, $enclosure)) !== false) {
            if ($limit && $counter >= $limit) break;

            if ($hasColumnsTitle) {
                $row = self::addRowKeys($row, $columns, $keysToLower);
            }

            $result->push($row);
            $counter++;
        }
        fclose($table);

        return $result;
    }

    protected static function addRowKeys(array $row, array $columns, $keysToLower): array
    {
        $result = [];
        foreach ($columns as $index => $column) {
            if (!array_key_exists($index, $row)) {
                dd($row);
            }
            if ($keysToLower) {
                $column = strtolower($column);
            }
            $result[$column] = $row[$index] === '' ? null : $row[$index];
        }
        return $result;
    }

}
