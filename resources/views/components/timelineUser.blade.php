
@forelse($activities as $activity)
<div class="timeline-alt pb-0">
    <div class="timeline-item">
        <i class="mdi mdi-circle bg-info-lighten text-info timeline-icon"></i>
        <div class="timeline-item-info">
            <h5 class="mt-0 mb-1">{{$activity->causer->fullName}}</h5>
            <p class="font-16">{{$activity->description}} <span class="ml-2 font-13">{{$activity->causer->created_at->format("d/m/y")}}  ({{$activity->created_at->diffForHumans()}})</span></p>

        </div>
    </div>
</div>
@empty
    <h3>Δεν υπάρχει η δραστηριότητα </h3>
@endforelse
