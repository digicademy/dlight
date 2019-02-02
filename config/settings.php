<?php

$config['displayErrorDetails'] = true;

$config['addContentLengthHeader'] = false;

$config['frameworkPath'] = str_replace('config', '', __DIR__);

$config['backend'] = [
    'Digicademy\DLight\Domain\Repository\PageRepository' => [
        'baseUri' => 'https://raw.githubusercontent.com/digicademy/dlight/master/',
        'options' => []
    ]
];

$config['xslt'] = [
    'stylesheetDir' => '',
    'namespaces' => [
        'tei' => 'http://www.tei-c.org/ns/1.0'
    ]
];

$config['twig'] = [
    'templateDir' => '',
    'debug' => true,
    'cache' => false
];
