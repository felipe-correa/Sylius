<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Order\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\SoftDeletableInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * Order interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface OrderInterface extends AdjustableInterface, TimestampableInterface, SoftDeletableInterface
{
    const STATE_CART        = 'cart';
    const STATE_CART_LOCKED = 'cart_locked';
    const STATE_PENDING     = 'pending';
    const STATE_CONFIRMED   = 'confirmed';
    const STATE_SHIPPED     = 'shipped';
    const STATE_ABANDONED   = 'abandoned';
    const STATE_CANCELLED   = 'cancelled';
    const STATE_RETURNED    = 'returned';

    /**
     * Has the order been completed by user and can be handled.
     *
     * @return Boolean
     */
    public function isCompleted();

    /**
     * Mark the order as completed.
     */
    public function complete();

    /**
     * Return completion date.
     *
     * @return \DateTime
     */
    public function getCompletedAt();

    /**
     * Set completion time.
     *
     * @param null|\DateTime $completedAt
     */
    public function setCompletedAt(\DateTime $completedAt = null);

    /**
     * Get order number.
     *
     * @return string
     */
    public function getNumber();

    /**
     * Set order number.
     *
     * @param string $number
     */
    public function setNumber($number);

    /**
     * Get order items.
     *
     * @return Collection|OrderItemInterface[] An array or collection of OrderItemInterface
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param Collection|OrderItemInterface[] $items
     */
    public function setItems(Collection $items);

    /**
     * Returns number of order items.
     *
     * @return integer
     */
    public function countItems();

    /**
     * Adds item to order.
     *
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item);

    /**
     * Remove item from order.
     *
     * @param OrderItemInterface $item
     */
    public function removeItem(OrderItemInterface $item);

    /**
     * Has item in order?
     *
     * @param OrderItemInterface $item
     *
     * @return Boolean
     */
    public function hasItem(OrderItemInterface $item);

    /**
     * Get items total.
     *
     * @return integer
     */
    public function getItemsTotal();

    /**
     * Calculate items total based on the items
     * unit prices and quantities.
     */
    public function calculateItemsTotal();

    /**
     * Get order total.
     *
     * @return integer
     */
    public function getTotal();

    /**
     * Set total.
     *
     * @param integer $total
     */
    public function setTotal($total);

    /**
     * Calculate total.
     * Items total + Adjustments total.
     */
    public function calculateTotal();

    /**
     * Alias of {@link countItems()}.
     *
     * @deprecated To be removed in 1.0. Use {@link countItems()} instead.
     */
    public function getTotalItems();

    /**
     * Returns total quantity of items in cart.
     *
     * @return integer
     */
    public function getTotalQuantity();

    /**
     * Checks whether the cart is empty or not.
     *
     * @return Boolean
     */
    public function isEmpty();

    /**
     * Clears all items in cart.
     */
    public function clearItems();

    /**
     * Get order state.
     *
     * @return string
     */
    public function getState();

    /**
     * Set order state.
     *
     * @param string $state
     */
    public function setState($state);
}
