@component('mail::message')
    # Olá {{$order->customer->name}}

    Seu pedido no {{ config('app.name') }} foi alterado com sucesso

    Valor total: **R$ {{number_format($order->total,2,',','.')}}**

    Produto: **{{$order->product->name}}**

    Quantidade: **{{$order->amount}}**

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent