<?php
namespace App\Repository\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Stage;
use Carbon\Carbon;

class ProjectFiltersRepository
{
   public function filters(Request $request,$perPage,$appliedFilters): array
   {

    $projects = Project::with('stage','user')
            ->withCount('tasks', 'activeMembers')
            ->withTrashed()

            ->when($request->sort, function ($query, $sortDirection) use (&$appliedFilters) {
            $this->applySort($query, $sortDirection, $appliedFilters);
            })


        ->when($request->search, function ($query) use ($request, &$appliedFilters) {
        $this->applySearchFilter($query, $request->search, $appliedFilters);
      })

        ->when($request->filter === "active", function ($query) use (&$appliedFilters) {
        $query->whereNull('deleted_at');
        $appliedFilters[] = "Filter by Active";
       })

       ->when($request->filter === "trashed", function ($query) use (&$appliedFilters) {
         $query->whereNotNull('deleted_at'); 
        $appliedFilters[] = "Filter by Trashed";

        })

        ->when($request->members, function ($query) use (&$appliedFilters){
            $query->whereHas('members', function ($subQuery) {
             $subQuery->where('project_members.active', true);
        });
           $appliedFilters[] = "Filter by Active Members";
        })

        ->when($request->tasks, function ($query) use (&$appliedFilters)  {
            $query->has('tasks');
            $appliedFilters[] = "Filter by Active Members";
 
        })
        ->when($request->stage === '0', function ($query) use (&$appliedFilters) {
    $query->where(function ($query) {
        $query->where('stage_id', 0)
            ->where(function ($query) {
                $query->whereNotNull('postponed')
                    ->orWhere('completed', true);
            });
    });
    $appliedFilters[] = "Filter by Stage: Clo/Pos";
    })
    ->when($request->stage, function ($query, $stageId) use (&$appliedFilters) {
        $stage = Stage::find($stageId);
    if ($stage) {
        $query->where('stage_id', $stageId);
        $appliedFilters[] = "Filter by Stage: {$stage->name}";
      }
    })

    ->when($request->from && $request->to, function ($query) use ($request, &$appliedFilters) {
        $this->applyDateRangeFilter($query, $request->from, $request->to, $appliedFilters);
    })
       ->when($request->status, function ($query) use ($request, &$appliedFilters) {
        $this->applyStatusFilter($query, $request->status, $appliedFilters);
    })
    ->get();

     return [
        'projects' => $projects,
        'appliedFilters' => $appliedFilters,
    ];

   }

   protected function applySort($query, string $sortDirection, array &$appliedFilters): void
   {
    $query->orderBy('created_at', $sortDirection);
     $appliedFilters[] = "Sort by $sortDirection";
   }

   protected function applySearchFilter($query, string $searchTerm, array &$appliedFilters): void
   {
    $query->where('name', 'like', "%$searchTerm%")
        ->orWhereHas('user', function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%$searchTerm%")
                ->orWhere('username', 'like', "%$searchTerm%");
        });

    $appliedFilters[] = "Search in all";
   }

   protected function applyDateRangeFilter($query, string $from, string $to, array &$appliedFilters): void
  {
    $query->whereBetween('created_at', [$from, $to]);
    
    $fromDate = Carbon::parse($from);
    $toDate = Carbon::parse($to);
    
    $appliedFilters[] = "Filter from " . $fromDate->format('Y-m-d') . " to " . $toDate->format('Y-m-d');
  }

  protected function applyStatusFilter($query, $status, &$appliedFilters)
{
    return $query->filter(function ($project) use ($status, &$appliedFilters) {
        if ($project->status === $status) {
            $appliedFilters[] = "Filter by status $status";
            return true;
        }
        return false;
    });
}
 
}

?>