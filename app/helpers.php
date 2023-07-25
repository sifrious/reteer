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
?>