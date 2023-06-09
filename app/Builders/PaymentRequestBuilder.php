<?php

namespace App\Builders;

use App\Actions\SetCurrencyTypeAction;
use App\Models\Order;
use App\Models\User;
use App\Services\ExchangeCurrencyService;

/**
 * @property Order $order
 * @property User $user
 * @property Subcategory $subcategory
 * @property Product $product
 * @property string $description
 * @property string $reference
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip
 * @property string $amount
 * @property string $tax
 * @property string $taxKind
 * @property string $taxAmount
 * @property string $detail
 */
class PaymentRequestBuilder
{
    private function createAmountArray( 
        float|int $amount, 
        bool $tax = null, 
        string $taxKind = null,
        string|int $taxAmount = null, 
        bool $details = null,
        string $detailKind = null,
        string|int $detailAmount = null): array
    {
        $amountArray = [];

        $currency = SetCurrencyTypeAction::execute($amount);
        
        if ($currency == 'COP') {

            $toCurrency = 'USD';

            $amount = ExchangeCurrencyService::exchange($currency, $toCurrency, $amount);

            $currency = SetCurrencyTypeAction::execute($amount);

        }

        if ($tax && $details) {

            $tax = [
                'kind' => $taxKind,
                'amount' => $taxAmount,
                'base' => $amount
            ];

            $details = [
                'kind' => $detailKind,
                'amount' => $detailAmount,
            ];

            return [
                'currency' => $currency,
                'total' => $amount,
                'tax' => $tax,
                'details' => $details
            ];

        } elseif ($tax) {

            $tax = [
                'kind' => $taxKind,
                'amount' => $taxAmount,
                'base' => $amount
            ];

            return [
                'currency' => $currency,
                'total' => $amount,
                'tax' => $tax
            ];

        } elseif ($details) {

            $details = [
                'kind' => $detailKind,
                'amount' => $detailAmount,
            ];

            return [
                'currency' => $currency,
                'total' => $amount,
                'details' => $details
            ];
        };

        $amountArray = [
            'currency' => $currency,
            'total' => $amount,
        ]; 

        return $amountArray;
    }

    private function createShippingArray(User $user = null): array
    {
        if ($user) {
            return [
                'document' => $user->id_number, 
                'documentType' => 'CC', 
                'name' => $user->first_name, 
                'surname' => $user->last_name, 
                'company' => null,
                'email' => $user->email, 
                'mobile' => $user->cellphone, 
                'address' => [
                    'street' => $user->address, 
                    'city' => $user->city, 
                    'state' => $user->state, 
                    'postalCode' => $user->zip, 
                    'country' => $user->country, 
                    'phone' => $user->cellphone, 
                ],
            ];
        };

        return [];
    }

    private function createItemsArray(Order $order): array
    {
        $items = $order->orderItems;

        $itemArray = [];

        foreach ($items as $item) {
            $sku = $item->product->id;
            $name = $item->product->name;
            $subcategory = $item->product->subcategory->name;
            $qty = $item->quantity;
            $price = $item->price;
            $tax = $item->product_total;

            $itemArray = [
                'sku' => $sku,
                'name' => $name,
                'subcategory' => $subcategory,
                'qty' => $qty,
                'price' => $price,
                'tax' => $tax,
            ];

        };

        return $itemArray;
    }

    public function build(Order $order, User $user = null): array
    {
        $paymentArray = [];

        $paymentArray = [
            'reference' => $order->id, 
            'amount' => $this->createAmountArray($order->total),
            'shipping' => $this->createShippingArray($user),
            'items' => $this->createItemsArray($order),
        ];

        return $paymentArray;
    }
}