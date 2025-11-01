<?php

declare(strict_types=1);

namespace App\Services\Insights;

interface InsightBuilderInterface
{
    /**
     * Build insight from input data
     *
     * @param  mixed  $input  Primary metric value or data array
     * @param  array<string,mixed>  $context  Additional context data for insight generation
     * @return array<string,mixed> Standardized insight response
     */
    public function build(mixed $input, array $context = []): array;
}
