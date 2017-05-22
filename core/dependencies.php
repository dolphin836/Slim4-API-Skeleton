<?php

$container = $app->getContainer();

// Log
$container['log'] = function ($c) {
    return new Dolphin\Tan\Librarie\Log();
};
