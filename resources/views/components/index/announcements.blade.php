@if(count($announcements)>0)
    <div class="accordion custom-accordion mb-2" id="announcement-collapse">
        <div class="card mb-0">
            <div class="card-header p-2" id="announcement-head">
                <h5 class="m-0 pl-2">
                    <a class="custom-accordion-title d-block py-1"
                       data-toggle="collapse" href="#announcement-col"
                       aria-expanded="true" aria-controls="announcement-col">
                        Ανακοινώσεις
                        <i
                            class="mdi mdi-chevron-down accordion-arrow"></i>
                    </a>
                </h5>
            </div>
            <div id="announcement-col" class="collapse show"
                 aria-labelledby="announcement-head"
                 data-parent="#announcement-collapse">
                <div class="card-body d-flex flex-column pt-2">
                    <div style="padding-right: 3.95rem">
                        <h5 class="text-danger">title</h5>
                        <span> {!!$announcements->sortByDesc('created_at')->first()->content !!}</span>
                    </div>
                    <div style="padding-right: 4rem" class="text-right">
                        <a type="button" class="custom-link-primary" data-toggle="modal"
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
                                                    <div class="swiper-slide text-left">
                                                        <h3 class="mb-3">{!! $announcement->title !!}</h3>
                                                       <p>{!! $announcement->content !!}</p>
                                                        <p class="m-0 p-0 font-12" >{{$announcement->created_at->diffForHumans()}}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <!-- If we need pagination -->
                                            <div class="swiper-pagination-announcements"></div>

                                            <!-- If we need navigation buttons -->
                                            <div class="swiper-button-prev-announcements"></div>
                                            <div class="swiper-button-next-announcements"></div>

                                            <!-- If we need scrollbar -->
                                            <div class="swiper-scrollbar-announcements"></div>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>

                </div>
            </div>
        </div>
    </div>
@endisset
