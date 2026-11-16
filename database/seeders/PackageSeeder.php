<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Database\Seeder;

/**
 * OmniviaTech website packages.
 *
 * Ladder:  Basic (Launch) -> Advanced (Run) -> Pro (Scale) -> Full E-Commerce (Sell)
 *
 * Each tier lists its SIGNATURE value first in `features`, then the standard
 * deliverables carried over from the previous seeder. Safe to re-run:
 * packages are matched on slug, and their feature cards are rebuilt.
 */
class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // ------------------------------------------------------------------
        // 1. BASIC WEBSITE PACKAGE  ->  "Launch"
        // ------------------------------------------------------------------
        $basic = Package::updateOrCreate(['slug' => 'basic-website-package'], [
            'name' => 'Basic Website Package',
            'short_description' => 'Launch a professional, fast website that gets you found on Google and delivers every enquiry straight to your WhatsApp. Perfect for startups, SMEs, personal brands, and portfolios.',
            'description' => '<h2>Launch Professionally. Get Found. Get Enquiries.</h2>'
                . '<p>The Basic Website Package is your entry point into the digital world. It is built around one outcome: <strong>turning visitors into WhatsApp conversations and phone calls</strong>, with a professional site, Google visibility, and a monthly report that shows you exactly what your website is doing for you.</p>'
                . '<h3>Your Signature Advantages</h3><ul>'
                . '<li><strong>WhatsApp-First Lead Capture</strong> - Every enquiry lands in your WhatsApp with the page the visitor was viewing, so you reply faster and close more.</li>'
                . '<li><strong>Digital Business Card &amp; QR Code</strong> - A shareable mini-profile and printable QR for flyers, shopfronts, and vehicles.</li>'
                . '<li><strong>Monthly Website Report Card</strong> - Visitors, top pages, leads, and speed score delivered to your inbox every month.</li>'
                . '<li><strong>Google Business Profile Launch Pack</strong> - Category selection, 10 optimized photos, and your first 3 posts, so local customers find you.</li>'
                . '<li><strong>Page Speed Guarantee</strong> - Loads in under 3 seconds on a mobile connection, or we fix it free.</li>'
                . '</ul>'
                . '<h3>What Is Included</h3><ul>'
                . '<li><strong>Up to 10 Professional Pages</strong> - Home, About, Services, Blog, FAQs, Testimonials, Team, Contact, Privacy Policy, and one additional custom page</li>'
                . '<li><strong>Responsive Mobile-First Design</strong> - Works flawlessly on all devices</li>'
                . '<li><strong>SEO Foundations</strong> - Meta tags, schema markup, sitemaps, and indexing setup</li>'
                . '<li><strong>Google Integration</strong> - Search Console, Analytics, and Business Profile</li>'
                . '<li><strong>Security &amp; Performance</strong> - SSL (HTTPS), spam protection, and speed optimization</li>'
                . '<li><strong>Free .co.ke Domain, Hosting, Business Emails, and Monthly Maintenance</strong></li>'
                . '<li><strong>Training, Handover &amp; Growth Roadmap</strong> - Know how to run your site, and what to do in months 1, 3, 6 and 12</li>'
                . '</ul>'
                . '<h3>Your Growth Path</h3>'
                . '<p>Outgrowing Basic? <strong>Every shilling you invest here is credited toward Advanced</strong> when you upgrade within 12 months, so you never pay twice to grow.</p>'
                . '<h3>Perfect For</h3><p>Freelancers, consultants, small agencies, local businesses, service providers, and anyone ready to go digital.</p>',
            'tier_level' => 'Basic',
            'price_label' => 'Starting from',
            'image' => '/img/packages/basic-package.jpg',
            'highlight_text' => 'Launch: get found and get enquiries',
            'includes' => [
                'Up to 10 Professional Website Pages',
                'Home Page',
                'About Us',
                'Services Page',
                'Blog',
                'FAQs Page',
                'Testimonials',
                'Our Team',
                'Contact Us',
                'Privacy Policy',
                'Additional Standard Page',
                'Digital Business Card Page',
                'Printable QR Code for Your Business',
            ],
            'features' => [
                // Signature value
                'WhatsApp-First Lead Capture (Enquiries Delivered to Your WhatsApp)',
                'Click-to-Chat Button with Pre-Filled Page-Aware Message',
                'Monthly Website Report Card (Visitors, Leads & Speed)',
                'Google Business Profile Setup & Launch Pack (10 Photos + 3 Posts)',
                'Page Speed Guarantee: Under 3 Seconds or We Fix It Free',
                'Edit-It-Yourself Lite Editor (Text & Images)',
                'Growth Roadmap Handover (Months 1, 3, 6 & 12)',
                '100% Upgrade Credit Toward Advanced Within 12 Months',
                'Support Response Within 24 Hours',
                // Core deliverables
                'Professional Responsive Website Design',
                'Mobile-Friendly Layout',
                'Basic SEO Optimization',
                'Google Search Console Integration',
                'Google Analytics Integration',
                'Google Business Profile Setup & Integration',
                'Contact Form Integration',
                'Email Form Notifications',
                'Call-to-Action Sections',
                'WhatsApp Chat Integration',
                'Social Media Integration',
                'Structured Schema Markup',
                'Sitemap Submission',
                // Trust, security and speed
                'SSL Security Setup (HTTPS)',
                'Basic Security Protection',
                'Spam Protection',
                'Fast Loading Website Optimization',
                'Basic Performance Optimization',
                'Basic Image Optimization',
                'Cross-Browser Compatibility',
                'Cookie Consent Policy Banner',
                'GDPR Consent Integration',
                // Ownership and support
                'Website Training & Handover',
                'Standard Technical Support',
                'Free .co.ke Domain',
                'Web Hosting Included',
                'Monthly Website Maintenance',
                'Dedicated Business Emails',
            ],
            'is_featured' => false,
            'is_published' => true,
            'order' => 1,
        ]);

        // ------------------------------------------------------------------
        // 2. ADVANCED WEBSITE PACKAGE  ->  "Run"
        // ------------------------------------------------------------------
        $advanced = Package::updateOrCreate(['slug' => 'advanced-website-package'], [
            'name' => 'Advanced Website Package',
            'short_description' => 'Turn your website into a working part of your business: manage leads, take bookings with M-Pesa deposits, collect reviews automatically, and run everything from your own dashboard.',
            'description' => '<h2>Run Your Business From Your Website</h2>'
                . '<p>The Advanced Website Package is designed for growing businesses that are tired of juggling WhatsApp chats, notebooks, and missed follow-ups. Your website becomes a <strong>lead machine and booking desk</strong> that works around the clock, with a dashboard you control and a strategy partner who reviews your results with you.</p>'
                . '<h3>Your Signature Advantages</h3><ul>'
                . '<li><strong>Smart Lead Inbox</strong> - Forms, WhatsApp, and chat leads in one dashboard with statuses (New, Contacted, Won, Lost) and reminders when a lead goes untouched.</li>'
                . '<li><strong>Bookings with M-Pesa Deposits</strong> - Customers pay a small deposit via STK Push, which cuts no-shows and secures your revenue.</li>'
                . '<li><strong>Automated WhatsApp &amp; SMS Reminders</strong> - Booking confirmations, reminders, and follow-ups sent without lifting a finger.</li>'
                . '<li><strong>Review Growth Engine</strong> - Happy customers are guided to leave Google reviews, while unhappy feedback comes privately to you first.</li>'
                . '<li><strong>Instant Quote Builder</strong> - Visitors choose options and receive a PDF quote by email in seconds.</li>'
                . '<li><strong>Quarterly Strategy Call</strong> - A 30-minute review of your numbers with clear recommendations for the next quarter.</li>'
                . '</ul>'
                . '<h3>Everything in Basic, Plus</h3><ul>'
                . '<li><strong>Unlimited Website Pages</strong> - Custom dynamic pages built for your needs</li>'
                . '<li><strong>Admin &amp; User Dashboards</strong> - Manage content, pages, and settings without coding; let customers track bookings and reviews</li>'
                . '<li><strong>Multi-User Management</strong> - Role-based access for your team</li>'
                . '<li><strong>Full CMS</strong> - Blog, news, and content scheduling with AI-assisted drafting</li>'
                . '<li><strong>Advanced SEO &amp; Marketing</strong> - Meta Pixel, conversion tracking, email marketing, and CRM integration</li>'
                . '<li><strong>Live Chat &amp; Newsletter</strong> - Engage visitors in real time and grow your mailing list</li>'
                . '</ul>'
                . '<h3>Your Growth Path</h3>'
                . '<p>See your results in the analytics preview built with your own data. When you are ready for workflow automation, an AI assistant, and a client portal, <strong>Pro is one upgrade away</strong>.</p>'
                . '<h3>Ideal For</h3><p>Service providers, clinics, agencies, consultants, coaches, course creators, and businesses scaling operations.</p>',
            'tier_level' => 'Advanced',
            'price_label' => 'Starting from',
            'image' => '/img/packages/advanced-package.jpg',
            'highlight_text' => 'Run: best for growing businesses',
            'includes' => [
                'Everything in Basic Package',
                'Unlimited Website Pages',
                'Custom Dynamic Pages',
                'Blog & Content Sections',
                'Admin Dashboard',
                'User Dashboard',
                'Multi-User Management',
                'Role-Based Access Control',
                'Google OAuth / Social Login',
                'Customer Review Management System',
                'Blog & Content Management System (CMS)',
                'Quarterly Automated Performance Reports',
                'Newsletter Integration',
                'Advanced Contact & Lead Forms',
                'Appointment / Booking System',
                'Live Chat Integration',
            ],
            'features' => [
                // Signature value
                'Smart Lead Inbox with Status Tracking & Untouched-Lead Alerts',
                'Booking System with M-Pesa Deposit Payments (STK Push)',
                'Automated WhatsApp & SMS Booking Reminders and Follow-Ups',
                'Review Growth Engine (Google Review Requests + Private Feedback Routing)',
                'Instant Quote Builder with PDF Quote Delivery',
                'Content Scheduler with AI-Assisted Drafting & Social Auto-Sharing',
                'Quarterly 30-Minute Strategy Call',
                'Analytics Preview Dashboard Using Your Own Data',
                'Priority Support Response Within 8 Hours',
                'Industry Starter Kit (Clinic, School, Real Estate, Restaurant, Law Firm & More)',
                'Upgrade Credit Toward Pro Within 12 Months',
                // Growth and marketing
                'Conversion Tracking Setup',
                'Meta Pixel Integration',
                'Email Marketing Integration',
                'CRM Integration',
                'Advanced SEO Setup',
                'Structured Schema Markup',
                'Custom Notifications',
                'Multi-Language Support (Optional)',
                // Platform and data
                'Dynamic Website Content',
                'File Upload Functionality',
                'Database Backups',
                'Advanced Security Protection',
                'Advanced Speed Optimization',
                'Ongoing Technical Support',
                // Compliance and ownership
                'Cookie Consent Policy Banner',
                'GDPR Compliance Features',
                'Free .co.ke Domain',
                'Web Hosting Included',
                'Monthly Website Maintenance',
                'Dedicated Business Emails',
            ],
            'is_featured' => true,
            'is_published' => true,
            'order' => 2,
        ]);

        // ------------------------------------------------------------------
        // 3. PRO WEBSITE PACKAGE  ->  "Scale"
        // ------------------------------------------------------------------
        $pro = Package::updateOrCreate(['slug' => 'pro-website-package'], [
            'name' => 'Pro Website Package',
            'short_description' => 'Automate operations, serve customers 24/7 with an AI assistant, and see your whole business in one intelligence dashboard. Built for established brands, SaaS platforms, organizations, and agencies.',
            'description' => '<h2>Automate. Integrate. Scale.</h2>'
                . '<p>The Pro Website Package is our premium offering for organizations whose growth is limited by manual work. It replaces repetitive processes with <strong>automation, a client portal, an AI assistant, and a business intelligence dashboard</strong>, and it is backed by monitoring and a response-time commitment your leadership can rely on.</p>'
                . '<h3>Your Signature Advantages</h3><ul>'
                . '<li><strong>Workflow Automation Studio</strong> - Visual rules such as: when a lead is marked Won, create the invoice, send the onboarding email, and notify your team on WhatsApp or Slack.</li>'
                . '<li><strong>Client Portal</strong> - Orders, invoices, documents, e-signatures, and M-Pesa or card payments in one self-service space for your customers.</li>'
                . '<li><strong>AI Assistant Trained on Your Content</strong> - Answers visitor questions 24/7 in English and Swahili, qualifies leads, and hands over to your team with the full chat history.</li>'
                . '<li><strong>Business Intelligence Dashboard</strong> - Follow the funnel from visit to lead to sale, with revenue attribution by source.</li>'
                . '<li><strong>Uptime Monitoring &amp; Public Status Page</strong> - With a named incident response commitment.</li>'
                . '<li><strong>Staging Environment &amp; One-Click Rollback</strong> - Test changes safely before they go live.</li>'
                . '</ul>'
                . '<h3>Everything in Advanced, Plus</h3><ul>'
                . '<li><strong>Unlimited Custom Pages</strong> - Built to your exact specifications</li>'
                . '<li><strong>Admin, User &amp; Editor Dashboards</strong> - With workflow and multi-level approval systems</li>'
                . '<li><strong>Advanced CRM &amp; Lead Management</strong> - Track, nurture, and convert leads</li>'
                . '<li><strong>Membership &amp; Subscriptions</strong> - Recurring billing and member management</li>'
                . '<li><strong>Integration Pack</strong> - KRA eTIMS invoicing, QuickBooks or Zoho Books, Google Workspace, Microsoft 365, and custom APIs</li>'
                . '<li><strong>Multi-Branch &amp; Multi-Language Management</strong> - One system for every location</li>'
                . '<li><strong>Activity Logs &amp; Audit Trails</strong> - Complete visibility for compliance</li>'
                . '<li><strong>Cloud Infrastructure</strong> - CDN, auto-scaling, firewall, and enterprise security</li>'
                . '<li><strong>Annual Digital Health Audit</strong> - SEO, security, accessibility, and performance review with a written action plan</li>'
                . '</ul>'
                . '<h3>Your Growth Path</h3>'
                . '<p>Ready to sell products online? The <strong>Full E-Commerce Package</strong> adds a complete store, M-Pesa checkout, delivery tools, and a WhatsApp storefront on top of this foundation.</p>'
                . '<h3>For</h3><p>Enterprise organizations, SaaS companies, large agencies, institutions, and businesses requiring custom solutions.</p>',
            'tier_level' => 'Pro',
            'price_label' => 'Starting from',
            'image' => '/img/packages/pro-package.jpg',
            'highlight_text' => 'Scale: for enterprise leaders',
            'includes' => [
                'Everything in Advanced Package',
                'Unlimited Website Pages',
                'Enterprise-Level Custom Pages',
                'Advanced Dynamic Content Modules',
                'Admin, User & Editor Dashboards',
                'Advanced Multi-User Permissions',
                'Workflow & Approval Systems',
                'Advanced Review & Reputation Management',
                'Quarterly Automated Business Intelligence Reports',
                'Custom API Integrations',
                'Third-Party Software Integrations',
                'AI-Powered Features & Automations',
                'Client Portal with Invoices, Documents & E-Signatures',
            ],
            'features' => [
                // Signature value
                'Workflow Automation Studio (Visual Rules & Triggers)',
                'AI Assistant Trained on Your Content (English & Swahili)',
                'Business Intelligence Dashboard with Revenue Attribution by Source',
                'Client Portal with M-Pesa & Card Payments',
                'Uptime Monitoring with Public Status Page',
                'Staging Environment & One-Click Rollback',
                'Integration Pack (KRA eTIMS, QuickBooks / Zoho Books, Google Workspace, Microsoft 365)',
                'Multi-Branch & Multi-Language Management',
                'Annual Digital Health Audit with Written Action Plan',
                'Offline-Capable Progressive Web App (PWA)',
                'Priority Support with 2-Hour Response Commitment',
                'Upgrade Credit Toward Full E-Commerce Within 12 Months',
                // Business systems
                'Advanced CRM & Lead Management',
                'Customer Portal',
                'Membership / Subscription Features',
                'Analytics & Reporting Dashboard',
                'Internal Messaging System',
                'Team Collaboration Tools',
                'Custom Email Templates',
                'Push Notifications',
                'Progressive Web App (PWA) Features',
                // Governance, data and infrastructure
                'Activity Logs & Audit Trails',
                'Advanced Database Management',
                'Cloud Deployment & Infrastructure Setup',
                'CDN & Performance Scaling',
                'Priority Security Monitoring',
                'Firewall & Malware Protection',
                'Automated Backups & Recovery',
                'Advanced Technical SEO',
                'Enterprise-Level Optimization',
                // Support, compliance and ownership
                'Ongoing Maintenance & Support',
                'Priority Technical Assistance',
                'Cookie Consent Policy Banner',
                'GDPR Compliance Features',
                'Free .com Domain',
                'Web Hosting Included',
                'Monthly Website Maintenance',
                'Dedicated Business Emails',
            ],
            'is_featured' => false,
            'is_published' => true,
            'order' => 3,
        ]);

        // ------------------------------------------------------------------
        // 4. FULL E-COMMERCE PACKAGE  ->  "Sell"
        // ------------------------------------------------------------------
        $ecommerce = Package::updateOrCreate(['slug' => 'full-ecommerce-package'], [
            'name' => 'Full E-Commerce Package',
            'short_description' => 'A complete online store built for Kenya: M-Pesa checkout, WhatsApp storefront, smart delivery, inventory intelligence, and win-back automation to launch and scale your e-commerce business.',
            'description' => '<h2>A Store That Sells While You Sleep</h2>'
                . '<p>The Full E-Commerce Package is the most comprehensive solution for businesses ready to sell online. It goes beyond a catalog and a cart: it gives you <strong>M-Pesa-native checkout, selling through WhatsApp, delivery management, and automation that brings customers back</strong>, so you grow revenue and profit, not just traffic.</p>'
                . '<h3>Your Signature Advantages</h3><ul>'
                . '<li><strong>M-Pesa-Native Checkout</strong> - STK Push, Paybill, and Till support with automatic reconciliation and retry when a prompt times out.</li>'
                . '<li><strong>WhatsApp Storefront</strong> - Customers browse and order inside WhatsApp, with order updates and abandoned-cart nudges sent there too.</li>'
                . '<li><strong>Smart Delivery Engine</strong> - Courier and rider integrations, zone-based delivery pricing, live order tracking, and proof-of-delivery photos.</li>'
                . '<li><strong>Pay on Delivery with Fraud Scoring</strong> - Protect yourself from fake orders while keeping cash-on-delivery customers.</li>'
                . '<li><strong>Pay-Later Installments</strong> - Let customers split purchases into instalments via M-Pesa.</li>'
                . '<li><strong>Profit Dashboard</strong> - Margins per product after fees, shipping, and discounts, not just sales totals.</li>'
                . '</ul>'
                . '<h3>Complete Store Features</h3><ul>'
                . '<li><strong>Full E-Commerce Storefront</strong> - Professional, conversion-optimized store design</li>'
                . '<li><strong>Product Catalog</strong> - Unlimited products with variants, attributes, and categories</li>'
                . '<li><strong>Inventory Management</strong> - Real-time stock tracking, low-stock alerts, and forecasting</li>'
                . '<li><strong>Shopping Cart &amp; Checkout</strong> - Optimized for conversions with guest checkout</li>'
                . '<li><strong>Payment Gateways</strong> - M-Pesa, Stripe, PayPal, and card payments</li>'
                . '<li><strong>Order Management</strong> - Dashboard for tracking, fulfillment, and shipping</li>'
                . '<li><strong>Automated Invoicing</strong> - Generate and email invoices automatically</li>'
                . '</ul>'
                . '<h3>Marketing &amp; Growth Tools</h3><ul>'
                . '<li><strong>Win-Back Automation</strong> - Customers who have not ordered in 45 days receive a personal offer on WhatsApp or SMS</li>'
                . '<li><strong>Abandoned Cart Recovery</strong> - Automated recovery campaigns</li>'
                . '<li><strong>Social Commerce Sync</strong> - Facebook, Instagram, and TikTok shops plus a Google Merchant feed</li>'
                . '<li><strong>Email Campaigns</strong> - Newsletter and promotional automation</li>'
                . '<li><strong>Reviews &amp; Ratings, Loyalty, Affiliates, and Wishlist</strong> - Build trust and repeat sales</li>'
                . '</ul>'
                . '<h3>Launch Support</h3>'
                . '<p>Product photography guide, your first 50 products uploaded for you, and a launch campaign plan, so you open for business with momentum.</p>'
                . '<h3>For</h3><p>Retailers, wholesalers, digital product sellers, subscription services, and businesses ready to build their online empire.</p>',
            'tier_level' => 'Enterprise',
            'price_label' => 'Starting from',
            'image' => '/img/packages/ecommerce-package.jpg',
            'highlight_text' => 'Sell: complete e-commerce solution',
            'includes' => [
                'Unlimited Website Pages',
                'Full E-Commerce Storefront',
                'Product Catalog Pages',
                'Product Landing Pages',
                'Dynamic Product Filtering Pages',
                'Full Online Store Setup',
                'Product Management System',
                'Inventory Management',
                'Shopping Cart & Checkout System',
                'Secure Payment Gateway Integration',
                'M-Pesa Integration',
                'Card Payments Integration',
                'Coupon & Discount System',
                'Launch Support: First 50 Products Uploaded for You',
            ],
            'features' => [
                // Signature value
                'M-Pesa-Native Checkout (STK Push, Paybill & Till with Auto-Reconciliation)',
                'WhatsApp Storefront with Order Updates & Cart Nudges',
                'Smart Delivery Engine (Zones, Courier Integration, Live Tracking, Proof of Delivery)',
                'Pay on Delivery with Fraud Scoring',
                'Pay-Later Installment Plans via M-Pesa',
                'Inventory Intelligence (Low-Stock Forecasting & Dead-Stock Reports)',
                'Profit Dashboard (Margins After Fees, Shipping & Discounts)',
                'Win-Back Automation via WhatsApp & SMS',
                'Seller Mobile App (PWA) with New-Order Push Notifications',
                'Social Commerce Sync (Facebook, Instagram, TikTok & Google Merchant)',
                'Launch Support: Photography Guide, Product Upload & Campaign Plan',
                'Priority Support with 1-Hour Response Commitment',
                // Store operations
                'Order Management Dashboard',
                'Shipping & Delivery Integration',
                'Automated Invoice Generation',
                'Customer Accounts & Order Tracking',
                'Product Variations & Attributes',
                'Advanced Search & Filtering',
                'Product Import & Export Tools',
                'Tax & VAT Configuration',
                'Multi-Currency Support',
                'Subscription Billing',
                'Multi-Vendor Capability (Optional)',
                // Growth and marketing
                'Abandoned Cart Recovery',
                'Product Reviews & Ratings',
                'Wishlist Functionality',
                'Loyalty & Rewards System',
                'Affiliate / Referral System',
                'Automated Email Notifications',
                'Marketing Automation Integration',
                'Facebook & Instagram Shop Integration',
                'E-Commerce SEO Optimization',
                'Sales Analytics Dashboard',
                // Platform and protection
                'Mobile Commerce Optimization',
                'Fraud Protection',
                'Performance Monitoring',
                'API Integrations for ERP/CRM',
                'Scalable Cloud Hosting Support',
                // Compliance and ownership
                'Cookie Consent Policy Banner',
                'GDPR Compliance Features',
                'Free .com Domain',
                'Web Hosting Included',
                'Monthly Website Maintenance',
                'Dedicated Business Emails',
            ],
            'is_featured' => false,
            'is_published' => true,
            'order' => 4,
        ]);

        // ------------------------------------------------------------------
        // Feature cards (rebuilt on every run so the seeder stays idempotent)
        // ------------------------------------------------------------------
        $features = [
            $basic->id => [
                ['title' => 'WhatsApp-First Leads', 'description' => 'Every enquiry delivered straight to your WhatsApp', 'icon' => '💬', 'order' => 1],
                ['title' => 'Professional Design', 'description' => 'Modern, responsive design that works on all devices', 'icon' => '🎨', 'order' => 2],
                ['title' => 'Get Found on Google', 'description' => 'SEO foundations plus a Google Business Profile launch pack', 'icon' => '📈', 'order' => 3],
                ['title' => 'Monthly Report Card', 'description' => 'See visitors, leads, and speed every month', 'icon' => '📋', 'order' => 4],
                ['title' => 'Security Included', 'description' => 'SSL certificate and security protection', 'icon' => '🔒', 'order' => 5],
                ['title' => 'Free Domain', 'description' => 'Free .co.ke domain for your website', 'icon' => '🌐', 'order' => 6],
            ],
            $advanced->id => [
                ['title' => 'Smart Lead Inbox', 'description' => 'Track every lead from first contact to closed deal', 'icon' => '📥', 'order' => 1],
                ['title' => 'Bookings + M-Pesa Deposits', 'description' => 'Secure appointments and cut no-shows', 'icon' => '📅', 'order' => 2],
                ['title' => 'Automated Reminders', 'description' => 'WhatsApp and SMS confirmations and follow-ups', 'icon' => '⏰', 'order' => 3],
                ['title' => 'Review Growth Engine', 'description' => 'Collect Google reviews and catch complaints privately', 'icon' => '⭐', 'order' => 4],
                ['title' => 'CMS & Blog', 'description' => 'Full content management with scheduling and AI drafting', 'icon' => '📝', 'order' => 5],
                ['title' => 'Quarterly Strategy Call', 'description' => 'Review results and plan your next quarter with us', 'icon' => '🧭', 'order' => 6],
            ],
            $pro->id => [
                ['title' => 'Workflow Automation', 'description' => 'Visual rules that replace repetitive manual work', 'icon' => '⚙️', 'order' => 1],
                ['title' => 'AI Assistant', 'description' => 'Answers visitors 24/7 in English and Swahili and qualifies leads', 'icon' => '🤖', 'order' => 2],
                ['title' => 'Client Portal', 'description' => 'Invoices, documents, e-signatures, and payments in one place', 'icon' => '🗂️', 'order' => 3],
                ['title' => 'Business Intelligence', 'description' => 'Funnel and revenue attribution by source', 'icon' => '📊', 'order' => 4],
                ['title' => 'Integrations & APIs', 'description' => 'KRA eTIMS, accounting, Google Workspace, and custom APIs', 'icon' => '🔌', 'order' => 5],
                ['title' => 'Monitoring & Rollback', 'description' => 'Uptime monitoring, status page, and one-click rollback', 'icon' => '🛡️', 'order' => 6],
            ],
            $ecommerce->id => [
                ['title' => 'M-Pesa-Native Checkout', 'description' => 'STK Push, Paybill, and Till with auto-reconciliation', 'icon' => '💳', 'order' => 1],
                ['title' => 'WhatsApp Storefront', 'description' => 'Sell and send order updates inside WhatsApp', 'icon' => '🛍️', 'order' => 2],
                ['title' => 'Smart Delivery', 'description' => 'Zones, couriers, live tracking, and proof of delivery', 'icon' => '🚚', 'order' => 3],
                ['title' => 'Inventory Intelligence', 'description' => 'Forecast stock needs and spot dead stock', 'icon' => '📦', 'order' => 4],
                ['title' => 'Profit Dashboard', 'description' => 'Know your real margin per product', 'icon' => '💰', 'order' => 5],
                ['title' => 'Win-Back Automation', 'description' => 'Bring lapsed customers back with personal offers', 'icon' => '🔁', 'order' => 6],
            ],
        ];

        foreach ($features as $packageId => $packageFeatures) {
            PackageFeature::where('package_id', $packageId)->delete();

            foreach ($packageFeatures as $feature) {
                PackageFeature::create(array_merge(['package_id' => $packageId], $feature));
            }
        }
    }
}