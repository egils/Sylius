<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\UiBundle\DependencyInjection;

use Laminas\Stdlib\SplPriorityQueue;
use Sylius\Bundle\UiBundle\Registry\BlockRegistryInterface;
use Sylius\Bundle\UiBundle\Registry\ComponentBlock;
use Sylius\Bundle\UiBundle\Registry\TemplateBlock;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class SyliusUiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        if ($container->getParameter('kernel.debug')) {
            $loader->load('services/debug/template_event.xml');
        }

        $this->loadEvents($config['events'], $container);

        $container->setParameter('sylius_ui.twig_ux.anonymous_component_template_prefixes', $config['twig_ux']['anonymous_component_template_prefixes'] ?? []);
    }

    /**
     * @param array<string, array{blocks: array<string, array{template: string, context: array, priority?: int, enabled: bool}>}> $eventsConfig
     */
    private function loadEvents(array $eventsConfig, ContainerBuilder $container): void
    {
        $templateBlockRegistryDefinition = $container->findDefinition(BlockRegistryInterface::class);

        $blocksForEvents = [];
        foreach ($eventsConfig as $eventName => $eventConfiguration) {
            $blocksPriorityQueue = new SplPriorityQueue();

            foreach ($eventConfiguration['blocks'] as $blockName => $details) {
                $details['name'] = $blockName;
                $details['eventName'] = $eventName;

                $blocksPriorityQueue->insert($details, $details['priority'] ?? 0);
            }

            /** @var array{name: string, eventName: string, template: string, component: array{name?: string, inputs?: array<string, mixed>}, context: array, priority: int, enabled: bool} $details */
            foreach ($blocksPriorityQueue->toArray() as $details) {
                $blockType = [] !== $details['component'] ? 'component' : 'template';
                $blocksForEvents[$eventName][$details['name']] = match ($blockType) {
                    'template' => $this->createTemplateBlockDefinition($details),
                    'component' => $this->createComponentBlockDefinition($details),
                };
            }
        }

        $templateBlockRegistryDefinition->setArgument(0, $blocksForEvents);
    }

    /**
     * @param array<string, mixed> $details
     */
    private function createTemplateBlockDefinition(array $details): Definition
    {
        return new Definition(
            TemplateBlock::class,
            [
                $details['name'],
                $details['eventName'],
                $details['template'],
                $details['context'],
                $details['priority'],
                $details['enabled'],
            ],
        );
    }

    /**
     * @param array<string, mixed> $details
     */
    private function createComponentBlockDefinition(array $details): Definition
    {
        return new Definition(
            ComponentBlock::class,
            [
                $details['name'],
                $details['eventName'],
                $details['component']['name'],
                $details['component']['inputs'] ?? [],
                $details['context'],
                $details['priority'],
                $details['enabled'],
            ],
        );
    }
}
