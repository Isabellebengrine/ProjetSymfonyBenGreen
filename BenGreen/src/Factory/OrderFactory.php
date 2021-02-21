<?php

namespace App\Factory;

use App\Entity\Totalorder;
use App\Entity\Orderdetail;
use App\Entity\Products;


/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Totalorder
     */
    public function create(): Totalorder
    {
        $order = new Totalorder();
        $order
            ->setStatus(Totalorder::STATUS_CART)
            ->setTotalorderDate(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Products $product
     *
     * @return Orderdetail
     */
    public function createItem(Products $product): Orderdetail
    {
        $item = new Orderdetail();
        $item->setProducts($product);
        $item->setOrderdetailQuantity(1);

        return $item;
    }
}

