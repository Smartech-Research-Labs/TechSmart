<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::where('email', 'robertgicheha3@gmail.com')->first();
    
    if ($user) {
        echo "User already exists. Updating password...\n";
        $user->update([
            'password' => Hash::make('Admin@123'),
        ]);
        echo "Password updated successfully!\n";
    } else {
        echo "Creating new SuperAdmin user...\n";
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'robertgicheha3@gmail.com',
            'password' => Hash::make('Admin@123'),
            'email_verified_at' => now(),
        ]);
        
        $user->assignRole('superadmin');
        echo "SuperAdmin created successfully!\n";
    }
    
    echo "\n✅ Credentials:\n";
    echo "Email: robertgicheha3@gmail.com\n";
    echo "Password: Admin@123\n";
    echo "Role: SuperAdmin\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
