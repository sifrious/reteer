<?php

use Illuminate\Support\Str;
use Filament\Notifications\Collection;
use Illuminate\Support\Facades\Cache;

function clean_header(string $item): string {
    return str($item)->lower()->replace(["(", ")", "*"], '')->replace([" ", "\n", "__"], "_");
};
?>