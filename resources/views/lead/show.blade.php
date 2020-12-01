@extends('header')
@section('crm')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-8 page pd-r">
                <div class="page-top">
                    <div>
            <span>
                <span class="page-top_heading">Leads </span>
                <span class="page-top_arrow"> > </span>
                <span> {{$lead->name}}</span>
            </span>
                        <lead-edit :lead="{{json_encode($lead)}}" :subscribe="{{json_encode($lead->IsSubscribedTo)}}"></lead-edit>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-2">
                      <single-lead :lead="{{json_encode($lead)}}" :scores="{{json_encode($scores)}}"
                       :details="{{json_encode($lead->scores)}}"></single-lead>
                        </div>
                        <div class="col-md-10">
                            <div class="content">
                                <p class="content-name">{{$lead->name}}</p>
                                <p class="content-info">
                                  @if($lead->position !==null)
                                  {{$lead->position}}
                                  @else
                                  Add Position
                                  @endif
                                  <span class="content-dot"></span>
                                  @if($lead->account()->count() > 0)
                                  <a href="/api/accounts/{{$lead->account->id}}" target="_blank">{{$lead->account->title}}</a>
                                  @else
                                  Add Company
                                  @endif
                                </p>
                                @if($lead->address !==null)
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q={{$lead->address}}" target="_blank">{{$lead->address}}</a></p>
                                @else
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i> Add Address</p>
                                @endif
                            </div>

                        </div>

                    </div>
                    <hr>
                    <ul class="nav nav-tabs float-right" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Company</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Email</b>: <span> {{$lead->email}} </span></p>
                                    <p class="crm-info"> <b>Mobile</b>: <span> {{$lead->mobile}} </span></p>
                                    @if($lead->unqualifed == null)
                                    <p class="crm-info"> <b>Unqualified reason</b>: <span> Not Known  </span></p>
                                    @else
                                    <p class="crm-info"> <b>Unqualified reason</b>: <span> {{$lead->unqualifed}}  </span></p>
                                    @endif
                                    <p class="crm-info"> <b>Zipcode</b>: <span> {{$lead->zipcode}} </span></p>
                                    <p class="crm-info"> <b>Sales Owner</b>: <span> {{$lead->owner}} </span></p>
                                    <p class="crm-info"> <b>Subscription status</b>: <span>{{$lead->status}}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Source</b>: <span> Organic  </span></p>
                                    <p class="crm-info"> <b>Address</b>: <span> {{$lead->address}} </span></p>
                                    <p class="crm-info"> <b>Created At</b>: <span> {{$lead->created_at->diffForHumans()}} </span></p>
                                    <p class="crm-info"> <b>Updated At</b>: <span> {{$lead->updated_at->diffForHumans()}} </span></p>
                                    <p class="crm-info"> <b>Updated By</b>: <span> Hamza </span></p>
                                    <p class="crm-info"> <b>Medium</b>: <span> Blog </span></p>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                              @if($lead->account()->count() > 0)
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Company country</b>: <span> <a href="/api/acounts/1">{{$lead->account->title}}</a> </span></p>
                                    <p class="crm-info"> <b>Company address</b>: <span> {{$lead->account->address}} </span></p>
                                    <p class="crm-info"> <b>Company zipcode</b>: <span> {{$lead->account->zipcode}} </span></p>
                                    <p class="crm-info"> <b>Number of employee</b>: <span> {{$lead->account->employee}}<span></p>
                                    <p class="crm-info"> <b>Company website</b>: <span> <a  href="//{{$lead->account->website}}" target="_blank">{{$lead->account->website}}</a> </span></p>
                                    <p class="crm-info"> <b>Industry Type</b>: <span> {{$lead->account->industry}} </span></p>
                                 </div>

                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Company annual revenue</b>: <span> {{$lead->account->revenue}} </span></p>
                                    <p class="crm-info"> <b>Company Phone</b>: <span> {{$lead->account->number}} </span></p>
                                    <p class="crm-info"> <b>Busniess Type</b>: <span> {{$lead->account->business}} </span></p>
                                    <p class="crm-info"> <b>Deal name</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Deal value</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Deal closed_date</b>: <span>  </span></p>
                                </div>
                                @else
                                <lead-account :lead="{{json_encode($lead)}}"></lead-account>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <lead-stage :lead="{{$lead}}"></lead-stage>
                    <hr>
                    <h3>RECENT ACTIVITIES</h3>
                    <div class="row">

                   <div class="col-md-7 mb-5">
                     <div class="activity">
                      @include('lead.activities.card')
                    </div>
                   </div>
                   <div class="col-md-5">
                     <div class="lead-info">
                       <div class="lead-info_socre">
                         <p class="lead-info_score-heading">Score</p>
                         @if($scores <= 49)
                         <p class="lead-info_score-point lead-info_score-point_cold">{{$scores}}</p>
                         @else
                             <p class="lead-info_score-point lead-info_score-point_hot">{{$scores}}</p>
                         @endif
                       </div>
                       <div class="lead-info_rec">
                         <span>Last Seen</span>
                         <p>{{Carbon\Carbon::parse($lead->user->lastseen())->diffforHumans()}}</p>
                       </div>
                       <div class="lead-info_rec">
                         <span>Stage Updated</span>
                         <p>{{Carbon\Carbon::parse($lead->stageUpdate())->diffforHumans()}}</p>
                       </div>
                       <div class="lead-info_rec">
                         <span>Last modified</span>
                         <p>{{$lead->updated_at->diffForHumans()}}</p>
                       </div>
                     </div>
                   </div>
                    </div>

                </div>

            </div>
            <div class="col-md-4 side_panel">
                <lead-panel :lead="{{json_encode($lead)}}" v-cloak></lead-panel>
            </div>
        </div>
    </div>



@endsection


 
