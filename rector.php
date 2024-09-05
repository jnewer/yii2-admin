<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/api',
        __DIR__ . '/backend',
        __DIR__ . '/common',
        __DIR__ . '/console',
        __DIR__ . '/environments',
        __DIR__ . '/frontend',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    // ->withRules([
    //     AddVoidReturnTypeWhereNoReturnRector::class,
    // ])
    ->withSets([SetList::DEAD_CODE]);
