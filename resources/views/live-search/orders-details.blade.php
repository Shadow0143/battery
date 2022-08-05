@if($orders->isNotEmpty())
@foreach($orders as $order)
<?php
    $orderDetails=App\Models\OrderDetail::where('ref_order',$order->id)->get();
    foreach ($orderDetails as $orderDetail) {
        $product=$orderDetail->ref_product;
        $quantity=App\Models\Product::find($product)->opening_balence;
        $stocks=App\Models\Stock::where('ref_product',$product)->get();
        foreach ($stocks as $stock) {
            $quantity=$quantity+intval($stock->quantity);
        }
    }
?>
<tr>
    <td>
    {{ Carbon\Carbon::createFromFormat('Y-m-d', $order->date)->format('d.m.Y') }}
    </td>
    <td>
        {{$order->invoice_number}}
    </td>
    <td>
    {{App\Models\Customer::find($order->ref_customer)->name}}
    </td>
    <td>
        {{$quantity}}
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="8">
        <div class="alert alert-danger" role="alert">
            No Details Found...
        </div>
    </td>
</tr>
@endif
