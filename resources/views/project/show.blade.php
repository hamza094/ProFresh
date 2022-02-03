@extends('header')
@section('crm')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-8 page pd-r">
                <div class="page-top">
                    <div>
            <span>
                <span class="page-top_heading">Projects </span>
                <span class="page-top_arrow"> > </span>
                <span> {{$project->name}}</span>
            </span>
            @can ('access', $project)

            <project-features :project="{{json_encode($project)}}" :subscribe="{{json_encode($project->IsSubscribedTo)}}"  :members="{{json_encode($project->activeMembers)}}" ></project-features>

                        @endcan
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-2">
                          @can ('access', $project)

                      <project-feature :project="{{json_encode($project)}}" :scores="{{json_encode($score_sum)}}"
                       :details="{{json_encode($project->scores)}}"></project-feature>

                       @endcan
                        </div>
                        <div class="col-md-10">

                        @include('project.project_info')

                          </div>
                   </div>
                    <hr>
                    <p class="pro-info">Project Detail</p>

                    @include('project.project_details')

                    <hr>
                    @can ('access', $project)

                    <project-stage :project="{{$project}}"></project-stage>

                    <hr>
                    @endcan
                    <h3>RECENT ACTIVITIES</h3>
                    <div class="row">
                   <div class="col-md-7 mb-5">
                     <div class="activity">

                      @include('project.activities.card')

                    </div>
                   </div>
                   <div class="col-md-5">

                     @include('project.project_features')

                   </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 side_panel">
              @can ('access', $project)

                <project-panel
                :project="{{json_encode($project)}}"
                :members="{{json_encode($project->activeMembers)}}"
                :projectgroup="{{json_encode($project->group)}}"
                :cons="{{json_encode($conversation_count)}}"></project-panel>

                @endcan
            </div>
        </div>
    </div>
@endsection
