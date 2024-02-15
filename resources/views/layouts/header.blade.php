<div class="row bg-primary" style="height: 80px">
        <div class="col-3 text-center text-white my-auto" style="font-size: 25px;">
            Apple University
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

