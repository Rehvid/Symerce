<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\DeliveryAddress;
use App\Entity\Embeddables\ContactDetails;
use App\Entity\InvoiceAddress;

final readonly class OrderModelData
{
    public function __construct(
        public Cart $cart,
        public DeliveryAddress $deliveryAddress,
        public ContactDetails $contactDetails,
        public ?InvoiceAddress $invoiceAddress = null,
        public ?Customer $customer = null,
    ) {

    }
}
