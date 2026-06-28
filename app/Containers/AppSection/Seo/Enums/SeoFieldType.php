<?php

namespace App\Containers\AppSection\Seo\Enums;

enum SeoFieldType: string
{
    case TITLE = 'title';
    case DESCRIPTION = 'description';
    case KEYWORDS = 'keywords';
    case OG_TITLE = 'og_title';
    case OG_DESCRIPTION = 'og_description';
    case OG_IMAGE = 'og_image';
}
