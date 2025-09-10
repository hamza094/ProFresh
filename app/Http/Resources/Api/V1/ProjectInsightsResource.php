<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectInsightsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $project = $this['project'];
        $insights = $this['insights'];
        $sections = $this['sections'];
        $singleSection = $this['single_section'];

        return [
            'success' => true,
            'data' => array_filter([
                'project_id' => $project->id,
                'project_name' => $project->name,
                'insights' => $insights,
                'generated_at' => now()->toISOString(),
                'section' => $singleSection,
                'sections_requested' => $singleSection ? null : $sections,
            ], fn($value) => $value !== null),
            'message' => $singleSection
                ? "Project {$singleSection} insights retrieved successfully"
                : 'Project insights retrieved successfully',
        ];
    }
}
