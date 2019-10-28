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
    public function setOrder($order);
    public function create($input);
    public function update($order, $input);
    public function delete($order);
    public function restore($order);

}