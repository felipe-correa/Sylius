<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CartBundle\Doctrine\ORM;

use Sylius\Component\Cart\Repository\CartRepositoryInterface;
use Sylius\Bundle\OrderBundle\Doctrine\ORM\OrderRepository;
use Sylius\Component\Order\Model\OrderInterface;

/**
 * Default cart entity repository.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 * @author Alexandre Bacco <alexandre.bacco@gmail.com>
 */
class CartRepository extends OrderRepository implements CartRepositoryInterface
{
    public function findLastCartByCustomer($customer, $channel)
    {
        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq($this->getAlias().'.channel', ':channel'))
            ->andWhere($queryBuilder->expr()->eq($this->getAlias().'.customer', ':customer'))
            ->andWhere($queryBuilder->expr()->eq($this->getAlias().'.state', ':state'))
            ->andWhere($queryBuilder->expr()->isNull($this->getAlias().'.completedAt'))
            ->andWhere($queryBuilder->expr()->gte($this->getAlias().'.updatedAt', ':lastCartDate'))
            ->andWhere($queryBuilder->expr()->isNull($this->getAlias().'.deletedAt'))
            ->orderBy($this->getPropertyName('updatedAt'), 'DESC')
            ->setMaxResults(1)
            ->setParameter('channel', $channel)
            ->setParameter('customer', $customer)
            ->setParameter('state', OrderInterface::STATE_CART)
            ->setParameter('lastCartDate', new \DateTime('-8 days')) // importante: Sempre colocar o -
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findExpiredCarts()
    {
        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder
            ->andWhere($queryBuilder->expr()->lt($this->getAlias().'.expiresAt', ':now'))
            ->andWhere($queryBuilder->expr()->eq($this->getAlias().'.state', ':state'))
            ->setParameter('now', new \DateTime())
            ->setParameter('state', OrderInterface::STATE_CART)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
