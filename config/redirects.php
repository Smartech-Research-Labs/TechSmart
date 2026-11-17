<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Renamed blog post slugs (old => new)
    |--------------------------------------------------------------------------
    |
    | Posts were renamed when the site content moved from South Africa to Kenya.
    | Old URLs permanently redirect (301) to the new ones so existing links and
    | search results keep working; the blog API also resolves either slug.
    |
    */

    'blog_slugs' => [
        '10-ways-ai-is-transforming-south-african-businesses-in-2025' => '10-ways-ai-is-transforming-kenyan-businesses-in-2025',
        'building-a-world-class-e-commerce-experience-in-south-africa' => 'building-a-world-class-e-commerce-experience-in-kenya',
        'popia-compliance-checklist-what-your-business-must-do-in-2025' => 'data-protection-act-compliance-checklist-what-your-business-must-do-in-2025',
    ],

];
