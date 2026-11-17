<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Seeds the OmniviaTech product line.
 *
 * Safe to re-run: products that are not in this list are soft-deleted (recoverable),
 * their bundle links and wishlist entries are removed, and the listed products are
 * created or updated by slug.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = $this->products();
        $slugs = array_column($products, 'slug');

        // ── Retire products that are no longer offered ──
        $retiredIds = Product::whereNotIn('slug', $slugs)->pluck('id');
        if ($retiredIds->isNotEmpty()) {
            BundleItem::where('bundleable_type', Product::class)->whereIn('bundleable_id', $retiredIds)->delete();
            DB::table('wishlists')->where('wishlistable_type', Product::class)->whereIn('wishlistable_id', $retiredIds)->delete();
            Product::whereIn('id', $retiredIds)->delete(); // soft delete
        }

        // ── Create / update current products ──
        foreach ($products as $i => $data) {
            $product = Product::withTrashed()->firstOrNew(['slug' => $data['slug']]);
            $product->fill($data + ['is_featured' => true, 'is_published' => true, 'order' => $i + 1]);
            $product->save();
            if ($product->trashed()) {
                $product->restore();
            }
        }

        $this->relinkBundles();

        Cache::forget('homepage_data');
    }

    /**
     * Point the seeded bundles at current products instead of retired ones, and refresh
     * their copy (it named the retired products). Bundles that don't exist yet — e.g. on a
     * fresh `migrate --seed`, where DatabaseSeeder creates them afterwards — are skipped.
     */
    private function relinkBundles(): void
    {
        $links = [
            'digital-starter-pack' => [
                'products' => ['tillpilot', 'chatshop'],
                'copy'     => [
                    'short_description' => 'Everything you need to start selling online — website, M-Pesa invoicing and WhatsApp commerce bundled at a special rate.',
                    'description'       => '<p>Get online fast with our curated starter bundle. Includes a custom-built website, TillPilot for M-Pesa invoicing and reconciliation, and ChatShop for selling on WhatsApp. Contact us for pricing and a personalized quote.</p>',
                    'whats_included'    => ['Custom Website', 'TillPilot (6 months)', 'ChatShop (6 months)', 'SEO Setup', '3 Months Support'],
                ],
            ],
            'enterprise-growth-suite' => [
                'products' => ['stocksync', 'dukaboard', 'etims-bridge'],
                'copy'     => [
                    'short_description' => 'Complete retail operations suite — multi-branch POS, owner dashboards, KRA eTIMS compliance and ongoing consulting.',
                    'whats_included'    => ['StockSync Multi-Branch POS', 'DukaBoard Owner Dashboards', 'eTIMS Bridge', 'Business Consulting (40 hrs)', 'Data Migration', '12 Months Priority Support'],
                ],
            ],
        ];

        foreach ($links as $bundleSlug => $config) {
            $bundle = Bundle::where('slug', $bundleSlug)->first();
            if (! $bundle) {
                continue;
            }
            $bundle->update($config['copy']);
            $productSlugs = $config['products'];
            foreach (Product::whereIn('slug', $productSlugs)->get() as $product) {
                BundleItem::firstOrCreate([
                    'bundle_id'       => $bundle->id,
                    'bundleable_type' => Product::class,
                    'bundleable_id'   => $product->id,
                ], ['quantity' => 1]);
            }
        }
    }

    private function products(): array
    {
        return [
            [
                'name'              => 'TillPilot',
                'slug'              => 'tillpilot',
                'category'          => 'Payments & Finance',
                'short_description' => 'M-Pesa reconciliation, invoicing and payment links in one place — know exactly who paid, for what, and when.',
                'description'       => '<h2>Stop matching M-Pesa messages by hand</h2>'
                    . '<p>TillPilot connects to your Till, Paybill or bank account and automatically matches every incoming payment to the right customer and invoice. No more scrolling through SMS confirmations or exporting statements at month-end.</p>'
                    . '<h3>Invoice, collect, reconcile</h3>'
                    . '<p>Create branded invoices, send them by SMS, WhatsApp or email with a one-tap payment link, and watch them mark themselves as paid the moment the customer pays. Partial payments, overpayments and unmatched transactions are flagged for quick review.</p>'
                    . '<p>Your accountant gets clean, export-ready records — and you get a real-time view of what is owed and what has come in.</p>',
                'features'          => [
                    'Automatic M-Pesa Till & Paybill reconciliation',
                    'Branded invoices and quotations',
                    'One-tap payment links via SMS, WhatsApp & email',
                    'Partial and overpayment handling',
                    'Automated payment reminders',
                    'Customer statements and ageing reports',
                    'Export to Excel, QuickBooks & Xero',
                    'Multi-user access with roles',
                ],
                'specifications'    => [
                    'Payment channels' => 'M-Pesa Till, Paybill, bank transfer, card',
                    'Integration'      => 'Safaricom Daraja API',
                    'Platform'         => 'Web + mobile-friendly',
                    'Exports'          => 'Excel, CSV, QuickBooks, Xero',
                    'Hosting'          => 'Secure cloud, daily backups',
                    'Support'          => 'Email, phone & WhatsApp',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Starter',  'price' => 2500,  'period' => 'month', 'features' => ['1 Till / Paybill', 'Up to 300 transactions/month', '1 user']],
                    ['name' => 'Business', 'price' => 6500,  'period' => 'month', 'features' => ['3 Tills / Paybills', 'Up to 3,000 transactions/month', '5 users', 'Accounting exports']],
                    ['name' => 'Pro',      'price' => 14500, 'period' => 'month', 'features' => ['Unlimited channels', 'Unlimited transactions', 'Unlimited users', 'Priority support']],
                ],
            ],
            [
                'name'              => 'CoverDesk',
                'slug'              => 'coverdesk',
                'category'          => 'Insurance',
                'short_description' => 'The CRM built for insurance agencies and brokers — policies, renewals, commissions and claims in one workspace.',
                'description'       => '<h2>Never miss a renewal again</h2>'
                    . '<p>CoverDesk keeps every client, policy and underwriter in one organised workspace. Renewal reminders go out automatically to both your team and your clients, so premiums keep coming in and policies never lapse by accident.</p>'
                    . '<h3>Built around how agencies actually work</h3>'
                    . '<p>Track quotes from multiple insurers side by side, log claims and follow them to settlement, and calculate commissions per underwriter, product and agent. Managers see the whole pipeline at a glance; agents see exactly what needs their attention today.</p>',
                'features'          => [
                    'Client and policy register',
                    'Automated renewal reminders by SMS & email',
                    'Multi-insurer quote comparison',
                    'Claims tracking from notification to settlement',
                    'Commission calculation per agent & underwriter',
                    'Document storage for KYC and policy schedules',
                    'Sales pipeline and lead tracking',
                    'Premium collection via M-Pesa',
                ],
                'specifications'    => [
                    'Users'        => 'Agencies, brokers & bancassurance teams',
                    'Platform'     => 'Web + mobile-friendly',
                    'Notifications'=> 'SMS, email & WhatsApp',
                    'Data'         => 'Encrypted at rest and in transit',
                    'Reports'      => 'Renewals, production, commissions, claims',
                    'Support'      => 'Onboarding & data migration included',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Agent',   'price' => 3500,  'period' => 'month', 'features' => ['1 user', 'Up to 500 policies', 'Renewal reminders']],
                    ['name' => 'Agency',  'price' => 9500,  'period' => 'month', 'features' => ['Up to 10 users', 'Unlimited policies', 'Commissions & claims']],
                    ['name' => 'Broker',  'price' => 22000, 'period' => 'month', 'features' => ['Unlimited users', 'Multi-branch', 'Custom reports', 'Priority support']],
                ],
            ],
            [
                'name'              => 'ClinicNest',
                'slug'              => 'clinicnest',
                'category'          => 'Healthcare',
                'short_description' => 'Clinic and pharmacy management — patient records, appointments, billing, dispensing and stock in one system.',
                'description'       => '<h2>Run your clinic, not your paperwork</h2>'
                    . '<p>ClinicNest takes patients from reception to consultation, lab, pharmacy and payment without a single paper file. Every visit, diagnosis, prescription and payment is captured in the patient\'s record and available to the right staff instantly.</p>'
                    . '<h3>A pharmacy that keeps its own stock</h3>'
                    . '<p>Dispensing automatically updates stock, flags items close to expiry and warns you before you run out. Bill patients directly, through insurance schemes or via M-Pesa, and close the day with an accurate cash-up report.</p>',
                'features'          => [
                    'Electronic patient records',
                    'Appointment booking & SMS reminders',
                    'Consultation, lab and pharmacy workflow',
                    'Pharmacy dispensing with batch & expiry tracking',
                    'Low-stock and expiry alerts',
                    'Cash, insurance and M-Pesa billing',
                    'Daily cash-up and revenue reports',
                    'Role-based access for doctors, nurses & pharmacists',
                ],
                'specifications'    => [
                    'Suitable for' => 'Clinics, medical centres & pharmacies',
                    'Platform'     => 'Web, works on tablets',
                    'Billing'      => 'Cash, insurance, M-Pesa',
                    'Security'     => 'Role-based access, audit trail',
                    'Backups'      => 'Automatic daily backups',
                    'Support'      => 'On-site training available',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Pharmacy', 'price' => 4500,  'period' => 'month', 'features' => ['Dispensing & stock', 'Up to 3 users', 'M-Pesa billing']],
                    ['name' => 'Clinic',   'price' => 9500,  'period' => 'month', 'features' => ['Patient records & appointments', 'Pharmacy & lab', 'Up to 10 users']],
                    ['name' => 'Medical Centre', 'price' => 19500, 'period' => 'month', 'features' => ['Multi-department', 'Insurance billing', 'Unlimited users']],
                ],
            ],
            [
                'name'              => 'ChamaCore',
                'slug'              => 'chamacore',
                'category'          => 'SACCO & Chama',
                'short_description' => 'SACCO and chama management — contributions, loans, dividends and member statements, fully transparent.',
                'description'       => '<h2>Transparent records every member can trust</h2>'
                    . '<p>ChamaCore replaces the notebook and the spreadsheet with a single source of truth for your group. Contributions paid via M-Pesa are recorded automatically against each member, and everyone can check their own balance at any time.</p>'
                    . '<h3>Loans, fines and dividends — handled</h3>'
                    . '<p>Set your group\'s rules once: contribution amounts, loan limits, interest rates, guarantors and fines. ChamaCore applies them consistently, calculates repayments and dividends, and produces statements and meeting reports in seconds.</p>',
                'features'          => [
                    'Automatic M-Pesa contribution recording',
                    'Member self-service balances & statements',
                    'Loan applications, guarantors & approvals',
                    'Interest, repayment and penalty calculations',
                    'Dividend and share-out computation',
                    'Fines and welfare fund tracking',
                    'SMS notices for meetings and arrears',
                    'Audit-ready financial reports',
                ],
                'specifications'    => [
                    'Suitable for' => 'Chamas, investment groups & SACCOs',
                    'Payments'     => 'M-Pesa Paybill integration',
                    'Access'       => 'Officials portal + member app',
                    'Notifications'=> 'SMS & email',
                    'Reports'      => 'Statements, loan book, trial balance',
                    'Support'      => 'Setup & member onboarding',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Chama',  'price' => 1500,  'period' => 'month', 'features' => ['Up to 50 members', 'Contributions & loans', 'Member statements']],
                    ['name' => 'Group',  'price' => 4000,  'period' => 'month', 'features' => ['Up to 300 members', 'Dividends & fines', 'SMS notices']],
                    ['name' => 'SACCO',  'price' => 12000, 'period' => 'month', 'features' => ['Unlimited members', 'Multi-product loans', 'Audit reports', 'Priority support']],
                ],
            ],
            [
                'name'              => 'ChatShop',
                'slug'              => 'chatshop',
                'category'          => 'E-Commerce',
                'short_description' => 'Sell on WhatsApp like a real store — catalogue, cart, M-Pesa checkout and order tracking inside the chat.',
                'description'       => '<h2>Your customers are already on WhatsApp</h2>'
                    . '<p>ChatShop turns your WhatsApp Business number into a complete storefront. Customers browse your catalogue, add items to a cart and pay with M-Pesa without ever leaving the conversation.</p>'
                    . '<h3>Less back-and-forth, more sales</h3>'
                    . '<p>Automated replies answer prices, availability and delivery questions instantly. Every order lands in one dashboard where your team can confirm, dispatch and update the customer — so no order gets lost in a busy chat.</p>',
                'features'          => [
                    'Product catalogue inside WhatsApp',
                    'Cart and M-Pesa STK checkout',
                    'Automated replies for prices & availability',
                    'Order dashboard for your whole team',
                    'Delivery status updates to customers',
                    'Broadcasts for promotions & restocks',
                    'Customer list and repeat-buyer insights',
                    'Shared inbox for multiple agents',
                ],
                'specifications'    => [
                    'Channel'   => 'WhatsApp Business Platform',
                    'Payments'  => 'M-Pesa STK Push, card',
                    'Dashboard' => 'Web + mobile-friendly',
                    'Agents'    => 'Multi-agent shared inbox',
                    'Reports'   => 'Sales, orders & top products',
                    'Support'   => 'Catalogue setup included',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Starter', 'price' => 3000,  'period' => 'month', 'features' => ['Up to 100 products', '1 agent', 'M-Pesa checkout']],
                    ['name' => 'Growth',  'price' => 7500,  'period' => 'month', 'features' => ['Unlimited products', '5 agents', 'Broadcasts']],
                    ['name' => 'Scale',   'price' => 16000, 'period' => 'month', 'features' => ['Unlimited agents', 'Multiple numbers', 'Priority support']],
                ],
            ],
            [
                'name'              => 'eTIMS Bridge',
                'slug'              => 'etims-bridge',
                'category'          => 'Tax Compliance',
                'short_description' => 'KRA eTIMS and VAT invoicing middleware — submits compliant invoices automatically from the tools you already use.',
                'description'       => '<h2>eTIMS compliance without changing how you sell</h2>'
                    . '<p>eTIMS Bridge sits between your existing POS, spreadsheet or accounting software and KRA\'s eTIMS. Every sale you record is converted into a compliant electronic tax invoice and submitted automatically — no retyping, and no new system for your team to learn.</p>'
                    . '<h3>Always ready for KRA</h3>'
                    . '<p>Each invoice is validated before it is sent, failed submissions are retried and flagged, and you keep a complete, searchable record of every invoice and its KRA response. VAT summaries are ready when it is time to file.</p>',
                'features'          => [
                    'Automatic invoice submission to KRA eTIMS',
                    'Connects to existing POS, spreadsheets & accounting tools',
                    'Excel / CSV upload for businesses without a POS',
                    'Validation before submission',
                    'Automatic retries and failure alerts',
                    'Searchable invoice & KRA response archive',
                    'VAT summaries for monthly filing',
                    'Credit notes and invoice cancellations',
                ],
                'specifications'    => [
                    'Connects to'  => 'POS systems, QuickBooks, Xero, Excel/CSV',
                    'Submission'   => 'Real-time or scheduled batches',
                    'Platform'     => 'Cloud middleware + web dashboard',
                    'Audit trail'  => 'Full invoice and response history',
                    'Setup'        => 'Guided onboarding & integration',
                    'Support'      => 'Email, phone & WhatsApp',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Small Business', 'price' => 2000,  'period' => 'month', 'features' => ['Up to 500 invoices/month', 'Excel/CSV upload', '1 business PIN']],
                    ['name' => 'Business',       'price' => 5500,  'period' => 'month', 'features' => ['Up to 5,000 invoices/month', 'POS & accounting integration', 'VAT summaries']],
                    ['name' => 'Enterprise',     'price' => 15000, 'period' => 'month', 'features' => ['Unlimited invoices', 'Multiple PINs & branches', 'Priority support']],
                ],
            ],
            [
                'name'              => 'FleetLedger',
                'slug'              => 'fleetledger',
                'category'          => 'Logistics',
                'short_description' => 'Fleet and logistics tracking for small transporters — trips, fuel, driver expenses and maintenance in one ledger.',
                'description'       => '<h2>Know what every vehicle really earns</h2>'
                    . '<p>FleetLedger gives small transporters a clear picture of each truck, van or matatu. Drivers log trips, fuel and expenses from their phones, and you see revenue, costs and profit per vehicle and per trip — without chasing receipts.</p>'
                    . '<h3>Keep vehicles on the road</h3>'
                    . '<p>Service schedules, insurance and inspection dates are tracked automatically, with reminders before anything falls due. Unusual fuel use and expense claims are flagged so you can act early.</p>',
                'features'          => [
                    'Trip logs with origin, destination & revenue',
                    'Fuel tracking and consumption alerts',
                    'Driver expense claims with receipt photos',
                    'Maintenance schedules & service reminders',
                    'Insurance and inspection expiry alerts',
                    'Profit and cost per vehicle and per trip',
                    'Driver app for logging on the go',
                    'Monthly fleet performance reports',
                ],
                'specifications'    => [
                    'Suitable for' => 'Trucks, vans, matatus & delivery fleets',
                    'Driver app'   => 'Android, works with weak signal',
                    'Dashboard'    => 'Web + mobile-friendly',
                    'Alerts'       => 'SMS & email',
                    'Reports'      => 'Vehicle P&L, fuel, maintenance',
                    'Support'      => 'Fleet setup included',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Starter', 'price' => 2500,  'period' => 'month', 'features' => ['Up to 3 vehicles', 'Trips, fuel & expenses']],
                    ['name' => 'Fleet',   'price' => 6500,  'period' => 'month', 'features' => ['Up to 15 vehicles', 'Maintenance & expiry alerts', 'Driver app']],
                    ['name' => 'Pro',     'price' => 14000, 'period' => 'month', 'features' => ['Unlimited vehicles', 'Custom reports', 'Priority support']],
                ],
            ],
            [
                'name'              => 'StockSync',
                'slug'              => 'stocksync',
                'category'          => 'Retail & POS',
                'short_description' => 'Multi-branch inventory and POS that keeps selling offline and syncs automatically when the connection returns.',
                'description'       => '<h2>Keep selling when the internet doesn\'t</h2>'
                    . '<p>StockSync is a point-of-sale and inventory system designed for real connectivity conditions. Every till keeps working offline and syncs sales and stock to the cloud automatically once the connection is back — no lost sales, no double counting.</p>'
                    . '<h3>Every branch, one stock picture</h3>'
                    . '<p>See stock levels across all your shops and stores in one place, move stock between branches, and get reorder alerts before you run out. Accept cash, card and M-Pesa at the till and close each day with an accurate cash-up.</p>',
                'features'          => [
                    'Offline-first POS with automatic sync',
                    'Multi-branch and multi-store inventory',
                    'Stock transfers between branches',
                    'Barcode scanning and receipt printing',
                    'Cash, card and M-Pesa payments',
                    'Reorder alerts and purchase orders',
                    'Shift cash-up and till reports',
                    'eTIMS-ready sales records',
                ],
                'specifications'    => [
                    'Offline mode' => 'Full selling offline, auto-sync on reconnect',
                    'Hardware'     => 'Works with common printers & scanners',
                    'Platform'     => 'Windows, Android & web',
                    'Payments'     => 'Cash, card, M-Pesa',
                    'Branches'     => 'Unlimited on Pro',
                    'Support'      => 'Installation & staff training',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Single Shop',  'price' => 3000,  'period' => 'month', 'features' => ['1 branch', '2 tills', 'Inventory & POS']],
                    ['name' => 'Multi-Branch', 'price' => 8500,  'period' => 'month', 'features' => ['Up to 5 branches', 'Stock transfers', 'Purchase orders']],
                    ['name' => 'Pro',          'price' => 18000, 'period' => 'month', 'features' => ['Unlimited branches', 'Unlimited tills', 'Priority support']],
                ],
            ],
            [
                'name'              => 'DukaBoard',
                'slug'              => 'dukaboard',
                'category'          => 'Business Intelligence',
                'short_description' => 'Owner dashboards that show sales, stock and cashflow in one place — on your phone, in real time.',
                'description'       => '<h2>Your whole business on one screen</h2>'
                    . '<p>DukaBoard pulls together your sales, stock and money movement from your POS, M-Pesa and bank, and shows them on simple dashboards built for owners — not accountants. Check today\'s takings, best-sellers and cash position from anywhere.</p>'
                    . '<h3>Spot problems before they cost you</h3>'
                    . '<p>Daily summaries arrive by SMS or WhatsApp, and alerts flag unusual drops in sales, slow-moving stock and cashflow gaps early — so decisions are based on numbers, not guesses.</p>',
                'features'          => [
                    'Real-time sales, stock & cashflow dashboards',
                    'Connects to POS, M-Pesa and bank data',
                    'Daily summaries by SMS or WhatsApp',
                    'Best-sellers and slow-moving stock',
                    'Branch and staff performance comparison',
                    'Cashflow forecasting',
                    'Alerts for unusual sales drops',
                    'Mobile-first design for owners on the go',
                ],
                'specifications'    => [
                    'Data sources' => 'POS, M-Pesa, bank, Excel',
                    'Platform'     => 'Mobile-first web app',
                    'Updates'      => 'Real-time & daily summaries',
                    'Delivery'     => 'Dashboard, SMS & WhatsApp',
                    'Branches'     => 'Multi-branch comparison',
                    'Support'      => 'Data connection setup included',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Owner',    'price' => 2000,  'period' => 'month', 'features' => ['1 business', 'Core dashboards', 'Daily SMS summary']],
                    ['name' => 'Business', 'price' => 5000,  'period' => 'month', 'features' => ['Up to 5 branches', 'Alerts & forecasting', 'WhatsApp summaries']],
                    ['name' => 'Group',    'price' => 12000, 'period' => 'month', 'features' => ['Unlimited branches', 'Custom dashboards', 'Priority support']],
                ],
            ],
            [
                'name'              => 'SchoolPesa',
                'slug'              => 'schoolpesa',
                'category'          => 'Education',
                'short_description' => 'School management and fee collection — M-Pesa fee tracking, SMS balance reminders, report cards and timetables.',
                'description'       => '<h2>Fees collected, recorded and reconciled — automatically</h2>'
                    . '<p>SchoolPesa gives every student a fee account that updates the moment a parent pays through M-Pesa. The bursar sees who has paid and who has not in real time, and parents receive their balance by SMS without anyone picking up the phone.</p>'
                    . '<h3>The whole school in one system</h3>'
                    . '<p>Beyond fees, SchoolPesa handles admissions, class lists, exam marks, report cards and timetables — so teachers spend less time on paperwork and parents stay informed all term.</p>',
                'features'          => [
                    'Automatic M-Pesa fee recording per student',
                    'Fee structures, invoices and receipts',
                    'SMS balance reminders to parents',
                    'Admissions and student records',
                    'Exam marks entry and report cards',
                    'Timetable generation',
                    'Bulk SMS for school notices',
                    'Bursar, headteacher & teacher roles',
                ],
                'specifications'    => [
                    'Suitable for'  => 'Primary, secondary & private schools, colleges',
                    'Payments'      => 'M-Pesa Paybill integration',
                    'Notifications' => 'SMS to parents & guardians',
                    'Platform'      => 'Web + mobile-friendly',
                    'Reports'       => 'Fee collection, arrears, report cards',
                    'Support'       => 'Data migration & staff training',
                ],
                'pricing_tiers'     => [
                    ['name' => 'Basic',    'price' => 3500,  'period' => 'month', 'features' => ['Up to 300 students', 'Fees & M-Pesa', 'SMS reminders']],
                    ['name' => 'Standard', 'price' => 7500,  'period' => 'month', 'features' => ['Up to 1,000 students', 'Report cards & timetables']],
                    ['name' => 'Premium',  'price' => 15000, 'period' => 'month', 'features' => ['Unlimited students', 'Multi-campus', 'Priority support']],
                ],
            ],
        ];
    }
}
