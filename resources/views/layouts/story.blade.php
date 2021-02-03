<div class="card">
    <div class="card-body d-flex justify-content-start">
        <ul class="list-story-in-timeline list-unstyled mb-0">
            <li class="list-inline-item">
                <button class="btn p-0 m-0 btn-lg"  data-toggle="modal" data-target="#myModal">
                    <div class="d-flex flex-column align-items-center">
                        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border border-danger story-profile-photo">
                            <img src="{{ config('img.img_add_story') }}" alt="..."  class="avatar-user-in-list-story avtUser">
                        </div>
                        <small class="username-story">{{ trans('timeline.add_story') }}</small>
                    </div>
                </button>
            </li>
            @foreach ($stories as $item)
                <li class="list-inline-item">
                    <button class="btn p-0 m-0">
                        <div class="d-flex flex-column align-items-center">
                            <div
                                class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center border border-danger story-profile-photo">
                                <img class="avatar-user-in-list-story" src="{{ asset(config('url.url_avatar') . $item->user->avatar) }}" alt="...">
                            </div>
                            <small class="username-story">{{ $item->user->username }}</small>
                        </div>
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('timeline.add_story') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create.story') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <span>{{ trans('timeline.status') }}</span>
                            <input class="form-control" type="text" name="content">
                        </div>
                        <br>
                        <div class="form-group">
                            <span>{{ trans('timeline.image') }}</span>
                            <input type="file" class="form-control-file" name="imageStory" required>
                        </div>
                        <button class="btn btn-submit-story" type="submit">{{ trans('timeline.post') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
