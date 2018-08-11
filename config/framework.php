<?php

$config['displayErrorDetails'] = true;

$config['addContentLengthHeader'] = false;

$config['frameworkPath'] = str_replace('config', '', __DIR__);

$config['httpService'] = [
    'baseUri' => 'https://raw.githubusercontent.com/digicademy/dlight/master/'
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
