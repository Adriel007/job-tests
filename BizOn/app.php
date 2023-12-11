<?php

function binarySearch(array $data, int $number): int
{
    $left = 0;
    $right = count($data) - 1;

    while ($left <= $right) {
        $mid = (int) (($left + $right) / 2);

        if ($data[$mid] === $number) {
            return $mid;
        } elseif ($data[$mid] < $number) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }

    return -1;
}

function countWeekend(string $begin, string $end): int
{
    $beginTimestamp = strtotime($begin);
    $endTimestamp = strtotime($end);
    $weekends = 0;

    while ($beginTimestamp <= $endTimestamp) {
        $dayOfWeek = date("N", $beginTimestamp);
        if ($dayOfWeek === '6' || $dayOfWeek === '7') {
            $weekends++;
        }
        $beginTimestamp = strtotime('+1 day', $beginTimestamp);
    }

    return $weekends;
}

function rgb(int $r, int $g, int $b): int
{
    return ($r << 16) + ($g << 8) + $b;
}

function fibonacci(int $limit): string
{
    $fibSequence = [];
    $fibSequence[0] = 0;
    $fibSequence[1] = 1;

    $i = 2;
    while (($fibSequence[$i - 1] + $fibSequence[$i - 2]) <= $limit) {
        $fibSequence[$i] = $fibSequence[$i - 1] + $fibSequence[$i - 2];
        $i++;
    }

    return implode(' ', $fibSequence);
}

echo binarySearch([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 5);
echo PHP_EOL;
echo countWeekend('2022-01-01', '2022-01-31');
echo PHP_EOL;
echo rgb(255, 255, 255);
echo PHP_EOL;
echo fibonacci(1000);