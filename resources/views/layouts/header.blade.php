<div class="row bg-primary" style="height: 80px">
        <div class="col-3 text-center my-auto" style="font-size: 25px;">
            <a class="text-white" @if($role == '1') href="{{ route('adminMain') }}" @elseif($role == '0') href="{{ route('studentMain') }}" @endif>Apple University</a>
        </div>
        <div class="col-6 text-white text-right"style="height: 80px">
            <div class="text-right mt-3">
                @if($role == '1')
            <div>
                Admin
            @else
             Student
            </div>
             @endif
                <div><a class="text-white text-right" href="{{ route('logout') }}">Logout</a></div>
            </div>
        </div>
</div>

