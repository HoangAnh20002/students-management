@php
    use App\Enums\Base;
@endphp
<div class="bg-secondary">
    <div class="text-right" style="height: 80px">
        <div class="text-right">
            <div class="mr-4 text-white pt-2">
                @if($role == Base::ADMIN)
                    Admin
                @else
                    Student
            </div>
            @endif
        </div>
        <div>
            <button type="button" class="btn mr-2 text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Logout
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
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
                            <a type="button" class="btn btn-primary " href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

