@if($userIs =="student")
    @foreach($allMaterials as $key =>   $materials )
        @if ($loop->parent->index ==$key)
            @foreach($materials as $material)
                <div class="card-body">
                    <div
                        class="badge badge-success float-right">
                        Completed
                    </div>

                    <h5><a href="#"
                           class="text-dark">{{$material->name}}</a>
                        <p class="text-muted mb-2">{{$material->small_description}}
                    </h5>
                    </p>

                    <div>
                        <a href="javascript: void(0);">
                            <img
                                src="{{$material->cover}}"
                                alt=""
                                class="avatar-sm m-1 rounded-circle">
                        </a>

                    </div>
                </div>

            @endforeach
        @endif
    @endforeach
@endif
