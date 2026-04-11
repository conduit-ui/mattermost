<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CloudCustomer extends SpatieData
{
    public function __construct(
        #[MapName('billing_address')]
        public ?Address $billingAddress = null,
        #[MapName('company_address')]
        public ?Address $companyAddress = null,
        #[MapName('contact_first_name')]
        public ?string $contactFirstName = null,
        #[MapName('contact_last_name')]
        public ?string $contactLastName = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('creator_id')]
        public ?string $creatorId = null,
        public ?string $email = null,
        public ?string $id = null,
        public ?string $name = null,
        #[MapName('num_employees')]
        public ?string $numEmployees = null,
        #[MapName('payment_method')]
        public ?PaymentMethod $paymentMethod = null,
    ) {}
}
