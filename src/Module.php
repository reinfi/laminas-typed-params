<?php

declare(strict_types=1);

namespace Reinfi\TypedParams;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Reinfi\TypedParams\Plugin\TypedParams;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        return [
            'controller_plugins' => [
                'aliases' => [
                    'typedParams' => TypedParams::class,
                ],
                'factories' => [
                    TypedParams::class => InvokableFactory::class,
                ],
            ]
        ];
    }
}
