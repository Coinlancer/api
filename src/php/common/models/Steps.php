<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Steps extends Model
{
    const STATUS_CREATED = 0;
    const STATUS_WAIT_DEPOSIT_CONFIRMATION = 1;
    const STATUS_DEPOSITED = 2;
    const STATUS_MARK_AS_DONE = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_REFUNDED = 5;
}