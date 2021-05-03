    <div class="content">
                                <p class="content-name">{{$project->name}}</p>
                                <p class="content-info">
                                  @if($project->position !==null)
                                  {{$project->position}}
                                  @else
                                  Add Position
                                  @endif
                                  <span class="content-dot"></span>
                                  Add Company
                                </p>
                                @if($project->address !==null)
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i><a href="http://maps.google.com/?q={{$project->address}}" target="_blank">{{$project->address}}</a></p>
                                @else
                                <p class="content-map"><i class="fas fa-map-marker-alt"></i> Add Address</p>
                                @endif
                            </div>