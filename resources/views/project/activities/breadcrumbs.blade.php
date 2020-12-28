<div>
<span>
<span class="page-top_heading">Projects </span>
<span class="page-top_arrow"> > </span>
<span> <a href="{{$project->path()}}">{{$project->name}}</a></span>
<span class="page-top_arrow"> > </span>
<span>
Activities
@if (Route::is('activities') && empty(Request::query()))
> <span class="ml-2">All Project Activities</span>
@endif
@if (request()->has('mine'))
> <span class="ml-2">Mine</span>
@endif
@if (request()->has('related'))
> <span class="ml-2">Project Specfic</span>
@endif
@if (request()->has('task'))
> <span class="ml-2">Tasks</span>
@endif
@if (request()->has('appointment'))
> <span class="ml-2">Appointments</span>
@endif
</span>
</span>
</div>
