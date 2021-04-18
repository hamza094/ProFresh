<div class="project-info">
                       <div class="project-info_socre">
                         <p class="project-info_score-heading">Score</p>
                         @if($score_sum <= 49)
                         <p class="project-info_score-point project-info_score-point_cold">{{$score_sum}}</p>
                         @else
                             <p class="project-info_score-point project-info_score-point_hot">{{$score_sum}}</p>
                         @endif
                       </div>
                       <div class="project-info_rec">
                         <span>Last Seen</span>
                         <p>{{Carbon\Carbon::parse($project->user->lastseen)->diffforHumans()}}</p>
                       </div>
                       <div class="project-info_rec">
                         <span>Stage Updated</span>
                         <p>{{Carbon\Carbon::parse($project->stageUpdate())->diffforHumans()}}</p>
                       </div>
                       <div class="project-info_rec">
                         <span>Last modified</span>
                         <p>{{$project->updated_at->diffForHumans()}}</p>
                       </div>
                     </div>