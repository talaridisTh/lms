<style>

</style>

<div class="filter-thread d-flex justify-content-between stick bg-light mt-2">
    <div class="d-flex m-2">
        <div class="form-group my-1 p-1">
            <select class="form-control bg-list-thread filter-sidebar" id="">
                <option value="desc">Latest</option>
                <option value="asc">Oldest</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>

        <div class="form-group my-1  p-1">
            <select class="form-control bg-list-thread filter-course" id="">
                <option>All</option>
                @foreach($courses as $key=> $course)
                    <option>{{$courses[$key]}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="d-flex m-2">
        <div class="form-group my-1  p-1">
            <i class="font-24 uil-grip-horizontal-line bg-list-thread mr-1 js-hidden-body cursor-pointer js-body-active"
               style="padding: 0px 0.375rem"></i>
            <i class="font-24 uil-align-left bg-list-thread js-show-body cursor-pointer"
               style="padding: 0px 0.375rem"></i>
        </div>

        <div class="form-group my-1  p-1 position-relative">
            <i class="uil-search position-absolute global-search"></i>
                <input type="text" class="form-control bg-list-thread js-search-post pl-4" placeholder="Πάτα &quot;/&quot; Αναζήτηση">
        </div>
    </div>
</div>

<div class="cnt-threads-main-list">
    <ul class="threads-main-list p-0 mt-3">
        @forelse($posts  as $post)
            <li class="d-flex list-unstyled bg-list-thread px-3 py-2 mb-3 single-thread" data-post-id="{{$post->id}}">

                <div class="mr-2 d-flex align-items-center ">
                    <img src="{{$post->user->avatar}}" class="avatar-sm rounded" alt="">
                </div>

                <div class="container-fluid ">
                    <div class="row">
                        <div class="col-md-7">
                            <h4 class="text-hover-underline cursor-pointer js-thread-title">{{Str::limit($post->title,35,'...')}}</h4>
                            <p class="text-dark d-none js-post-body">{{Str::limit($post->body,120,'...')}}</p>
                            <p>
                                <span class="text-info mr-2">{{$post->user->fullName}}</span>
                                <span class="text-secondary"> {{$post->created_at->diffForHumans()}}</span>
                            </p>
                        </div>
                        <div class="col-md-5">
                            <div class="d-flex mt-1 justify-content-around">
                                <div>
                                    <i class="font-18  uil-eye"></i>
                                    <span class="js-thread-watched">{{$post->watched}}</span>
                                </div>
                                <div>
                                    <i class="font-18  uil-comment"></i>
                                    {{$post->comments->count()}}
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary btn-thread-custom font-12 font-weight-bold">
                                        {{$post->getCourse()}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

        @empty
            <h3>Δεν υπάρχουν σχετικές συνομιλίες <span class="text-info cursor-pointer text-hover-underline" data-toggle="modal" data-target="#new-threads">δημιουργούσε μια!</span></h3>
        @endforelse
        {{ $posts->render() }}

    </ul>

</div>
