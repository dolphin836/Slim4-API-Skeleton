<?php

$container = $app->getContainer();

// Log
// $container['log'] = function ($c) {
//     return new Dolphin\Tan\Librarie\Log();
// };

// View
$container['view'] = function ($c) {
    $view = new League\Plates\Engine($c->get('config')['viewPath'], 'html');
    $view->addFolder('Layout', $c->get('config')['viewPath'] . DIRECTORY_SEPARATOR . 'layout');
    return $view;
};
