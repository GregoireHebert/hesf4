<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Menu\MenuManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MenuEventPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(MenuManager::class)) {
            return;
        }

        $menuManagerDefinition = $container->findDefinition(MenuManager::class);
        $links = $container->findTaggedServiceIds('menu.link');

        foreach ($links as $id => $tags) {
            $menuManagerDefinition->addMethodCall('addLink', [new Reference($id)]);
        }
    }

}
