@php
    use App\Enums\Base;
@endphp
@extends('layouts.home')
@section('content')
    @if($role == Base::ADMIN)
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('resultDetail', ['result' => $student->id])}}
    @else
        {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('detail', ['result' => $student->id])}}
    @endif

    <div id="message" class="p-3" style="display: none;"></div>
    <h2 class="text-center mt-3">Result Detail</h2>
    @if($role == Base::ADMIN)<button id="updateButton" class="btn btn-primary float-right mt-3 mr-5 mb-5" type="button">Update</button>@endif
        <table class="table mt-3">
        <thead>
        <tr>
            <th>Course</th>
            <th>Result Edit</th>
        </tr>
        </thead>
        <tbody>
        <tbody>
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->course->name }}</td>
                    <td>
                        <input hidden name="result_ids[]" value="{{ $result->id }}">
                        @if($role == Base::ADMIN)
                            <input class="form-control w-25" type="number" name="marks[]" min="0" max="10" step="any" value="{{ $result->mark }}">
                        @elseif($role == Base::STUDENT)
                            <label>{{ $result->mark }}</label>
                        @endif
                    </td>
                </tr>
            @endforeach

            @foreach($notRegisteredCourses as $course)
            <tr>
                <td>{{ $course }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>

    </table>
    <script>
        $(document).ready(function() {
            $('#updateButton').click(function() {
                let resultIds = $('[name="result_ids[]"]').map(function() {
                    return $(this).val();
                }).get();
                let marks = $('[name="marks[]"]').map(function() {
                    return $(this).val();
                }).get();
                $.ajax({
                    url: "{{ route('result.update', $student->id) }}",
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        result_ids: resultIds,
                        marks: marks
                    },
                    success: function(response) {
                        console.log(response.request);
                        $("#message").removeClass("alert-danger").addClass("alert-success").text(response.message).show();
                    },
                    error: function(xhr) {
                        let errorMessage = JSON.parse(xhr.responseText).message;
                        $("#message").removeClass("alert-success").addClass("alert-danger").text(errorMessage).show();
                    }
                });
            });
        });
    </script>
    @push('ajax')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @endpush
@endsection



