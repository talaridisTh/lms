<style>
    .swiper-button-prev:after , .swiper-button-next:after{
        font-size: 30px;
    }
</style>
@if(count($announcements)>0)
    <div class="alert alert-danger pl-3" role="alert">
        <span class="alert-link">{{--<i class=" h3 mdi mdi-chat-alert mr-3">--}}</i>{!!$announcements->first()->title !!}</span>
        <div class="pt-2" style="padding-right: 3.95rem">
            <span> {!!$announcements->sortByDesc('created_at')->first()->content !!}</span>
        </div>
        <div style="padding-right: 1rem" class="text-right">
            <a type="button" class="" style="color: #000000" data-toggle="modal"
               data-target="#announcements-modal">Δείτε περισσότερα
            </a>
            <div class="modal fade" id="announcements-modal" tabindex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="swiper-container-announcements" style="overflow: hidden">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    @foreach($announcements->sortByDesc('created_at') as $announcement)
                                        <div class="swiper-slide text-left p-3">
                                            <h3 class="mb-3">{!! $announcement->title !!}</h3>
                                            <p>{!! $announcement->content !!}</p>
                                            <p class="m-0 p-0 font-12" >{{$announcement->created_at->diffForHumans()}}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination-announcements"></div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>

                                <!-- If we need scrollbar -->
                                <div class="swiper-scrollbar-announcements"></div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
@endisset
