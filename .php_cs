<?php

return EzSystems\EzPlatformCodeStyle\PhpCsFixer\Config::create()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude(
                [
                    'bin',
                    'Resources',
                    'vendor',
                ]
            )
            ->files()->name('*.php')
    );
