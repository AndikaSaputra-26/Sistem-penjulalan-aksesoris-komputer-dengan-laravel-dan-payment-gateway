<div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('editProfile', auth()->user()->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Nama</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="
                                                    exampleFormControlInput1" type="text"
                            value="{{ old('name') ? old('name') : auth()->user()->name }}" placeholder="Nama" name="name"
                            autocomplete="off">
                        @error('name')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="
                                                    exampleFormControlInput1" type="email"
                            value="{{ old('email') ? old('email') : auth()->user()->email }}" placeholder="Email" name="email"
                            autocomplete="off">
                        @error('email')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="
                                                    exampleFormControlInput1" type="password"
                            value="{{ old('password') }}" placeholder="Password" name="password">
                        <span style="color: red">*kosongkan jika tidak ingin merubah password</span>
                        @error('password')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Konfirmasi Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="
                                                    exampleFormControlInput1" type="password"
                            value="{{ old('password_confirmation') }}" placeholder="Konfirmasi Password"
                            name="password_confirmation">
                        @error('password')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" >Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
