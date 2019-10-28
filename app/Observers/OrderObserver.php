<?php
declare(strict_types=1);


namespace App\Observers;


use App\Mail\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;




class OrderObserver
{
    // Aqui a gente determina os gatilhos que agente quer receber.

    /**
     * Quando for criado (created)
     *
     * @param Order $order
     */
    public function created(Order $order)
    {
        //Não permite enviar emails quando rodar no terminal ou testes unitários
        if (!$this->runningInTerminal()){
            $customer = $order->customer;
            Mail::to($customer)->send(new OrderCreated($order));
        }
    }




    /**
     * Verivica se as requisições estão rodando no terminal (seeder) ou testes unitários
     * @return bool
     */
    private function runningInTerminal()
    {
        return app()->runningInConsole() || app()->runningUnitTests();
    }


}