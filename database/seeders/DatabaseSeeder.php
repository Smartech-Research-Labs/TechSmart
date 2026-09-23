<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Client;
use App\Models\CounterItem;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Copy a bundled demo image from resources/img into the public storage
     * disk so seeded records have a working image on any fresh environment
     * (storage/app/public is gitignored, so this can't be committed directly).
     */
    public static function copySeedImage(string $sourceRelativeToResourcesImg, string $destRelativeToPublicDisk): void
    {
        $source = resource_path('img/' . $sourceRelativeToResourcesImg);
        if (!file_exists($source)) {
            return;
        }

        $dest = storage_path('app/public/' . $destRelativeToPublicDisk);
        $destDir = dirname($dest);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        copy($source, $dest);
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ──── Roles & Permissions ────
        $this->call(RolesAndPermissionsSeeder::class);

        // ──── SEO Data ────
        $this->call(SeoDataSeeder::class);

        // ──── Users ────
        $admin = User::create([
            'name' => 'Robert Gicheha',
            'email' => 'robertgicheha3@gmail.com',
            'password' => Hash::make('Admin@123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('superadmin');

        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@omniviatech.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $editor->assignRole('editor');

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        // ──── Settings ────
        $settings = [
            // General
            ['key' => 'site_name',       'value' => 'OmniviaTech',                              'group' => 'general', 'type' => 'text'],
            ['key' => 'tagline',         'value' => 'Orbiting the edge of tech',         'group' => 'general', 'type' => 'text'],
            ['key' => 'logo_path',       'value' => null,                                      'group' => 'general', 'type' => 'text'],
            ['key' => 'copyright_text',  'value' => '© 2026 OmniviaTech Technologies. All rights reserved.', 'group' => 'general', 'type' => 'text'],

            // Contact
            ['key' => 'contact_email',   'value' => 'info@omniviatech.co.ke',                   'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone',   'value' => '+254 710351517',                        'group' => 'contact', 'type' => 'text'],
            ['key' => 'address',         'value' => 'Nairobi, Kenya', 'group' => 'contact', 'type' => 'text'],

            // Social Media
            ['key' => 'facebook_url',    'value' => 'https://facebook.com/omniviatech',         'group' => 'social', 'type' => 'text'],
            ['key' => 'twitter_url',     'value' => 'https://x.com/omniviatech',                'group' => 'social', 'type' => 'text'],
            ['key' => 'linkedin_url',    'value' => 'https://linkedin.com/company/omniviatech', 'group' => 'social', 'type' => 'text'],
            ['key' => 'instagram_url',   'value' => 'https://instagram.com/omniviatech',        'group' => 'social', 'type' => 'text'],
            ['key' => 'youtube_url',     'value' => 'https://youtube.com/@omniviatech',         'group' => 'social', 'type' => 'text'],
            ['key' => 'tiktok_url',      'value' => 'https://tiktok.com/@omniviatech',          'group' => 'social', 'type' => 'text'],
            ['key' => 'whatsapp_url',    'value' => 'https://wa.me/254710351517',              'group' => 'social', 'type' => 'text'],

            // Marquee / Top Bar
            ['key' => 'marquee_text',    'value' => '🚀 Free consultation for new clients|💡 AI-powered solutions now available|🔒 Cybersecurity audit — limited offer|📱 Mobile app development starting at R15,000|⭐ Rated #1 tech agency in Johannesburg', 'group' => 'general', 'type' => 'text'],

            // SEO
            ['key' => 'seo_title',       'value' => 'OmniviaTech Technologies | Custom Web, Mobile App & E-Commerce Development', 'group' => 'seo', 'type' => 'text'],
            ['key' => 'seo_description', 'value' => 'OmniviaTech Technologies delivers custom web development, mobile apps, e-commerce platforms, APIs, and cloud solutions for modern businesses.', 'group' => 'seo', 'type' => 'textarea'],

            // Theme
            ['key' => 'theme_preset',        'value' => 'purple',  'group' => 'theme', 'type' => 'text'],
            ['key' => 'theme_primary_color', 'value' => '#d311f5', 'group' => 'theme', 'type' => 'text'],
            ['key' => 'theme_accent_color',  'value' => '#3b82f6', 'group' => 'theme', 'type' => 'text'],
        ];

        foreach ($settings as $s) {
            Setting::set($s['key'], $s['value'], $s['group'], $s['type']);
        }

        // ──── Sliders ────
        // $sliders = [
        //     [
        //         'heading'          => 'Transforming Ideas Into Digital Reality',
        //         'subheading'       => 'We build cutting-edge web applications, mobile apps, and AI-driven solutions that propel your business forward.',
        //         'description'      => 'From concept to deployment — experience world-class software engineering.',
        //         'background_image' => 'images/slider-1.webp',
        //         'cta_label'        => 'Get Started',
        //         'cta_url'          => '/contact',
        //         'cta_label_2'      => 'Our Services',
        //         'cta_url_2'        => '/services',
        //         'is_visible'       => true,
        //         'order'            => 1,
        //     ],
        //     [
        //         'heading'          => 'AI & Machine Learning Solutions',
        //         'subheading'       => 'Harness the power of artificial intelligence to automate processes, gain insights, and outpace competitors.',
        //         'description'      => 'Smart automation for smarter businesses.',
        //         'background_image' => 'images/slider-2.webp',
        //         'cta_label'        => 'Explore AI',
        //         'cta_url'          => '/services',
        //         'cta_label_2'      => 'Case Studies',
        //         'cta_url_2'        => '/products',
        //         'is_visible'       => true,
        //         'order'            => 2,
        //     ],
        //     [
        //         'heading'          => 'Secure. Scalable. Future-Ready.',
        //         'subheading'       => 'Enterprise-grade cybersecurity and cloud infrastructure designed for African businesses going global.',
        //         'description'      => 'Protect your assets with our SOC-as-a-Service solutions.',
        //         'background_image' => 'images/slider-3.webp',
        //         'cta_label'        => 'Learn More',
        //         'cta_url'          => '/services',
        //         'cta_label_2'      => 'Contact Us',
        //         'cta_url_2'        => '/contact',
        //         'is_visible'       => true,
        //         'order'            => 3,
        //     ],
        //     [
        //         'heading'          => 'E-Commerce That Converts',
        //         'subheading'       => 'Custom online stores, payment integrations, and marketing dashboards that drive revenue 24/7.',
        //         'description'      => 'Launch your digital storefront in weeks, not months.',
        //         'background_image' => 'images/slider-4.webp',
        //         'cta_label'        => 'View Products',
        //         'cta_url'          => '/products',
        //         'cta_label_2'      => 'Get a Quote',
        //         'cta_url_2'        => '/contact',
        //         'is_visible'       => true,
        //         'order'            => 4,
        //     ],
        // ];

        // ──── Sliders ────
        $sliders = [
            [
                'heading'          => 'Custom Web Development That Drives Results',
                'subheading'       => 'We build fast, scalable, and modern web applications tailored to your business needs.',
                'description'      => 'From concept to deployment — powerful custom web solutions built for performance and growth.',
                'background_image' => 'images/slider-1.webp',
                'cta_label'        => 'Get Started',
                'cta_url'          => '/contact',
                'cta_label_2'      => 'Our Services',
                'cta_url_2'        => '/services',
                'is_visible'       => true,
                'order'            => 1,
            ],
            [
                'heading'          => 'Mobile App Development for iOS & Android',
                'subheading'       => 'We design and develop high-performance mobile apps that users love.',
                'description'      => 'Native and cross-platform mobile applications built for speed, usability, and scale.',
                'background_image' => 'images/slider-2.webp',
                'cta_label'        => 'Explore Apps',
                'cta_url'          => '/services',
                'cta_label_2'      => 'Case Studies',
                'cta_url_2'        => '/products',
                'is_visible'       => true,
                'order'            => 2,
            ],
            [
                'heading'          => 'API Development & Seamless Integration',
                'subheading'       => 'Connect systems, services, and platforms with secure and scalable APIs.',
                'description'      => 'We build robust APIs and integrate third-party services to power your digital ecosystem.',
                'background_image' => 'images/slider-3.webp',
                'cta_label'        => 'Learn More',
                'cta_url'          => '/services',
                'cta_label_2'      => 'Contact Us',
                'cta_url_2'        => '/contact',
                'is_visible'       => true,
                'order'            => 3,
            ],
            [
                'heading'          => 'Legacy System Modernization',
                'subheading'       => 'Upgrade outdated systems into modern, scalable, and efficient solutions.',
                'description'      => 'We transform legacy software into secure, cloud-ready, and high-performance platforms.',
                'background_image' => 'images/slider-4.webp',
                'cta_label'        => 'Modernize Now',
                'cta_url'          => '/services',
                'cta_label_2'      => 'Get a Quote',
                'cta_url_2'        => '/contact',
                'is_visible'       => true,
                'order'            => 4,
            ],
        ];

        // Bundled demo backgrounds (no dedicated slider photography exists yet —
        // reusing generic tech imagery so sliders don't render a broken image).
        self::copySeedImage('tech-background.webp', 'images/slider-1.webp');
        self::copySeedImage('tech-glow.webp', 'images/slider-2.webp');
        self::copySeedImage('tech-closeup.webp', 'images/slider-3.webp');
        self::copySeedImage('tech-image.webp', 'images/slider-4.webp');

        foreach ($sliders as $s) {
            Slider::create($s);
        }

        // ──── Counter Items ────
        $counters = [
            ['label' => 'Projects Delivered',  'number' => 350, 'suffix' => '+', 'icon' => 'briefcase',    'is_visible' => true, 'order' => 1],
            ['label' => 'Happy Clients',       'number' => 120, 'suffix' => '+', 'icon' => 'users',        'is_visible' => true, 'order' => 2],
            ['label' => 'Team Members',        'number' => 45,  'suffix' => null, 'icon' => 'user-group',  'is_visible' => true, 'order' => 3],
            ['label' => 'Countries Served',    'number' => 12,  'suffix' => null, 'icon' => 'globe',       'is_visible' => true, 'order' => 4],
            ['label' => 'Uptime Guarantee',    'number' => 99,  'suffix' => '%',  'icon' => 'shield-check','is_visible' => true, 'order' => 5],
        ];

        foreach ($counters as $c) {
            CounterItem::create($c);
        }

        // ──── Services (handled by dedicated seeder) ────
        $this->call(ServicesSeeder::class);

        // ──── Products ────
        $products = [
            [
                'name'              => 'SmartCMS Pro',
                'slug'              => 'smartcms-pro',
                'short_description' => 'A powerful content management system with drag-and-drop page building, multi-language support, and built-in analytics.',
                'description'       => '<p>SmartCMS Pro is our flagship CMS designed for businesses that need full control over their digital presence. Features include visual page builder, role-based access control, media management, and SEO tools.</p>',
                'category'          => 'Software',
                'features'          => ['Drag & Drop Builder', 'Multi-Language', 'Built-in Analytics', 'Role-Based Access', 'REST API', 'White-Label Option'],
                'specifications'    => ['Framework' => 'Laravel + Vue.js', 'Hosting' => 'Cloud / On-Premise', 'Support' => '24/7 Priority', 'Updates' => 'Monthly'],
                'is_featured'       => true,
                'is_published'      => true,
                'order'             => 1,
            ],
            [
                'name'              => 'SmartShop Platform',
                'slug'              => 'smartshop-platform',
                'short_description' => 'Full-featured e-commerce platform with payment gateways, inventory management, and marketing automation.',
                'description'       => '<p>SmartShop is a turnkey e-commerce solution supporting PayFast, Stripe, and mobile money. Features include product variants, bulk import, automated email marketing, and real-time inventory tracking.</p>',
                'category'          => 'E-Commerce',
                'features'          => ['Multi-Gateway Payments', 'Inventory Management', 'Marketing Automation', 'Mobile-First Design', 'Order Tracking', 'Abandoned Cart Recovery'],
                'specifications'    => ['Framework' => 'Laravel + Vue.js', 'Payments' => 'PayFast, Stripe, PayPal', 'Shipping' => 'Courier Guy, DHL', 'Updates' => 'Bi-weekly'],
                'is_featured'       => true,
                'is_published'      => true,
                'order'             => 2,
            ],
            [
                'name'              => 'SmartAnalytics Dashboard',
                'slug'              => 'smartanalytics-dashboard',
                'short_description' => 'Real-time business intelligence dashboard with custom KPIs, data visualisation, and automated reporting.',
                'description'       => '<p>Connect your databases, APIs, and spreadsheets into a single pane of glass. SmartAnalytics provides interactive charts, drill-down capabilities, and scheduled PDF/Excel reports.</p>',
                'category'          => 'Analytics',
                'features'          => ['Real-Time Dashboards', 'Custom KPIs', 'Multi-Source Integration', 'Scheduled Reports', 'Role-Based Views', 'Export to PDF/Excel'],
                'is_featured'       => true,
                'is_published'      => true,
                'order'             => 3,
            ],
            [
                'name'              => 'SmartChat AI',
                'slug'              => 'smartchat-ai',
                'short_description' => 'AI-powered customer support chatbot with natural language understanding and seamless human handoff.',
                'description'       => '<p>Reduce support costs by up to 60%. SmartChat AI handles FAQs, appointment booking, and order enquiries around the clock. Escalates complex queries to human agents with full context.</p>',
                'category'          => 'AI',
                'features'          => ['24/7 Availability', 'NLP Understanding', 'Human Handoff', 'Multi-Language', 'Analytics Dashboard', 'Custom Training'],
                'is_featured'       => false,
                'is_published'      => true,
                'order'             => 4,
            ],
            [
                'name'              => 'SmartSecure Firewall',
                'slug'              => 'smartsecure-firewall',
                'short_description' => 'Managed web application firewall with DDoS protection, bot mitigation, and real-time threat alerts.',
                'description'       => '<p>Protect your web applications with enterprise-grade security. SmartSecure Firewall provides layer-7 protection, rate limiting, geo-blocking, and SSL certificate management.</p>',
                'category'          => 'Security',
                'features'          => ['DDoS Protection', 'Bot Mitigation', 'SSL Management', 'Geo-Blocking', 'Real-Time Alerts', 'Custom Rules'],
                'is_featured'       => false,
                'is_published'      => true,
                'order'             => 5,
            ],
            [
                'name'              => 'SmartBackup Cloud',
                'slug'              => 'smartbackup-cloud',
                'short_description' => 'Automated cloud backup solution with encryption, versioning, and one-click disaster recovery.',
                'description'       => '<p>Never lose data again. SmartBackup Cloud provides incremental backups, AES-256 encryption, point-in-time recovery, and compliance-ready audit logs.</p>',
                'category'          => 'Infrastructure',
                'features'          => ['Automated Backups', 'AES-256 Encryption', 'Point-in-Time Recovery', 'Multi-Region Storage', 'Compliance Logs', 'One-Click Restore'],
                'is_featured'       => false,
                'is_published'      => true,
                'order'             => 6,
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        // ──── Clients ────
        // NOTE: Parkrose, Frarega and Smartech have no matching logo asset in
        // resources/img/clients — their `logo` path is left unset (null) rather
        // than pointing at a file that doesn't exist. Upload real logos for
        // these via the admin Clients panel.
        $clients = [
            ['name' => 'Parkrose Plumbing Ltd',        'logo' => null,                                   'website_url' => 'https://parkroseplumbing.co.ke',         'domain' => 'parkroseplumbing.co.ke',        'caption' => 'Premier plumbing solutions across Kenya', 'is_visible' => true, 'is_seeded' => true, 'order' => 1],
            ['name' => 'Medialytica',                   'logo' => 'images/clients/medialytica.webp',      'website_url' => 'https://medialytica.com',              'domain' => 'medialytica.com',               'caption' => 'Data-driven media analytics platform', 'is_visible' => true, 'is_seeded' => true, 'order' => 2],
            ['name' => 'Tech for Development',          'logo' => 'images/clients/tech-dev.webp',         'website_url' => 'https://techfordevelopment.org',       'domain' => 'techfordevelopment.org',         'caption' => 'Technology solutions for community development', 'is_visible' => true, 'is_seeded' => true, 'order' => 3],
            ['name' => 'Indepth Research Institute',     'logo' => 'images/clients/indepth.webp',          'website_url' => 'https://indepthresearch.org',          'domain' => 'indepthresearch.org',           'caption' => 'Advanced research and analytics institute', 'is_visible' => true, 'is_seeded' => true, 'order' => 4],
            ['name' => 'Omidrop',                       'logo' => 'images/clients/omidrop.webp',          'website_url' => 'https://omidrop.com',                  'domain' => 'omidrop.com',                   'caption' => 'Innovative logistics and supply chain solutions', 'is_visible' => true, 'is_seeded' => true, 'order' => 5],
            ['name' => 'Maji Hill',                     'logo' => 'images/clients/maji-hill.webp',        'website_url' => 'https://majihill.co.ke',               'domain' => 'majihill.co.ke',                'caption' => 'Water solutions for sustainable communities', 'is_visible' => true, 'is_seeded' => true, 'order' => 6],
            ['name' => 'Frarega Ltd',                   'logo' => null,                                   'website_url' => 'https://frarega.co.ke',                'domain' => 'frarega.co.ke',                 'caption' => 'Fresh produce and agricultural export leader', 'is_visible' => true, 'is_seeded' => true, 'order' => 7],
            ['name' => 'Ziara Travels Ltd',             'logo' => 'images/clients/ziara.webp',            'website_url' => 'https://ziaratravels.com',             'domain' => 'ziaratravels.com',              'caption' => 'Premium travel and tourism experiences', 'is_visible' => true, 'is_seeded' => true, 'order' => 8],
            ['name' => 'Smartech Research Labs',        'logo' => null,                                   'website_url' => 'https://smartechresearch.com',         'domain' => 'smartechresearch.com',          'caption' => 'Cutting-edge tech research and development', 'is_visible' => true, 'is_seeded' => true, 'order' => 9],
            ['name' => 'Nexxear Digital Solutions',      'logo' => 'images/clients/nexxear.webp',          'website_url' => 'https://nexxear.com',                  'domain' => 'nexxear.com',                   'caption' => 'Next-generation digital transformation partner', 'is_visible' => true, 'is_seeded' => true, 'order' => 10],
            ['name' => 'Magnate Digital Solutions',      'logo' => 'images/clients/magnate.webp',          'website_url' => 'https://magnate.digital',              'domain' => 'magnate.digital',               'caption' => 'Enterprise digital solutions at scale', 'is_visible' => true, 'is_seeded' => true, 'order' => 11],
        ];

        self::copySeedImage('clients/Medialytica.webp', 'images/clients/medialytica.webp');
        self::copySeedImage('clients/Tech for development.webp', 'images/clients/tech-dev.webp');
        self::copySeedImage('clients/IRES-logo.webp', 'images/clients/indepth.webp');
        self::copySeedImage('clients/Omidrop.webp', 'images/clients/omidrop.webp');
        self::copySeedImage('clients/Majihill.webp', 'images/clients/maji-hill.webp');
        self::copySeedImage('clients/Ziara Travels.webp', 'images/clients/ziara.webp');
        self::copySeedImage('clients/Nexera.webp', 'images/clients/nexxear.webp');
        self::copySeedImage('clients/Magnate Digital.webp', 'images/clients/magnate.webp');

        foreach ($clients as $c) {
            Client::create($c);
        }

        // ──── FAQ Categories & FAQs ────
        $generalCat = FaqCategory::create(['name' => 'General', 'slug' => 'general', 'order' => 1]);
        $techCat    = FaqCategory::create(['name' => 'Technical', 'slug' => 'technical', 'order' => 2]);
        $pricingCat = FaqCategory::create(['name' => 'Pricing & Billing', 'slug' => 'pricing-billing', 'order' => 3]);
        $supportCat = FaqCategory::create(['name' => 'Support', 'slug' => 'support', 'order' => 4]);

        $faqs = [
            ['faq_category_id' => $generalCat->id, 'question' => 'What services does OmniviaTech offer?',              'answer' => 'We offer web development, mobile app development, cloud & infrastructure, AI & data analytics, cybersecurity, and IT consulting. Each service is fully customisable to your business needs.', 'is_visible' => true, 'order' => 1],
            ['faq_category_id' => $generalCat->id, 'question' => 'Where is OmniviaTech based?',                        'answer' => 'We are headquartered in Sandton, Johannesburg, South Africa. We serve clients across Africa and internationally through our remote-capable team.', 'is_visible' => true, 'order' => 2],
            ['faq_category_id' => $generalCat->id, 'question' => 'How long does a typical project take?',            'answer' => 'Project timelines vary based on scope. A standard website takes 4-8 weeks, a mobile app 8-16 weeks, and enterprise solutions 3-6 months. We provide detailed timelines during the proposal phase.', 'is_visible' => true, 'order' => 3],
            ['faq_category_id' => $techCat->id,    'question' => 'What technologies do you use?',                    'answer' => 'Our primary stack includes Laravel, Vue.js, React, React Native, Flutter, Python, AWS, Azure, and Google Cloud. We select the best fit based on your project requirements.', 'is_visible' => true, 'order' => 1],
            ['faq_category_id' => $techCat->id,    'question' => 'Do you provide API integrations?',                 'answer' => 'Yes, we specialise in RESTful and GraphQL API development and can integrate with payment gateways (PayFast, Stripe), CRMs (Salesforce, HubSpot), ERPs, and third-party services.', 'is_visible' => true, 'order' => 2],
            ['faq_category_id' => $techCat->id,    'question' => 'Can I host the solution on my own servers?',       'answer' => 'Absolutely. We support cloud, on-premise, and hybrid deployments. We will help you choose the optimal infrastructure for your workload and budget.', 'is_visible' => true, 'order' => 3],
            ['faq_category_id' => $pricingCat->id, 'question' => 'How is pricing structured?',                       'answer' => 'We offer flexible pricing including fixed-price projects, monthly retainers, and time-and-materials billing. All proposals include transparent cost breakdowns with no hidden fees.', 'is_visible' => true, 'order' => 1],
            ['faq_category_id' => $pricingCat->id, 'question' => 'Do you offer payment plans?',                      'answer' => 'Yes. For larger projects we offer milestone-based payments — typically 30% upfront, 40% at mid-project, and 30% on delivery. Custom plans are available for enterprise clients.', 'is_visible' => true, 'order' => 2],
            ['faq_category_id' => $supportCat->id, 'question' => 'What post-launch support do you offer?',           'answer' => 'All projects include 3 months of complimentary support. Extended support packages (24/7 monitoring, SLA guarantees, and priority hotline) are available at competitive rates.', 'is_visible' => true, 'order' => 1],
            ['faq_category_id' => $supportCat->id, 'question' => 'How do I report a bug or request a feature?',      'answer' => 'You can reach our support team via the in-app chat, email support@omniviatech.com, or our client portal. Critical issues receive a response within 1 hour during business days.', 'is_visible' => true, 'order' => 2],
        ];

        foreach ($faqs as $f) {
            Faq::create($f);
        }

        // ──── Bundles ────
        $webService  = Service::where('slug', 'custom-web-development')->first();
        $aiService   = Service::where('slug', 'business-intelligence-analytics')->first();
        $cmsProduct  = Product::where('slug', 'smartcms-pro')->first();
        $chatProduct = Product::where('slug', 'smartchat-ai')->first();

        $starterBundle = Bundle::create([
            'name'              => 'Digital Starter Pack',
            'slug'              => 'digital-starter-pack',
            'short_description' => 'Everything you need to launch your online presence — website, CMS, and AI chatbot bundled at a special rate.',
            'description'       => '<p>Get online fast with our curated starter bundle. Includes a custom-built website, SmartCMS Pro for content management, and SmartChat AI for 24/7 customer support. Contact us for pricing and a personalized quote.</p>',
            'price'             => null,
            'price_label'       => 'Contact us for pricing',
            'whats_included'    => ['Custom Website', 'SmartCMS Pro (6 months)', 'SmartChat AI (6 months)', 'SEO Setup', '3 Months Support'],
            'is_featured'       => true,
            'is_published'      => true,
            'order'             => 1,
        ]);

        if ($webService && $cmsProduct) {
            BundleItem::create(['bundle_id' => $starterBundle->id, 'bundleable_type' => Service::class, 'bundleable_id' => $webService->id, 'quantity' => 1]);
            BundleItem::create(['bundle_id' => $starterBundle->id, 'bundleable_type' => Product::class, 'bundleable_id' => $cmsProduct->id,  'quantity' => 1]);
        }
        if ($chatProduct) {
            BundleItem::create(['bundle_id' => $starterBundle->id, 'bundleable_type' => Product::class, 'bundleable_id' => $chatProduct->id, 'quantity' => 1]);
        }

        $enterpriseBundle = Bundle::create([
            'name'              => 'Enterprise Growth Suite',
            'slug'              => 'enterprise-growth-suite',
            'short_description' => 'Complete digital transformation package with AI analytics, e-commerce platform, cybersecurity, and ongoing consulting.',
            'description'       => '<p>Our most comprehensive bundle for enterprises ready to dominate their market. Combines our top products with premium services for an end-to-end digital strategy. Contact us for a customized enterprise quote.</p>',
            'price'             => null,
            'price_label'       => 'Contact us for enterprise pricing',
            'whats_included'    => ['SmartShop E-Commerce', 'SmartAnalytics Dashboard', 'SmartSecure Firewall', 'AI Consulting (40 hrs)', 'Cloud Migration', '12 Months Priority Support'],
            'is_featured'       => true,
            'is_published'      => true,
            'order'             => 2,
        ]);

        // ──── Blog Posts ────
        $blogPosts = [
            [
                'title'           => '10 Ways AI Is Transforming South African Businesses in 2025',
                'excerpt'         => 'Artificial intelligence is no longer a futuristic concept — it is reshaping how businesses operate across the continent. Here are the top 10 trends driving change.',
                'content'         => '<h2>The AI Revolution in Africa</h2><p>From automated customer service to predictive maintenance in mining operations, artificial intelligence is fundamentally changing how South African businesses compete globally. In 2025, adoption has accelerated across every sector.</p><h3>1. Intelligent Customer Service</h3><p>AI chatbots now handle up to 70% of first-line customer queries, dramatically reducing wait times and support costs. Companies like banks and telecoms lead the way with NLP-powered assistants that understand isiZulu, Afrikaans, and Sesotho.</p><h3>2. Predictive Analytics for Retail</h3><p>Retailers are using machine learning to forecast demand, optimise inventory, and personalise recommendations. This has led to a 25% reduction in stockouts and a 15% increase in average order value.</p><h3>3. Automated Financial Compliance</h3><p>RegTech solutions powered by AI are helping financial institutions meet FICA and POPIA requirements automatically, reducing compliance costs by up to 40%.</p><h3>4. Smart Agriculture</h3><p>Precision farming technologies use satellite imagery and ML models to optimise irrigation, detect crop diseases, and predict yields with remarkable accuracy.</p><h3>5. Healthcare Diagnostics</h3><p>AI-assisted diagnostics are expanding access to quality healthcare in rural areas, with image recognition models screening for conditions like diabetic retinopathy and tuberculosis.</p><p>The remaining five trends — fraud detection, logistics optimisation, energy management, HR automation, and content generation — are equally transformative. Contact OmniviaTech to explore how AI can benefit your business.</p>',
                'featured_image'  => 'blog/tech1.webp',
                'category'        => 'Artificial Intelligence',
                'tags'            => ['AI', 'machine learning', 'South Africa', 'digital transformation', 'business'],
                'author_id'       => $admin->id,
                'seo_title'       => '10 Ways AI Is Transforming SA Businesses in 2025 | OmniviaTech',
                'seo_description' => 'Discover how artificial intelligence is reshaping South African businesses. From chatbots to predictive analytics — the 10 biggest AI trends of 2025.',
                'seo_keywords'    => 'AI South Africa, machine learning business, digital transformation africa',
                'is_published'    => true,
                'published_at'    => now()->subDays(3),
            ],
            [
                'title'           => 'Why Every Business Needs a Cybersecurity Strategy in 2025',
                'excerpt'         => 'Cyber attacks on African businesses surged 150% last year. Here is why a proactive cybersecurity strategy is no longer optional — and how to get started.',
                'content'         => '<h2>The Growing Threat Landscape</h2><p>South Africa ranks among the top 10 most targeted countries for cyber attacks globally. Ransomware, phishing, and supply-chain attacks have escalated dramatically, costing businesses billions in damages and lost productivity.</p><h3>Understanding the Risk</h3><p>Small and medium businesses are particularly vulnerable because they often lack dedicated security teams. A single breach can result in data loss, regulatory penalties under POPIA, and irreparable reputational damage.</p><h3>Building Your Defence</h3><p>A comprehensive cybersecurity strategy includes: vulnerability assessments, employee security awareness training, multi-factor authentication, endpoint protection, and incident response planning.</p><h3>The ROI of Security</h3><p>For every R1 invested in proactive cybersecurity, companies save an average of R7 in breach-related costs. It is one of the highest-return investments a business can make.</p><p>OmniviaTech offers end-to-end cybersecurity services including penetration testing, SOC-as-a-Service, and POPIA compliance consulting. Reach out for a free security assessment.</p>',
                'featured_image'  => 'blog/tech2.webp',
                'category'        => 'Cybersecurity',
                'tags'            => ['cybersecurity', 'POPIA', 'data protection', 'ransomware', 'business security'],
                'author_id'       => $admin->id,
                'seo_title'       => 'Why Every Business Needs Cybersecurity in 2025 | OmniviaTech',
                'seo_description' => 'Cyber attacks on African businesses surged 150%. Learn why a cybersecurity strategy is essential and how to protect your company in 2025.',
                'seo_keywords'    => 'cybersecurity South Africa, POPIA compliance, business security',
                'is_published'    => true,
                'published_at'    => now()->subDays(7),
            ],
            [
                'title'           => 'The Complete Guide to Choosing the Right Tech Stack for Your Startup',
                'excerpt'         => 'Your technology choices define your startup pace. Learn how to pick the right frameworks, databases, and hosting for speed, cost, and scalability.',
                'content'         => '<h2>Stack Decisions Matter</h2><p>Choosing the wrong tech stack can cost startups months of development time and tens of thousands of rands. The right choice accelerates your MVP, simplifies hiring, and positions you for growth.</p><h3>Frontend Frameworks</h3><p>React dominates the market with its vast ecosystem, while Vue.js offers a gentler learning curve and excellent performance. For SSR and SEO, Next.js (React) and Nuxt.js (Vue) are top picks.</p><h3>Backend Frameworks</h3><p>Laravel (PHP) excels for rapid development with its built-in authentication, ORM, and queue system. Node.js with Express is ideal for real-time applications. Django (Python) shines for data-heavy applications and ML integration.</p><h3>Database Selection</h3><p>PostgreSQL is the all-rounder for structured data. MongoDB suits flexible schemas and rapid prototyping. Redis is essential for caching and real-time features.</p><h3>Hosting & Infrastructure</h3><p>AWS dominates enterprise, while DigitalOcean and Hetzner offer cost-effective options for startups. Serverless architectures using Lambda or Cloud Functions reduce operational overhead.</p><p>At OmniviaTech, we help startups make informed stack decisions that balance speed, cost, and long-term maintainability.</p>',
                'featured_image'  => 'blog/tech3.webp',
                'category'        => 'Development',
                'tags'            => ['startup', 'tech stack', 'Laravel', 'Vue.js', 'React', 'development'],
                'author_id'       => $editor->id,
                'seo_title'       => 'Complete Guide to Choosing a Tech Stack for Startups | OmniviaTech',
                'seo_description' => 'Learn how to choose the right tech stack for your startup. Compare frameworks, databases, and hosting options for speed, cost, and scalability.',
                'seo_keywords'    => 'tech stack startup, Laravel vs Node, Vue vs React, web development guide',
                'is_published'    => true,
                'published_at'    => now()->subDays(14),
            ],
            [
                'title'           => 'How Cloud Migration Can Cut Your IT Costs by 40%',
                'excerpt'         => 'Still running on-premise servers? Here is how migrating to the cloud can dramatically reduce your IT spending while boosting reliability and performance.',
                'content'         => '<h2>The Case for Cloud</h2><p>On-premise infrastructure demands capital expenditure on hardware, physical space, power, cooling, and dedicated staff. Cloud platforms convert these fixed costs into flexible, pay-as-you-go operating expenses.</p><h3>Cost Savings Breakdown</h3><p>Our clients typically see a 30-40% reduction in total IT costs after migration. Key savings come from: eliminating hardware refresh cycles (20%), reduced power and cooling (8%), and staff reallocation from maintenance to innovation (12%).</p><h3>Beyond Cost: Performance Benefits</h3><p>Cloud platforms offer global CDNs, auto-scaling, and managed databases that would be prohibitively expensive to replicate on-premise. Your applications become faster, more reliable, and available worldwide.</p><h3>Migration Strategy</h3><p>We recommend a phased approach: start with non-critical workloads, validate performance, then migrate production systems. This minimises risk and allows your team to build cloud expertise gradually.</p><p>OmniviaTech has migrated over 50 organisations to AWS, Azure, and Google Cloud. Contact us for a free cloud readiness assessment.</p>',
                'featured_image'  => 'blog/tech4.webp',
                'category'        => 'Cloud',
                'tags'            => ['cloud migration', 'AWS', 'Azure', 'cost reduction', 'infrastructure'],
                'author_id'       => $admin->id,
                'seo_title'       => 'Cloud Migration: Cut IT Costs by 40% | OmniviaTech',
                'seo_description' => 'Discover how cloud migration can reduce your IT costs by 40%. Learn about phased migration strategies and the performance benefits of cloud platforms.',
                'seo_keywords'    => 'cloud migration South Africa, AWS migration, reduce IT costs',
                'is_published'    => true,
                'published_at'    => now()->subDays(21),
            ],
            [
                'title'           => 'Building a World-Class E-Commerce Experience in South Africa',
                'excerpt'         => 'South African e-commerce is booming. Here is how to build an online store that converts visitors into loyal customers with local payment methods and fast delivery.',
                'content'         => '<h2>The E-Commerce Opportunity</h2><p>South African online retail grew 30% year-on-year, reaching R71 billion in 2024. Mobile commerce now accounts for 65% of all transactions, making mobile-first design essential.</p><h3>Payment Integration</h3><p>Supporting local payment methods is critical. PayFast and Peach Payments handle card transactions, while SnapScan and Zapper cater to mobile-first shoppers. Integration with Ozow enables instant EFT, which is South Africas most popular online payment method.</p><h3>Logistics and Delivery</h3><p>Partner with multiple couriers (The Courier Guy, Pargo, Dawn Wing) to offer competitive rates and click-and-collect options. Real-time tracking and proactive SMS notifications reduce "where is my order" queries by 50%.</p><h3>Conversion Optimisation</h3><p>Key factors: page load speed under 3 seconds, simplified checkout (max 3 steps), trust signals (SSL badge, return policy), and personalised product recommendations powered by AI.</p><p>SmartShop by OmniviaTech provides all these capabilities out of the box. Launch your store and start selling within weeks.</p>',
                'featured_image'  => 'blog/tech5.webp',
                'category'        => 'E-Commerce',
                'tags'            => ['e-commerce', 'online store', 'PayFast', 'South Africa', 'mobile commerce'],
                'author_id'       => $editor->id,
                'seo_title'       => 'Building a World-Class E-Commerce Site in SA | OmniviaTech',
                'seo_description' => 'South African e-commerce hit R71 billion. Learn how to build an online store that converts with local payments, fast delivery, and mobile-first design.',
                'seo_keywords'    => 'e-commerce South Africa, online store development, PayFast integration',
                'is_published'    => true,
                'published_at'    => now()->subDays(28),
            ],
            [
                'title'           => 'POPIA Compliance Checklist: What Your Business Must Do in 2025',
                'excerpt'         => 'The Protection of Personal Information Act is fully enforceable. Use this comprehensive checklist to ensure your business meets all POPIA requirements.',
                'content'         => '<h2>POPIA Is Here to Stay</h2><p>The Information Regulator has begun issuing enforcement notices and fines. Non-compliance can result in penalties of up to R10 million or imprisonment. Every South African business that processes personal information must comply.</p><h3>Your Compliance Checklist</h3><p><strong>1. Appoint an Information Officer</strong> — Register them with the Information Regulator.</p><p><strong>2. Data Mapping</strong> — Document what personal information you collect, where its stored, and who has access.</p><p><strong>3. Privacy Policy</strong> — Update your website and internal policies to clearly explain how you handle personal data.</p><p><strong>4. Consent Management</strong> — Implement opt-in mechanisms for marketing communications and data collection.</p><p><strong>5. Security Measures</strong> — Encrypt personal data at rest and in transit. Implement access controls and regular security audits.</p><p><strong>6. Breach Procedures</strong> — Establish an incident response plan with notification procedures for the Regulator and affected parties.</p><p><strong>7. Third-Party Contracts</strong> — Ensure all data processors (cloud providers, marketing agencies) have compliant agreements in place.</p><p>OmniviaTech provides POPIA compliance consulting, technical implementation, and ongoing auditing services. Get compliant before the regulator comes knocking.</p>',
                'featured_image'  => 'blog/tech6.webp',
                'category'        => 'Compliance',
                'tags'            => ['POPIA', 'data protection', 'compliance', 'privacy', 'South Africa'],
                'author_id'       => $admin->id,
                'seo_title'       => 'POPIA Compliance Checklist 2025 | OmniviaTech',
                'seo_description' => 'Complete POPIA compliance checklist for South African businesses. Learn the 7 essential steps to meet the Protection of Personal Information Act requirements.',
                'seo_keywords'    => 'POPIA compliance, data protection South Africa, privacy act checklist',
                'is_published'    => true,
                'published_at'    => now()->subDays(35),
            ],
        ];

        foreach (range(1, 6) as $i) {
            self::copySeedImage("tech{$i}.webp", "blog/tech{$i}.webp");
        }

        foreach ($blogPosts as $post) {
            Blog::create($post);
        }

        // ──── Reviews (Approved Testimonials) ────
        $reviews = [
            [
                'user_id'         => $admin->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'custom-web-development')->value('id') ?? 1,
                'rating'          => 5,
                'content'         => 'Outstanding service! OmniviaTech built our e-commerce platform in record time with exceptional quality. The team understood our vision perfectly and delivered a solution that exceeded expectations. Our online sales increased by 200% within three months of launch.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $user->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'mobile-app-development')->value('id') ?? 2,
                'rating'          => 5,
                'content'         => 'The team is incredibly professional. They delivered our mobile app ahead of schedule and under budget. The React Native app runs flawlessly on both iOS and Android, and our customers love the intuitive interface. Would absolutely hire them again.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $editor->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'automation-testing')->value('id') ?? 11,
                'rating'          => 5,
                'content'         => 'Great experience working with OmniviaTech. Their automation solutions saved us over 200 hours monthly. The CI/CD pipeline they built reduced our deployment time from days to minutes. A true game-changer for our operations.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $admin->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'seo-optimization-analytics')->value('id') ?? 6,
                'rating'          => 5,
                'content'         => 'Highly recommend! They transformed our outdated website into a modern, responsive platform that doubled our leads. The SEO work alone took us from page 5 to the first page of Google in under 4 months. Phenomenal ROI.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $user->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'cybersecurity-data-protection')->value('id') ?? 17,
                'rating'          => 5,
                'content'         => 'Their cybersecurity audit identified critical vulnerabilities we had no idea existed. Potentially saved us millions in breach costs. The SOC-as-a-Service monitoring gives us complete peace of mind. Essential investment for any business handling sensitive data.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $editor->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'paid-ads-management')->value('id') ?? 7,
                'rating'          => 5,
                'content'         => 'Best tech partner we have ever had. Their SEO and paid ads management tripled our online revenue in just 6 months. The Google Ads campaigns they built consistently deliver a 5x return on ad spend. Truly data-driven marketing.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $admin->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'cloud-deployment-devops')->value('id') ?? 14,
                'rating'          => 5,
                'content'         => 'The cloud migration was seamless. OmniviaTech moved our entire infrastructure to AWS with zero downtime. Our hosting costs dropped by 35% and application performance improved dramatically. Their DevOps expertise is world-class.',
                'status'          => 'approved',
            ],
            [
                'user_id'         => $user->id,
                'reviewable_type' => Service::class,
                'reviewable_id'   => Service::where('slug', 'e-commerce-development')->value('id') ?? 3,
                'rating'          => 4,
                'content'         => 'OmniviaTech built our multi-vendor marketplace from the ground up. The payment integrations with PayFast and Ozow work perfectly, and the vendor dashboard is incredibly intuitive. They truly understand the South African e-commerce landscape.',
                'status'          => 'approved',
            ],
        ];

        foreach ($reviews as $r) {
            \App\Models\Review::create($r);
        }

        // ──── Packages ────
        $this->call(PackageSeeder::class);

        $this->command->info('🚀 OmniviaTech database seeded successfully!');
        $this->command->info('   Admin login: robertgicheha3@gmail.com / Admin@123');
        $this->command->info('   User login:  john@example.com / password');
    }
}
