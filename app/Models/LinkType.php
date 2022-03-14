<?php

namespace App\Models;

enum LinkType: string
{
    case Link = 'link';
    case InternalLink = 'internal_link';
    case ExternalLink = 'external_link';
    case InternalIframe = 'internal_iframe';
    case ExternalIframe = 'external_iframe';
}
