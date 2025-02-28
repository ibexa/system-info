<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Ibexa\Rector\Rule\ReplaceInterfaceRector;
use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromCreateMockAssignRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictSetUpRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        SetList::TYPE_DECLARATION,
        IbexaSetList::IBEXA_50->value,
        SymfonySetList::SYMFONY_60,
        SymfonySetList::SYMFONY_61,
        SymfonySetList::SYMFONY_62,
        SymfonySetList::SYMFONY_63,
        SymfonySetList::SYMFONY_64,
    ])
    ->withRules([
        TypedPropertyFromAssignsRector::class,
        ReplaceInterfaceRector::class,
        TypedPropertyFromStrictSetUpRector::class,
        TypedPropertyFromCreateMockAssignRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
    ]);
