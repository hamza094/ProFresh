      <div class="row">
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Email</b>: <span> {{$project->email}} </span>
                                    </p>
                                    <p class="crm-info"> <b>Mobile</b>: <span> {{$project->mobile}} </span></p>
                                    @if($project->postponed == null || $project->postponed !== 0)
                                    <p class="crm-info"> <b>Postponed reason</b>: <span> Not Defined  </span></p>
                                    @else
                                    <p class="crm-info"> <b>Postponed reason</b>: <span> {{$project->postponed}}  </span></p>
                                    @endif
                                    <p class="crm-info"> <b>Zipcode</b>: <span> {{$project->zipcode}} </span></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Address</b>: <span> {{$project->address}} </span></p>
                                    <p class="crm-info"> <b>Created At</b>: <span> {{$project->created_at->diffForHumans()}} </span></p>
                                    <p class="crm-info"> <b>Updated At</b>: <span> {{$project->updated_at->diffForHumans()}} </span></p>
                                    <p class="crm-info"> <b>Updated By</b>: <span> Hamza </span></p>
                            </div>
                            </div>