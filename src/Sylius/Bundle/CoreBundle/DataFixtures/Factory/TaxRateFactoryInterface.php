<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\CoreBundle\DataFixtures\Factory;

use Sylius\Bundle\CoreBundle\DataFixtures\Factory\State\WithCodeInterface;
use Sylius\Bundle\CoreBundle\DataFixtures\Factory\State\WithNameInterface;
use Sylius\Bundle\CoreBundle\DataFixtures\Factory\State\WithZoneInterface;
use Sylius\Component\Core\Model\TaxRateInterface;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<TaxRateInterface>
 *
 * @method static TaxRateInterface|Proxy createOne(array $attributes = [])
 * @method static TaxRateInterface[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TaxRateInterface|Proxy find(object|array|mixed $criteria)
 * @method static TaxRateInterface|Proxy findOrCreate(array $attributes)
 * @method static TaxRateInterface|Proxy first(string $sortedField = 'id')
 * @method static TaxRateInterface|Proxy last(string $sortedField = 'id')
 * @method static TaxRateInterface|Proxy random(array $attributes = [])
 * @method static TaxRateInterface|Proxy randomOrCreate(array $attributes = [])
 * @method static TaxRateInterface[]|Proxy[] all()
 * @method static TaxRateInterface[]|Proxy[] findBy(array $attributes)
 * @method static TaxRateInterface[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static TaxRateInterface[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method TaxRateInterface|Proxy create(array|callable $attributes = [])
 */
interface TaxRateFactoryInterface extends WithCodeInterface, WithNameInterface, WithZoneInterface
{
    public function withAmount(float $amount): self;

    public function includedInPrice(): self;

    public function notIncludedInPrice(): self;

    public function withCalculator(string $calculator): self;

    public function withCategory(Proxy|TaxCategoryInterface|string $category): self;
}