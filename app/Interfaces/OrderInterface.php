<?php

namespace App\Interfaces;

interface OrderInterface
{
    /**
     * Interface model Order
     *
     * @return \App\Repositories\OrderRepository
     */
    public function getAll($perPage);
    public function create($input);

}