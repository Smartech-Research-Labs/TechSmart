<?php

namespace Database\Seeders;

use App\Models\SeoData;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeoDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoData = [
            // Homepage
            [
                'page_name' => 'home',
                'route_name' => 'home',
                'meta_title' => 'OmniviaTech | Digital Solutions & Web Development Services Kenya',
                'meta_description' => 'Leading digital transformation company in Kenya offering custom web development, mobile apps, e-commerce solutions, AI automation, and digital marketing. Expert team with 10+ years experience.',
                'meta_keywords' => 'web development Kenya, digital marketing, mobile app development, e-commerce solutions, AI automation, custom software, Laravel development, React development',
                'canonical_url' => 'https://omniviatech.com',
                'og_title' => 'OmniviaTech - Transform Your Digital Future',
                'og_description' => 'Partner with OmniviaTech for innovative digital solutions that drive business growth and digital transformation.',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'OmniviaTech | Digital Solutions & Web Development',
                'twitter_description' => 'Expert digital solutions provider in Kenya. Custom web development, mobile apps, AI automation.',
                'index' => true,
                'follow' => true,
            ],

            // Services Page
            [
                'page_name' => 'services',
                'route_name' => 'services.index',
                'meta_title' => 'Our Services | Web Development, Mobile Apps & Digital Solutions',
                'meta_description' => 'Explore OmniviaTech services: custom web development, mobile app development, e-commerce platforms, AI automation, digital marketing, API development, and cloud solutions.',
                'meta_keywords' => 'web development services, mobile app development, e-commerce development, API development, digital marketing, cloud solutions, AI automation, software development',
                'canonical_url' => 'https://omniviatech.com/services',
                'og_title' => 'Digital Services | Web Development & Custom Solutions',
                'og_description' => 'Comprehensive digital services for businesses. Web development, mobile apps, AI, and more.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Custom Web Development Service
            [
                'page_name' => 'service_web_development',
                'route_name' => 'services.show',
                'meta_title' => 'Custom Web Development Services | OmniviaTech Kenya',
                'meta_description' => 'Professional custom web development services in Kenya. Responsive, scalable, SEO-optimized websites built with latest technologies. Laravel, React, Vue.js specialists.',
                'meta_keywords' => 'web development, custom website, responsive design, Laravel development, React development, Vue development, web design, SEO optimization',
                'canonical_url' => 'https://omniviatech.com/services/custom-web-development',
                'og_title' => 'Custom Web Development | Professional Website Solutions',
                'og_description' => 'Get professional custom web development services. Scalable, responsive, and SEO-optimized websites.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Mobile App Development Service
            [
                'page_name' => 'service_mobile_app',
                'route_name' => 'services.show',
                'meta_title' => 'Mobile App Development | iOS & Android Apps Kenya',
                'meta_description' => 'Expert mobile app development services for iOS and Android. Native and cross-platform apps using Flutter and React Native. Get your app idea developed by experienced developers.',
                'meta_keywords' => 'mobile app development, iOS development, Android development, Flutter apps, React Native, cross-platform apps, app development Kenya',
                'canonical_url' => 'https://omniviatech.com/services/mobile-app-development',
                'og_title' => 'Mobile App Development | iOS & Android Solutions',
                'og_description' => 'Professional mobile app development for iOS and Android. Expert Flutter and React Native developers.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // E-Commerce Development Service
            [
                'page_name' => 'service_ecommerce',
                'route_name' => 'services.show',
                'meta_title' => 'E-Commerce Development | Online Store Solutions Kenya',
                'meta_description' => 'Complete e-commerce solutions including online store development, payment gateway integration, inventory management, and digital marketing to boost sales.',
                'meta_keywords' => 'e-commerce development, online store, shopping cart, payment integration, M-Pesa integration, inventory management, digital storefront',
                'canonical_url' => 'https://omniviatech.com/services/ecommerce-development',
                'og_title' => 'E-Commerce Solutions | Online Store Development',
                'og_description' => 'Build your online store with complete e-commerce solutions. Payment integration, inventory management included.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // API Development Service
            [
                'page_name' => 'service_api_development',
                'route_name' => 'services.show',
                'meta_title' => 'API Development Services | RESTful & GraphQL APIs',
                'meta_description' => 'Expert API development services. RESTful APIs, GraphQL, webhook integration, third-party integrations, and microservices architecture for scalable applications.',
                'meta_keywords' => 'API development, REST API, GraphQL, webhook integration, microservices, backend development, API design',
                'canonical_url' => 'https://omniviatech.com/services/api-development',
                'og_title' => 'API Development | RESTful & GraphQL Solutions',
                'og_description' => 'Professional API development. REST, GraphQL, microservices, and integration solutions.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // CRM & ERP Development Service
            [
                'page_name' => 'service_crm_erp',
                'route_name' => 'services.show',
                'meta_title' => 'CRM & ERP Development | Business Management Systems',
                'meta_description' => 'Custom CRM and ERP development for businesses. Streamline operations, manage customer relationships, and improve productivity with tailored business systems.',
                'meta_keywords' => 'CRM development, ERP systems, business management software, customer relationship management, enterprise systems',
                'canonical_url' => 'https://omniviatech.com/services/crm-erp-development',
                'og_title' => 'CRM & ERP Solutions | Business Management Systems',
                'og_description' => 'Custom CRM and ERP development for streamlined business operations and customer management.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // SEO Optimization Service
            [
                'page_name' => 'service_seo',
                'route_name' => 'services.show',
                'meta_title' => 'SEO Optimization Services | Rank Higher on Google Kenya',
                'meta_description' => 'Professional SEO optimization services to boost your online visibility. Keyword research, on-page optimization, technical SEO, link building, and content strategy.',
                'meta_keywords' => 'SEO services, search engine optimization, keyword research, on-page optimization, technical SEO, link building, local SEO, SEO strategy',
                'canonical_url' => 'https://omniviatech.com/services/seo-optimization',
                'og_title' => 'SEO Services | Improve Your Search Rankings',
                'og_description' => 'Professional SEO optimization to rank higher on Google and increase organic traffic.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Paid Ads Service
            [
                'page_name' => 'service_paid_ads',
                'route_name' => 'services.show',
                'meta_title' => 'Paid Ads Management | Google Ads & Facebook Ads Kenya',
                'meta_description' => 'Expert paid advertising management. Google Ads, Facebook Ads, Instagram Ads campaigns optimized for maximum ROI and lead generation.',
                'meta_keywords' => 'Google Ads, Facebook Ads, paid advertising, PPC campaigns, Instagram ads, digital marketing, ad management',
                'canonical_url' => 'https://omniviatech.com/services/paid-ads',
                'og_title' => 'Paid Ads Management | Google & Facebook Ads',
                'og_description' => 'Expert paid advertising campaigns. Google Ads, Facebook Ads, optimized for ROI.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Packages Page
            [
                'page_name' => 'packages',
                'route_name' => 'packages.index',
                'meta_title' => 'Website Packages | Affordable Web Solutions for Businesses Kenya',
                'meta_description' => 'Choose from our web packages: Basic, Advanced, Pro, or Full E-Commerce. All inclusive with hosting, domain, maintenance, and support.',
                'meta_keywords' => 'website packages, web hosting, domain registration, website maintenance, e-commerce packages, web solutions',
                'canonical_url' => 'https://omniviatech.com/packages',
                'og_title' => 'Website Packages | Affordable Web Solutions',
                'og_description' => 'Explore our comprehensive website packages. Hosting, domain, and support included.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Products Page
            [
                'page_name' => 'products',
                'route_name' => 'products.index',
                'meta_title' => 'Digital Products | Software Solutions & Tools',
                'meta_description' => 'Explore our digital products and solutions designed to solve business challenges and improve productivity.',
                'meta_keywords' => 'digital products, software solutions, business tools, productivity software',
                'canonical_url' => 'https://omniviatech.com/products',
                'og_title' => 'Digital Products | Software Solutions',
                'og_description' => 'Innovative digital products to solve your business challenges.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Blog Page
            [
                'page_name' => 'blog',
                'route_name' => 'blog.index',
                'meta_title' => 'Blog | Web Development Tips, Digital Marketing & Tech Articles',
                'meta_description' => 'Read latest articles about web development, digital marketing, SEO tips, technology trends, and business insights from OmniviaTech experts.',
                'meta_keywords' => 'web development blog, digital marketing tips, SEO articles, technology news, business insights, coding tutorials',
                'canonical_url' => 'https://omniviatech.com/blog',
                'og_title' => 'Blog | Digital & Tech Articles',
                'og_description' => 'Expert articles on web development, digital marketing, SEO, and technology.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Case Studies Page
            [
                'page_name' => 'case_studies',
                'route_name' => 'case-studies.index',
                'meta_title' => 'Case Studies | Successful Digital Transformation Projects',
                'meta_description' => 'Explore our successful project case studies. See how OmniviaTech helped businesses achieve digital transformation and growth.',
                'meta_keywords' => 'case studies, project portfolio, success stories, digital transformation, business solutions',
                'canonical_url' => 'https://omniviatech.com/case-studies',
                'og_title' => 'Case Studies | Success Stories',
                'og_description' => 'See how OmniviaTech helped businesses achieve digital transformation.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // About Page
            [
                'page_name' => 'about',
                'route_name' => 'about',
                'meta_title' => 'About OmniviaTech | Digital Solutions Company Kenya',
                'meta_description' => 'Learn about OmniviaTech. A leading digital solutions company in Kenya with 10+ years of experience in web development, mobile apps, and digital marketing.',
                'meta_keywords' => 'about us, company, team, experience, expertise, digital solutions',
                'canonical_url' => 'https://omniviatech.com/about',
                'og_title' => 'About OmniviaTech | Digital Solutions',
                'og_description' => 'OmniviaTech: 10+ years of digital solutions expertise in Kenya.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Contact Page
            [
                'page_name' => 'contact',
                'route_name' => 'contact',
                'meta_title' => 'Contact Us | Get in Touch with OmniviaTech',
                'meta_description' => 'Contact OmniviaTech for your digital project. Get a free consultation and quote. We\'re based in Kenya serving clients worldwide.',
                'meta_keywords' => 'contact, get in touch, consultation, support, inquiry',
                'canonical_url' => 'https://omniviatech.com/contact',
                'og_title' => 'Contact OmniviaTech | Free Consultation',
                'og_description' => 'Get in touch with OmniviaTech. Free consultation available.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // FAQs Page
            [
                'page_name' => 'faqs',
                'route_name' => 'faqs',
                'meta_title' => 'FAQs | Frequently Asked Questions about Our Services',
                'meta_description' => 'Get answers to frequently asked questions about OmniviaTech services, pricing, timelines, and technical support.',
                'meta_keywords' => 'FAQ, frequently asked questions, help, support',
                'canonical_url' => 'https://omniviatech.com/faqs',
                'og_title' => 'FAQs | Common Questions',
                'og_description' => 'Get answers to common questions about our services.',
                'twitter_card' => 'summary',
                'index' => true,
                'follow' => true,
            ],

            // Privacy Policy
            [
                'page_name' => 'privacy_policy',
                'route_name' => 'privacy-policy',
                'meta_title' => 'Privacy Policy | OmniviaTech',
                'meta_description' => 'Read our privacy policy to understand how OmniviaTech collects, uses, and protects your personal data.',
                'meta_keywords' => 'privacy policy, data protection, GDPR',
                'canonical_url' => 'https://omniviatech.com/privacy-policy',
                'index' => true,
                'follow' => false,
            ],

            // Terms of Service
            [
                'page_name' => 'terms_of_service',
                'route_name' => 'terms-of-service',
                'meta_title' => 'Terms of Service | OmniviaTech',
                'meta_description' => 'Review the terms and conditions for using OmniviaTech services.',
                'meta_keywords' => 'terms, conditions, terms of service',
                'canonical_url' => 'https://omniviatech.com/terms-of-service',
                'index' => true,
                'follow' => false,
            ],
        ];

        foreach ($seoData as $data) {
            SeoData::updateOrCreate(
                ['page_name' => $data['page_name']],
                $data
            );
        }
    }
}
