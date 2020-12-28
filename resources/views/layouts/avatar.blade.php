<div class="profile-image">
    <img src="{{ asset('avatar/' . Auth::user()->avatar) }}" alt="">
    <button  type="button" class="btn btn-changeavt" data-toggle="modal" id="edit-avatar" data-target="#modalUploadProfile">
        <i  class="fas fa-camera"></i>
    </button>
    <div class="modal fade" id="modalUploadProfile" tabindex="-1" role="dialog" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.upload_avatar', Auth::user()->id ) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('profile.upload_avatart') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="alert-require">(*)</span>
                            &nbsp; 
                        <input type="file" name="avatarFile" id="profile-image">
                        @error('avatarFile')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <img id="preview-img" src="" class="previewImage" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">{{ trans('profile.close') }}</button>
                        <button type="submit" class="btn btn-primary btn-submit">{{ trans('profile.save_change') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
