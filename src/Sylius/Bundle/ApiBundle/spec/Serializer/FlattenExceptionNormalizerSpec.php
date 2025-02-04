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

namespace spec\Sylius\Bundle\ApiBundle\Serializer;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class FlattenExceptionNormalizerSpec extends ObjectBehavior
{
    function it_decorates_normalize_method(
        NormalizerInterface $normalizer,
        RequestStack $requestStack,
    ): void {
        $this->beConstructedWith($normalizer, $requestStack, '/api/v1');

        $normalizer->normalize('data', 'format', ['context'])->willReturn([])->shouldBeCalled();

        $this->normalize('data', 'format', ['context']);
    }

    function it_doesnt_support_normalization_when_path_starts_with_new_api_route(
        NormalizerInterface $normalizer,
        RequestStack $requestStack,
        Request $request,
    ): void {
        $this->beConstructedWith($normalizer, $requestStack, '/api/v2');

        $request->getPathInfo()->willReturn('/api/v2/products');

        $requestStack->getMainRequest()->willReturn($request);

        $normalizer->supportsNormalization('data', 'format', ['context'])->shouldNotBeCalled();

        $this->supportsNormalization('data', 'format', ['context']);
    }

    function it_supports_normalization_when_path_doesnt_start_with_new_api_route(
        NormalizerInterface $normalizer,
        RequestStack $requestStack,
        Request $request,
    ): void {
        $this->beConstructedWith($normalizer, $requestStack, '/api/v2');

        $request->getPathInfo()->willReturn('/api/v1/products');

        $requestStack->getMainRequest()->willReturn($request);

        $normalizer->supportsNormalization('data', 'format', ['context'])->shouldBeCalled()->willReturn(true);

        $this->supportsNormalization('data', 'format', ['context'])->shouldReturn(true);
    }

    function it_doesnt_support_normalization_when_no_request_is_available(
        NormalizerInterface $normalizer,
        RequestStack $requestStack,
    ): void {
        $this->beConstructedWith($normalizer, $requestStack, '/api/v2');

        $requestStack->getMainRequest()->willReturn(null);

        $normalizer->supportsNormalization('data', 'format', ['context'])->shouldNotBeCalled();

        $this->supportsNormalization('data', 'format', ['context']);
    }
}
