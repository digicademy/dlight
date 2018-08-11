<?php

// MODEL

$container['Page'] = function($c) {
    $page = new \Digicademy\DLight\Domain\Model\Page;
    return $page;
};

// REPOSITORY

$container['PageRepository'] = function($c) {
    $objectFactory = new \Digicademy\DLight\Domain\Repository\PageRepository($c);
    return $objectFactory;
};

// FACTORY

$container['ObjectFactory'] = function($c) {
    $objectFactory = new \Digicademy\DLight\Factory\ObjectFactory($c);
    return $objectFactory;
};

$container['ObjectStorageFactory'] = function($c) {
    $objectStorageFactory = new \Digicademy\DLight\Factory\ObjectStorageFactory($c);
    return $objectStorageFactory;
};

// MAPPER

$container['XmlDataMapper'] = function($c) {
    $xmlDataMapper = new \Digicademy\DLight\Mapper\XmlDataMapper($c);
    return $xmlDataMapper;
};

// SERVICE

$container['HttpService'] = function($c) {
    $httpService = new \Digicademy\DLight\Service\HttpService($c);
    return $httpService;
};

// PROCESSOR

$container['UppercaseProcessor'] = function($c) {
    $uppercaseProcessor = new \Digicademy\DLight\Processor\UppercaseProcessor;
    return $uppercaseProcessor;
};

// STORAGE

$container['ObjectStorage'] = function($c) {
    $objectStorage = new \SplObjectStorage;
    return $objectStorage;
};

// VIEW

$container['view'] = function ($container) {

    // set template directory
    if ($container->settings['twig']['templateDir']) {
        $twigTemplateDir = $container->settings['twig']['templateDir'];
    } else {
        $twigTemplateDir = __DIR__ . '/../templates';
    }

    // instantiate Twig View
    $view = new \Slim\Views\Twig($twigTemplateDir, [
        'cache' => $container->settings['twig']['cache'],
        'debug' => $container->settings['twig']['debug']
    ]);

    // enable Twig debugging
    $view->addExtension(new Twig_Extension_Debug());

    // add Slim router to Twig
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};
