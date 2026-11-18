<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Moves content written for South Africa over to Nairobi, Kenya. Only the exact
 * phrases below change, so it is safe to run more than once.
 */
class LocalizeContentForKenya extends Command
{
    protected $signature = 'content:localize-kenya {--dry-run : Show what would change without saving}';

    protected $description = 'Replace South African content, prices and blog URLs with the Kenyan versions';

    protected const TABLES = [
        'blogs', 'faqs', 'services', 'reviews', 'settings', 'pages', 'case_studies',
        'products', 'packages', 'bundles', 'industries', 'seo_data', 'sliders', 'counters',
    ];

    /** Rand starting prices and their KES equivalents (about 7 KES per ZAR, rounded). */
    protected const PRICES = [
        3000 => 20000, 5000 => 35000, 6000 => 40000, 7000 => 50000, 8000 => 55000, 10000 => 70000,
        12000 => 85000, 15000 => 100000, 18000 => 125000, 20000 => 140000, 25000 => 175000, 50000 => 350000,
    ];

    /** Ordered: full sentences first, general place names last. */
    protected const REPLACEMENTS = [
        // FAQs
        'We are headquartered in Sandton, Johannesburg, South Africa.' => 'We are headquartered in Nairobi, Kenya.',
        'payment gateways (PayFast, Stripe)' => 'payment gateways (M-Pesa Daraja, Stripe)',

        // AI article
        '10 Ways AI Is Transforming SA Businesses' => '10 Ways AI Is Transforming Kenyan Businesses',
        'meet FICA and POPIA requirements automatically' => 'meet KYC, anti-money-laundering and Data Protection Act requirements automatically',
        'AI South Africa,' => 'AI Kenya,',

        // Cybersecurity
        'South Africa ranks among the top 10 most targeted countries for cyber attacks globally.' => 'Cyber attacks on Kenyan businesses are a growing risk.',
        'South Africa ranks among the top 10 most-targeted countries globally.' => 'Cyber attacks on Kenyan businesses are a growing risk.',
        'For every R1 invested in proactive cybersecurity, companies save an average of R7 in breach-related costs.' => 'Investing in proactive cybersecurity usually costs far less than recovering from a breach.',

        // Tech stack
        'tens of thousands of rands' => 'hundreds of thousands of shillings',

        // E-commerce
        'South African online retail grew 30% year-on-year, reaching R71 billion in 2024. Mobile commerce now accounts for 65% of all transactions, making mobile-first design essential.'
            => 'Online retail in Kenya is growing, and many shoppers browse and pay on their phones, making mobile-first design essential.',
        'PayFast and Peach Payments handle card transactions, while SnapScan and Zapper cater to mobile-first shoppers. Integration with Ozow enables instant EFT, which is South Africas most popular online payment method.'
            => 'M-Pesa is the payment method most Kenyan shoppers expect, so an STK Push checkout is essential. Add Airtel Money and card payments through gateways such as Pesapal or Flutterwave to cover everyone else.',
        "PayFast and Peach Payments handle card transactions, while SnapScan and Zapper cater to mobile-first shoppers. Integration with Ozow enables instant EFT, which is South Africa's most popular online payment method."
            => 'M-Pesa is the payment method most Kenyan shoppers expect, so an STK Push checkout is essential. Add Airtel Money and card payments through gateways such as Pesapal or Flutterwave to cover everyone else.',
        'Partner with multiple couriers (The Courier Guy, Pargo, Dawn Wing)' => 'Partner with multiple couriers (G4S, Fargo Courier, Pick Up Mtaani)',
        'Courier Guy, DHL' => 'G4S, DHL',
        'South African e-commerce hit R71 billion. Learn' => 'Kenyan e-commerce is growing. Learn',
        'Building a World-Class E-Commerce Site in SA' => 'Building a World-Class E-Commerce Site in Kenya',
        'PayFast integration' => 'M-Pesa integration',

        // Data protection article
        'POPIA Compliance Checklist 2025 | OmniviaTech' => 'Kenya Data Protection Act Checklist 2025 | OmniviaTech',
        'POPIA Compliance Checklist: What Your Business Must Do in 2025' => 'Data Protection Act Compliance Checklist: What Your Business Must Do in 2025',
        'The Protection of Personal Information Act is fully enforceable. Use this comprehensive checklist to ensure your business meets all POPIA requirements.'
            => "Kenya's Data Protection Act, 2019 is fully enforceable. Use this comprehensive checklist to ensure your business meets its requirements.",
        '<h2>POPIA Is Here to Stay</h2><p>The Information Regulator has begun issuing enforcement notices and fines. Non-compliance can result in penalties of up to R10 million or imprisonment.'
            => '<h2>The Data Protection Act Is Here to Stay</h2><p>The Office of the Data Protection Commissioner (ODPC) has issued enforcement notices and penalties. Confirm current requirements and penalties directly with the ODPC.',
        '1. Appoint an Information Officer</strong> — Register them with the Information Regulator.' => '1. Assign Data Protection Responsibility</strong> — Name a responsible person and check whether you must register with the ODPC as a data controller or processor.',
        'notification procedures for the Regulator and affected parties' => 'notification procedures for the ODPC and affected parties',
        'Learn the 7 essential steps to meet the Protection of Personal Information Act requirements.' => "Learn the 7 essential steps to meet the requirements of Kenya's Data Protection Act, 2019.",
        'privacy act checklist' => 'ODPC checklist',

        // Services
        '<p>South African online retail is booming.' => '<p>Online retail in Kenya is growing.',
        'supporting local payment methods like PayFast, Ozow, and SnapScan.' => 'supporting local payment methods like M-Pesa, Airtel Money and card.',
        'Multi-gateway payments (PayFast, Stripe, PayPal, Ozow)' => 'Multi-gateway payments (M-Pesa, Stripe, PayPal, Pesapal)',
        'Xero, QuickBooks, PayFast, Stripe' => 'Xero, QuickBooks, M-Pesa Daraja, Stripe',

        // Reviews
        'The payment integrations with PayFast and Ozow work perfectly' => 'The M-Pesa and Pesapal payment integrations work perfectly',

        // General terms
        'POPIA/GDPR' => 'Data Protection Act/GDPR',
        'POPIA & GDPR' => 'Data Protection Act & GDPR',
        'POPIA' => 'Data Protection Act',
        'Sandton, Johannesburg' => 'Nairobi',
        'Johannesburg' => 'Nairobi',
        'South African' => 'Kenyan',
        'South Africa' => 'Kenya',
        'PayFast' => 'M-Pesa',
    ];

    public static function localize(string $text, bool $phpSingleQuoted = false): string
    {
        foreach (self::REPLACEMENTS as $from => $to) {
            $text = str_replace($from, $phpSingleQuoted ? str_replace("'", "\\'", $to) : $to, $text);
        }

        return preg_replace_callback('/\bFrom R\s?(\d{1,3}(?:,\d{3})+|\d+)/', function (array $match) {
            $kes = self::PRICES[(int) str_replace(',', '', $match[1])] ?? null;

            return $kes ? 'From KES ' . number_format($kes) : $match[0];
        }, $text);
    }

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $changed = 0;

        DB::transaction(function () use ($dryRun, &$changed) {
            foreach (self::TABLES as $table) {
                if (Schema::hasTable($table)) {
                    $changed += $this->localizeTable($table, $dryRun);
                }
            }

            $changed += $this->syncServicePrices($dryRun);

            foreach (config('redirects.blog_slugs', []) as $old => $new) {
                $query = DB::table('blogs')->where('slug', $old);

                if ($query->exists() && !DB::table('blogs')->where('slug', $new)->exists()) {
                    $this->line("blogs: URL {$old} -> {$new}");
                    $changed++;

                    if (!$dryRun) {
                        $query->update(['slug' => $new]);
                    }
                }
            }
        });

        if (!$dryRun) {
            Cache::forget('homepage_data');
            Cache::forget('settings');
        }

        $this->info($changed . ($dryRun ? ' changes found. Nothing was saved.' : ' changes saved.'));

        return self::SUCCESS;
    }

    /** The chat assistant quotes price_from, so it must match the KES label shown on the site. */
    protected function syncServicePrices(bool $dryRun): int
    {
        $changed = 0;

        foreach (DB::table('services')->where('price_label', 'like', 'From KES %')->get(['id', 'price_from', 'price_label']) as $service) {
            if (!preg_match('/From KES ([\d,]+)/', $service->price_label, $match)) {
                continue;
            }

            $price = (float) str_replace(',', '', $match[1]);

            if ((float) $service->price_from !== $price) {
                $this->line("services #{$service->id}: price_from {$service->price_from} -> {$price}");
                $changed++;

                if (!$dryRun) {
                    DB::table('services')->where('id', $service->id)->update(['price_from' => $price]);
                }
            }
        }

        return $changed;
    }

    protected function localizeTable(string $table, bool $dryRun): int
    {
        $columns = collect(Schema::getColumns($table))
            ->filter(fn ($column) => preg_match('/char|text|json/i', $column['type_name']))
            ->pluck('name')
            ->reject(fn ($name) => $name === 'slug' || ($table === 'settings' && $name !== 'value'))
            ->all();
        $changed = 0;

        foreach (DB::table($table)->orderBy('id')->get() as $row) {
            $update = [];

            foreach ($columns as $column) {
                $value = $row->{$column} ?? null;

                if (is_string($value) && $value !== '' && ($new = self::localize($value)) !== $value) {
                    $update[$column] = $new;
                }
            }

            if ($update) {
                $changed += count($update);
                $this->line("{$table} #{$row->id}: " . implode(', ', array_keys($update)));

                if (!$dryRun) {
                    DB::table($table)->where('id', $row->id)->update($update);
                }
            }
        }

        return $changed;
    }
}
