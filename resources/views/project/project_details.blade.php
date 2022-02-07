    <div class="row">
        <div class="col-md-6">
            @if($project->postponed == null || $project->postponed !== 0)
            <p class="crm-info"> <b>Postponed reason</b>: <span> Not Defined  </span></p>
            @else
            <p class="crm-info"> <b>Postponed reason</b>: <span> {{$project->postponed}}  </span></p>
            @endif
        </div>
        <div class="col-md-6">
            <p class="crm-info"> <b>Tasks</b>: <span> Info </span></p>
            <p class="crm-info"> <b>Appointments</b>: <span> Info </span></p>
            <p class="crm-info"> <b>Other</b>: <span> Info </span></p>
    </div>
    </div>
