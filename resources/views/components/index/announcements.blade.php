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
                            <h5  class="text-danger">title</h5>
                            <span > {!!$announcements->first()->subtitle !!}</span>
                        </div>
                        <div style="padding-right: 4rem" class="text-right">
                            <a href="#">Δείτε περισσότερα</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endisset
