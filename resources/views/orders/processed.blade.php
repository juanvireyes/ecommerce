@extends('template')

@section('title', 'Pago procesado')

@section('content')
    <div class="container mx-auto text-center">

        @if ($status == 'completed')

            @include('orders.partials.success')

        @elseif($status == 'approved')
            
            @include('orders.partials.pending')

        @elseif($status == 'rejected' || $status == 'cancelled')

            @include('orders.partials.canceled')
        
        @elseif($status == 'pending')
        
            @include('orders.partials.payment-pending')
            
        @endif

    </div>
@endsection