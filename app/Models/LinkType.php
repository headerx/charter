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
                return 'Internal Link';
            case LinkType::ExternalLink:
                return 'External Link';
            case LinkType::InternalIframe:
                return 'Internal Iframe';
            case LinkType::ExternalIframe:
                return 'External Iframe';
        }
    }
}
