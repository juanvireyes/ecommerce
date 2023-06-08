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

        <div>
            <a href="{{ route('orders.index') }}" 
            class="bg-yellow-500 text-black text-center font-semibold px-2 py-3 rounded-md">
                Volver a mis órdenes
            </a>
        </div>

    </div>
@endsection