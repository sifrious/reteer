<?php

use Filament\Notifications\Collection;

function clean_header(string $item) {
    $item = strtolower($item);
    $counter = 0;
    foreach(["(", ")", "*", " ", "\n", "__"] as $restricted_character) {
        $new_charachter = ($counter > 2) ? "_":"";
        $item = str_replace($restricted_character, $new_charachter, $item);
        $counter += 1;
    };
    return $item;
};

function normalize_array_length(array $array, int $full_length) {
    if (count($array) < $full_length) {
        while (count($array) < $full_length + 1) {
            array_push($array, "");
        }
        return $array;
    };
    return $array;
};

function normalize_nested_array_length(array $nested_array, int $target_length) {
    $normalized_array = [];
    foreach($nested_array as $array) {
        array_push($normalized_array, normalize_array_length($array, $target_length));
    };
    return $normalized_array;
};
?>