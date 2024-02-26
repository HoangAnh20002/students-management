@php
    use App\Enums\Base;
@endphp
<div class="bg-dark h-100">
    <div class="border border-white p-3">
        <div class="col-3 text-center my-auto fs-3" style=" padding-right: 100px;">
            <a class="text-decoration-none text-white fw-semibold"
               @if($role == Base::ADMIN) href="{{ route('adminMain') }}"
               @elseif($role == Base::STUDENT) href="{{ route('studentMain') }}" @endif>Apple University</a>
        </div>
    </div>
    <div class="border border-white p-3">
        <a href="{{ route('department.index') }}" class="text-decoration-none text-white">Department</a>
    </div>


    <div class="border border-white p-3">
        <a href="#" class="text-decoration-none text-white">Student</a>
    </div>
    <div class="border border-white p-3">
        <a href="{{route('course.index')}}" class="text-decoration-none text-white">Course</a>
    </div>
    <div class="border border-white p-3">
        <a href="#" class="text-decoration-none text-white">Result</a>
    </div>
</div>

