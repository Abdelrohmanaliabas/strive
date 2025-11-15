<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification; // change this

class Notification extends DatabaseNotification
{
    use HasFactory;
}
