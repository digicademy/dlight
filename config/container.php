<?php

// MODEL

$container['Page'] = function() {
    $page = new \Digicademy\DLight\Domain\Model\Page;
    return $page;
};

// REPOSITORY

$container['PageRepository'] = function($c) {
    $c->settings['connection'] = $c->settings['backend']['Digicademy\DLight\Domain\Repository\PageRepository'];
    $pageRepository = new \Digicademy\DLight\Domain\Repository\PageRepository($c);
    return $pageRepository;
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

// BACKEND

$container['HttpBackend'] = function($c) {
    $httpBackend = new \Digicademy\DLight\Persistence\HttpBackend($c);
    return $httpBackend;
};

// PROCESSOR

$container['UppercaseProcessor'] = function() {
    $uppercaseProcessor = new \Digicademy\DLight\Processor\UppercaseProcessor;
    return $uppercaseProcessor;
};

// STORAGE

$container['ObjectStorage'] = function() {
    $objectStorage = new \SplObjectStorage;
    return $objectStorage;
};

// VIEW

$container['view'] = function ($c) {

    // set template directory
    if ($c->settings['twig']['templateDir']) {
        $twigTemplateDir = $c->settings['twig']['templateDir'];
    } else {
        $twigTemplateDir = __DIR__ . '/../templates';
    }

    // instantiate Twig View
    $view = new \Slim\Views\Twig($twigTemplateDir, [
        'cache' => $c->settings['twig']['cache'],
        'debug' => $c->settings['twig']['debug']
    ]);

    // enable Twig debugging
    $view->addExtension(new Twig_Extension_Debug());

    // add Slim router to Twig
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};
