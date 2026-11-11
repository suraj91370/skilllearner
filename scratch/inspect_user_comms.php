<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach ([1, 5, 7] as $uid) {
    $u = App\Models\User::find($uid);
    if (!$u) continue;
    echo "=== USER #{$u->id}: {$u->name} ===\n";
    echo "User record: Today={$u->today_earning}, Weekly={$u->weekly_earning}, Monthly={$u->monthly_earning}, Total={$u->total_earning}\n";
    $comms = $u->commissions()->get();
    echo "Commission rows: " . $comms->count() . "\n";
    foreach ($comms as $c) {
        echo "  - Comm #{$c->id}: Amount={$c->amount}, Status={$c->status}, Type={$c->commission_type}, Date={$c->created_at}\n";
    }
}

