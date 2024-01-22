<?php

namespace FpDbTest;

use Exception;
use mysqli;

class Database implements DatabaseInterface
{
    private mysqli $mysqli;

    public function __construct(mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function buildQuery(string $query, array $args = []): string
    {
        $formattedArgs = $this->formatArgs($args);
        $query = str_replace('?#', $formattedArgs, $query);

        return $query;
    }

    public function skip()
    {
        // This method returns a special value indicating it should be skipped
        throw new Exception('Skip method should not be called directly.');
    }

    private function formatArgs(array $args): string
    {
        return implode(', ', array_map(function ($arg) {
            return $this->formatArg($arg);
        }, $args));
    }

    private function formatArg($arg): string
    {
        if (is_null($arg)) {
            return 'NULL';
        } elseif (is_int($arg) || is_float($arg)) {
            return $arg;
        } elseif (is_bool($arg)) {
            return $arg ? '1' : '0';
        } elseif (is_array($arg)) {
            return $this->formatArray($arg);
        } else {
            // Escape and quote strings
            return "'" . $this->mysqli->real_escape_string((string) $arg) . "'";
        }
    }

    private function formatArray(array $array): string
    {
        $formattedArray = array_map(function ($value) {
            return $this->formatArg($value);
        }, $array);

        return implode(', ', $formattedArray);
    }
}