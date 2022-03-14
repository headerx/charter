<?php

namespace App\Models;

enum LinkMenu: string
{
    case NavigationMenu = 'navigation-menu';
    case UserDropdown = 'user-dropdown';
}
