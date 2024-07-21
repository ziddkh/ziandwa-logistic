<?php

namespace App\Enums;

enum ShipperStatusEnums: string
{
    case PENDING = "Pending";
    case DELIVERED = "Delivered";
    case RECEIVED = "Received";
}
