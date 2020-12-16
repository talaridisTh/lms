<div class="container content-width mt-4">

    <ul class="nav nav-tabs nav-bordered mb-3">
        <li class="nav-item">
            <a href="#compose-mail-tab" class="nav-link active" data-toggle="tab" aria-expanded="false">
                Δημιουργία
            </a>
        </li>
        <li class="nav-item">
            <a href="#recipients-tab" class="nav-link" data-toggle="tab" aria-expanded="true">
                Παραλήπτες
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane show active" id="compose-mail-tab">
            <form id="email-form" action="{{route('discussion.sendTask')}}" method="POST" autocomplete="off">

                @csrf
                <div id="file-target"></div>

                <!--element -->
                <input type="text" name="id" value="" hidden>

                <div class="form-group d-flex">
                    <div class="cnt-title " style="flex:1">
                        <label for="subject">Θέμα</label>
                        <input id="subject" class="form-control" type="text"
                               placeholder="Εισάγετε θέμα..." name="subject"
                               value=""/>

                    </div>

                    <div class="cnt-curator ml-2">
                        <label for="subject">Θέμα</label>
                        <input id="subject" class="form-control" type="text"
                               placeholder="Εισάγετε θέμα..." name="curator"
                               value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="editor">Περιεχόμενο</label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              id="editor" placeholder="Εισάγετε περιεχόμενο..."
                              name="content" rows="5"></textarea>
                    @error('content')
                    <span class="text-danger" role="alert">
									<small><strong>{{ $message }}</strong></small>
								</span>
                    @enderror
                </div>

               <button class="btn btn-secondary js-send-task">Send</button>
            </form>
        </div>
        <div class="tab-pane" id="recipients-tab">

            <div class="text-right mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#users-table-modal">
                    Προσθήκη
                </button>
                <button id="remove-recipients-btn" class="btn btn-secondary" disabled
                        data-enabled-color="btn-secondary" data-disabled-color="btn-secondary" data-text="Αφαίρεση">
                    Αφαίρεση (0)
                </button>
            </div>

            <table id="recipients-datatable" class="table w-100 nowrap center-not-second js-remove-table-classes">
                <thead>
                <tr>
                    <th class="text-center" style="width: 35px">
                        <div class='icheck-primary d-inline'>
                            <input type='checkbox' id='select-all-recipients' autocomplete='off'>
                            <label for='select-all-recipients'></label>
                        </div>
                    </th>
                    <th class="text-center">Ονοματεπώνυμο</th>
                    <th class="text-center min-width-200 w-300px">Courses</th>
                    <th class="text-center min-width-200 w-300px">Bundles</th>
                    <th class="text-center min-width-200 w-300px">Email</th>
                    <th class="text-center min-width-200 w-300px">Ιδιότητα</th>
                    <th class="text-center" style="width: 35px"></th>
                    <th>Όνομα</th>
                    <th>Επώνυμο</th>
                </tr>
                </thead>
                <tbody class="tables-hover-effect"></tbody>
                <tfoot>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Ονοματεπώνυμο</th>
                    <th class="text-center">Courses</th>
                    <th class="text-center">Bundles</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Ιδιότητα</th>
                    <th class="text-center"></th>
                    <th>Όνομα</th>
                    <th>Επώνυμο</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $R('#editor', {
        fileUpload: 'media/files-upload',
        fileAttachment: '#file-target',
        callbacks: {
            upload: {
                beforeSend: function(xhr)
                {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            }
        },
        imageData: {
            id: 10,
        }
    });
</script>
