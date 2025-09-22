<?php

namespace App\Services\Insights;

interface InsightBuilderInterface
{
    /**
     * Build insight from input data
     *
     * @param mixed $input Primary metric value or data array
     * @param array $context Additional context data for insight generation
     * @return array Standardized insight response
     */
    public function build(mixed $input, array $context = []): array;
}