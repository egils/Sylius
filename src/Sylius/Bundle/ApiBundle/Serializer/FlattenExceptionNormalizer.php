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

namespace Sylius\Bundle\ApiBundle\Serializer;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class FlattenExceptionNormalizer implements NormalizerInterface
{
    public function __construct(
        private NormalizerInterface $decorated,
        private RequestStack $requestStack,
        private string $newApiRoute,
    ) {
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return false;
        }

        if (str_starts_with($request->getPathInfo(), $this->newApiRoute)) {
            return false;
        }

        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        return $this->decorated->normalize($object, $format, $context);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['object' => true];
    }
}
