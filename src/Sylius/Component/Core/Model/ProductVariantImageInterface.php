<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Model;

use Doctrine\Common\Collections\Collection;

interface ProductVariantImageInterface extends ImageInterface
{
    /**
     * Get product variant.
     *
     * @return ProductVariantInterface
     */
    public function getVariants();
    /**
     * Set the product variant.
     *
     * @param ProductVariantInterface $variants
     */
    public function setVariants(Collection $variants);
}
