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

<style>
    .dataTables_wrapper .dt-buttons {
        float: right;
    }

    .no-print {
        display: none;
    }
</style>

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
                        <th class="exclude">View</th>
                    </tr>
                </thead>
                <tbody id="studentTbody" class="table-border-bottom-0" style="text-align: center">
                    @if ($studentLists !== null && count($studentLists) > 0)
                        @foreach ($studentLists as $student)
                            <tr>
                                <td>{{ $student->studentFullName }}</td>
                                <td><button class="btn btn-outline-primary" value="{{ $student->id }}"
                                        id="viewStudentBtn">view</button></td>
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
    {{-- student view model --}}
    <div class="modal fade" id="studentDtailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Student Details</h5>
                    <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                </div>
                <div class="container">
                    <button id="printButton" class="btn btn-secondary">Print</button>
                    <hr>
                </div>
                <div class="modal-body">
                    <input type="text" id="studentID" hidden>
                    <div class="container"id="studenDetailsMoalPrintDiv">
                        <label for="">Student full name</label>
                        <input type="text" id="stFullNamne" disabled class="form-control">
                        <label for="">student birthday</label>
                        <input type="text" id="stBirthDay" disabled class="form-control">
                        <label for="">student gender</label>
                        <input type="text" id="stGender" disabled class="form-control">
                        <label for="">Student Nationality</label>
                        <input type="text" id="stNationality" disabled class="form-control">
                        <label for="">Guardian full name</label>
                        <input type="text" id="gdFname" disabled class="form-control">
                        <label for="">Guardian occupation</label>
                        <input type="text" id="gdOccupation" disabled class="form-control">
                        <label for="">Guardian NIC</label>
                        <input type="text" id="gdNic" disabled class="form-control">
                        <label for="">Address</label>
                        <input type="text" id="gdAddress" disabled class="form-control">
                        <label for="">Postal code</label>
                        <input type="text" id="gdPostalCode" disabled class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function() {

            $('#studentsListTable').DataTable({
                paging: true,
                pageLength: 5,
                lengthMenu: [10, 20, 30, 40],
                lengthChange: false,
                // searching: false, 
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(.exclude)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(.exclude)'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(.exclude)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(.exclude)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(.exclude)'
                        }
                    }
                ],
                language: {
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: '<i class="bx bx-chevron-right"></i>',
                        previous: '<i class="bx bx-chevron-left"></i>'
                    }
                }
            });

            $(document).on('click', '#viewStudentBtn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                $('#studentID').val(id);
                $('#studentDtailsModal').modal('show');

                $.ajax({
                    type: "get",
                    url: "/studentDetails/" + id,
                    success: function(res) {
                        // console.log(res);
                        // console.log(res[0].studentFullName);
                        $('#stFullNamne').val(res[0].studentFullName);
                        $('#stBirthDay').val(res[0].studentBirthday);
                        $('#stGender').val(res[0].studentGender);
                        $('#stNationality').val(res[0].studentNationality);
                        $('#gdFname').val(res[0].guardianFullName);
                        $('#gdOccupation').val(res[0].guardianOccupation);
                        $('#gdNic').val(res[0].guardianNIC);
                        $('#gdAddress').val(res[0].guardianAddress);
                        $('#gdPostalCode').val(res[0].guardianPostalCode);
                    }
                });

            });


            document.getElementById('printButton').addEventListener('click', function() {
                // Get the values from the input fields
                var stFullNamne = document.getElementById('stFullNamne').value;
                var birthdat = $('#stBirthDay').val();
                var gender = $('#stGender').val();
                var nationality = $('#stNationality').val();
                var guardian = $('#gdFname').val();
                var occupation = $('#gdOccupation').val();
                var nic = $('#gdNic').val();
                var address = $('#gdAddress').val();
                var postalcode = $('#gdPostalCode').val();

                var elementsToHide = document.querySelectorAll('.no-print');
                elementsToHide.forEach(function(element) {
                    element.style.display = 'none';
                });

                var printWindow = window.open('', '', 'width=600,height=600');
                printWindow.document.open();
                printWindow.document.write('<html><head><title>Print</title></head><body>');

                // Add the content to print
                printWindow.document.write('<div><h2>' + stFullNamne + '</h2>');
                printWindow.document.write('<p>Student Full Name: ' + stFullNamne + '</p>');
                printWindow.document.write('<p>Student Student Bithday: ' + birthdat + '</p>');
                printWindow.document.write('<p>Student Student Gender: ' + gender + '</p>');
                printWindow.document.write('<p>Student Student Nationality: ' + nationality + '</p>');
                printWindow.document.write('<p>Student Guardian: ' + guardian + '</p>');
                printWindow.document.write('<p>Student Guardian Occupation: ' + occupation + '</p>');
                printWindow.document.write('<p>Student Guardian NIC: ' + nic + '</p>');
                printWindow.document.write('<p>Student Guardian Address: ' + address + '</p>');
                printWindow.document.write('<p>Student Guardian Postal Code: ' + postalcode + '</p>');
                printWindow.document.write('</div>');

                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.print();
                printWindow.close();

                elementsToHide.forEach(function(element) {
                    element.style.display = '';
                });
            });



        });
    </script>
@endsection
