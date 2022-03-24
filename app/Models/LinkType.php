<?php

namespace App\Models;

enum LinkType: string
{
    case Link = 'link';
    case InternalLink = 'internal_link';
    case ExternalLink = 'external_link';
    case InternalIframe = 'internal_iframe';
    case ExternalIframe = 'external_iframe';

    public function prettyName(): string
    {
        switch ($this) {
            case LinkType::Link:
                return 'Link';
            
            
            
            
            
            // no break
            case LinkType::InternalLink:
                return 'Local Path (/dashboard)';
            case LinkType::ExternalLink:
                return 'URL (http://example.com)';
            case LinkType::InternalIframe:
                return 'Local Path in an Iframe';
            case LinkType::ExternalIframe:
                return 'Full URL in an Iframe';
        }
    }
}
