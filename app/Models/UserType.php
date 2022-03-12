<?php

namespace App\Models;

enum UserType: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Organization = 'organization';
    case User = 'user';
    case Customer = 'customer';
    case Guest = 'guest';
}
