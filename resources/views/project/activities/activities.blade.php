@extends('header')
@section('crm')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 page pd-r">
                <div class="page-top">
      @include('project.activities.breadcrumbs')
                </div>
<div class="container mt-3">
  <div class="activity mb-5">
    <ul>
       @foreach($activities as $activity)
        <li>
        @include("project.activities.{$activity->description}")
            <p class="activity-info"><span>{{$activity->user->name}} </span><span class="activity-info_dot"></span><span> {{$activity->created_at->diffForHumans(null,true)}} ago</span></p>
        </li>
        @endforeach
    </ul>
  </div>
</div>
</div>
            <div class="col-md-4">
                <div class="card">
                 <div class="card-header">
                   <p>Search Related Activities:</p>
                 </div>
                 <div class="card-body activity-search">
                   <ul>
                     <li><a href="/projects/{{$project->id}}/timeline_feeds" class="{{ Route::is('activities') && empty(Request::query()) ? 'activity-icon_secondary activity-font' : '' }}"><i class="fas fa-layer-group activity-icon_secondary mr-3"></i>All Activities</a></li>
                     <li><a href="/projects/{{$project->id}}/timeline_feeds?mine={{auth()->user()->id}}" class="{{ request()->has('mine') ? 'activity-icon_purple activity-font' : '' }}"><i class="fas fa-user activity-icon_purple mr-3"></i> My Activities</a></li>
                     <li><a href="/projects/{{$project->id}}/timeline_feeds?related=1" class="{{ request()->has('related') ? 'activity-icon_green activity-font' : '' }}"><i class="far fa-star activity-icon_green mr-3"></i> Project Activities</a></li>
                     <li><a href="/projects/{{$project->id}}/timeline_feeds?task=1" class="{{ request()->has('task') ? 'activity-icon_primary activity-font' : '' }}"><i class="fas fa-tasks activity-icon_primary mr-3"></i> Task Activities</a></li>
                     <li><a href="/projects/{{$project->id}}/timeline_feeds?appointment=1" class="{{ request()->has('appointment') ? 'activity-icon_appoint activity-font' : '' }}"><i class="far fa-calendar-check activity-icon_appoint mr-3"></i> Appointment Activities</a></li>
                   </ul>
                 </div>
                </div>
                <div class="mt-4">
                    {{$activities->appends(request()->input())->links()}}
                </div>
            </div>
        </div>
    </div>



@endsection
