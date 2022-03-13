<?php

namespace App\Models;

enum LinkType: string
{
    case Navigation = 'navigation';
    case Sidebar = 'sidebar';
    case UserDropdown = 'user_dropdown';
}
