<script>
    function confirmation(id, type) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/delete',
                    type: 'POST',
                    data: {
                        push_id: id,
                        push_type: type
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your record has been deleted.",
                            icon: "success"
                        });
                        setInterval(() => {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            }
        });
    }
</script>

<div class="modal fade" tabindex="-1" role="dialog" id="registration">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal">
                <em class="icon ni ni-cross-sm"></em>
            </a>
            <div class="modal-body">
                <h1 class="nk-block-title page-title text-2xl">
                    Register New Account
                </h1>
                <p>You can create new account to monitor your people.</p>
                <hr class="mt-2 mb-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <!-- Name Input -->
                    <div class="form-group">
                        <label for="name">Complete Name</label>
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="Enter your name here.." value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Enter your email address here.." value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Enter your password here..">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation" placeholder="Confirm your password here..">
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Account Type</label>
                        <select required name="account_type" id="account_type" class="form-select">
                            <option value="" selected disabled>-</option>
                            <option value="Administrator">Administrator</option>
                            <option value="Officer">Officer</option>
                        </select>
                        @error('account_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Register</button>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
            -
            <div class="nk-footer-copyright">PNP - Vechicle Impounding Records &copy; 2024 <a href="https://tcc.edu.ph/"
                    target="_blank" style="color: #b4543d"></a> ❤️ All Rights Reserved.</div>

        </div>
    </div>
</div>
