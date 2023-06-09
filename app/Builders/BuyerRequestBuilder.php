<?php

namespace App\Builders;

use App\Models\User;

/**
 * @property User $user
 */
class BuyerRequestBuilder
{
    private function addAddressField(string $street = null, 
    string $city = null, 
    string $state = null, 
    string $zip = null,
    string $country = null,
    string $phoneNumber = null):  array
    {
        return [
            'street' => $street,
            'city' => $city,
            'state' => $state,
            'postalCode' => $zip,
            'country' => $country,
            'phoneNumber' => $phoneNumber
        ];
    }

    public function build(User $user): array
    {
        return [
            'document' => $user->id_number,
            'documentType' => 'CC',
            'name' => $user->first_name, 
            'surname' => $user->last_name, 
            'company' => null,
            'email' => $user->email, 
            'mobile' => $user->cellphone, 
            'address' => $this->addAddressField($user->address, 
            $user->city,  
            $user->state, 
            $user->zip, 
            $user->country, 
            $user->cellphone), 
        ];
    }
}