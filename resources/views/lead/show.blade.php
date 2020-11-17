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
                        <lead-edit :lead="{{$lead}}" :subscribe="{{json_encode($lead->IsSubscribedTo)}}"></lead-edit>
                    </div>
                </div>
                <div class="page-content">
                    <div class="row">
                        <div class="col-md-2">
                      <single-lead :lead="{{$lead}}" v-cloak>
                          <template v-slot:trig>
                              @if($scores <=49)
                              <span role="button" class="score-point score-point_cold">{{$scores}}</span>
                              @else
                                  <span role="button" class="score-point score-point_hot">{{$scores}}</span>
                              @endif
                          </template>
                          <div class="score">
                              <div class="score-content">
                                  <p class="score-content_para"><i class="far fa-clock"></i><b>Lead</b> since {{$lead->created_at->diffForHumans()}} with current in stage <b>Connected</b></p>
                                  <div class="score-content_point">
                                      <p class="score-content_point-para"><b>Top scoring factors</b></p>
                                      <div class="row">
                                          <div class="col-md-3">
                                              <p class="score-content_point-cold">
                                                  @if($scores <=49)
                                                  <span class="score-content_point-cold_point">{{$scores}}</span><br><span class="score-content_point-cold_status">Cold</span></p>
                                              @else
                                                  <span class="score-content_point-hot_point">{{$scores}}</span><br><span class="score-content_point-hot_status">Hot</span></p>
                                              @endif
                                          </div>
                                          <div class="col-md-9">
                                           @foreach($lead->scores as $score)
                                               <p class="lead-score"><span><i class="fas fa-arrow-up"></i></span> {{$score->message}}</p>
                                                  <p class="lead-score"><span><i class="fas fa-arrow-up"></i></span> Lead Updated</p>

                                              @endforeach
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </single-lead>
                        </div>
                        <div class="col-md-10">
                            <div class="content">
                                <p class="content-name">{{$lead->name}}</p>
                                <p class="content-info">Sales Manager<span class="content-dot"></span>Widjets.co</p>
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q=1200 Pennsylvania Ave SE, Washington, District of Columbia, 20003" target="_blank">Mongolia, Usa</a></p>
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
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Company country</b>: <span></span></p>
                                    <p class="crm-info"> <b>Company address</b>: <span></span></p>
                                    <p class="crm-info"> <b>Company zipcode</b>: <span> </span></p>
                                    <p class="crm-info"> <b>Number of employee</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Company website</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Industry Type</b>: <span>  </span></p>


                                </div>
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Company annual revenue</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Company Phone</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Busniess Type</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Deal name</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Deal value</b>: <span>  </span></p>
                                    <p class="crm-info"> <b>Deal closed_date</b>: <span>  </span></p>


                                </div>
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
            <div class="col-md-4">
                by
            </div>
        </div>
    </div>



@endsection


 
