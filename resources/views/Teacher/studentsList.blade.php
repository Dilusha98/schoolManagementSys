@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'teacher')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('Teacher.Tlayout')

@section('title')
    Students List
@endsection

@section('content')
    <div class="container">
        <h1>Students List - 8A</h1>
        <div class="table-responsive text-nowrap mt-3 mb-3">
            <table class="table table-hover mb-10" id="studentsListTable">
                <thead style="text-align: center">
                    <tr class="table-primary">
                        <th>Student</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody id="studentTbody" class="table-border-bottom-0" style="text-align: center">
                    @if ($studentLists !== null && count($studentLists) > 0)
                        @foreach ($studentLists as $student)
                            <tr>
                                <td>{{ $student->studentFullName }}</td>
                                <td><button class="btn btn-outline-primary" value="{{ $student->id }}">view</button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            viewStudents();

            function viewStudents() {
                let teacherID = $('#teacherID').val();

                $.ajax({
                    type: "get",
                    url: "/getStudentsList/" + teacherID,
                    success: function(res) {
                        console.log(res);
                    }
                });
            }

            $('#studentsListTable').DataTable({
                paging: true, // Enable pagination
                pageLength: 5, // Number of records per page
                lengthMenu: [10, 20, 30, 40], // Page length options
                //lengthChange: false,
                //searching: false, 
                language: {
                    // Custom text for pagination controls
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: '<i class="bx bx-chevron-right"></i>',
                        previous: '<i class="bx bx-chevron-left"></i>'
                    }
                }
            });
        });
    </script>
@endsection
