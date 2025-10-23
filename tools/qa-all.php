<?php

declare(strict_types=1);

// Run all QA tools and continue even if one fails. Print a summary and exit 1 if any failed.

chdir(__DIR__.'/../');

$php = escapeshellarg(PHP_BINARY);

$steps = [
    ['name' => 'PHPUnit',         'cmd' => "$php vendor/bin/phpunit"],
    ['name' => 'PHPStan',         'cmd' => "$php vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G"],
    ['name' => 'Pint (check)',    'cmd' => "$php vendor/bin/pint --test"],
    ['name' => 'Rector (dry-run)', 'cmd' => "$php vendor/bin/rector --dry-run"],
];

$results = [];
$overallExit = 0;

foreach ($steps as $step) {
    echo "=== {$step['name']} ===\n";
    $code = 0;
    passthru($step['cmd'], $code);
    $results[] = [$step['name'], $code];
    if ($code !== 0) {
        $overallExit = 1; // Remember failure but keep going
    }
    echo "\n";
}

echo "=== Summary ===\n";
foreach ($results as [$name, $code]) {
    echo sprintf("%-18s : %s\n", $name, $code === 0 ? 'OK' : 'FAIL');
}

exit($overallExit);
