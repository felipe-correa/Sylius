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
use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Variation\Model\VariantInterface as BaseVariantInterface;

class ProductVariantImage extends Image implements ProductVariantImageInterface
{
    /**
     * The associated product variant.
     *
     * @var ProductVariantInterface[]|Collection
     */
    protected $variants;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
    }
    /**
     * {@inheritdoc}
     */
    public function hasVariants()
    {
        return !$this->getVariants()->isEmpty();
    }
    /**
     * {@inheritdoc}
     */
    public function getVariants()
    {
        return $this->variants->filter(function (BaseVariantInterface $variant) {
            return !$variant->isDeleted() && !$variant->isMaster();
        });
    }
    /**
     * {@inheritdoc}
     */
    public function getAvailableVariants()
    {
        return $this->variants->filter(function (BaseVariantInterface $variant) {
            return !$variant->isDeleted() && !$variant->isMaster() && $variant->isAvailable();
        });
    }
    /**
     * {@inheritdoc}
     */
    public function setVariants(Collection $variants)
    {
        $this->variants->clear();
        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function addVariant(BaseVariantInterface $variant)
    {
        if (!$this->hasVariant($variant)) {
            $this->variants->add($variant);
        }
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function removeVariant(BaseVariantInterface $variant)
    {
        if ($this->hasVariant($variant)) {
            $this->variants->removeElement($variant);
        }
        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function hasVariant(BaseVariantInterface $variant)
    {
        return $this->variants->contains($variant);
    }

}
