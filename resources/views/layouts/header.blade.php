<div class="row border border-bottom-2" style="height: 80px">
        <div class="col-3 text-center my-auto" style="font-size: 25px; padding-right: 100px;">
            <a class="text-decoration-none text-dark fw-semibold" @if($role == '1') href="{{ route('adminMain') }}" @elseif($role == '0') href="{{ route('studentMain') }}" @endif>Apple University</a>
        </div>
        <div class="col-8 text-right"style="height: 80px">
            <div class="text-right mt-3">
                @if($role == '1')
                <div class="mr-3">
                    Admin
                @else
                 Student
                </div>
             @endif
            </div>
            <div>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Logout
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                Are you sure you want to log out ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary href="{{ route('logout') }}"">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>

