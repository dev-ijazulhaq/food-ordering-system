<?php

namespace App\Domains\User\ValueObjects;

enum Role: string
{
    case ADMIN = 'admin';
    case RESTAURANT_OWNER = 'restaurant_owner';
    case CUSTOMER = 'customer';
    case DRIVER = 'driver';
}
