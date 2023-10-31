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
    Reports
@endsection

@section('content')
    <div class="card">
        <input type="text" id="subid" hidden>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semOne" aria-controls="navs-top-semOne" aria-selected="true">Semester
                    One</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semTwo" aria-controls="navs-top-semTwo" aria-selected="false">Semester
                    Two</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semThee" aria-controls="navs-top-semThee" aria-selected="false">Semester
                    Three</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-semOne" role="tabpanel">
                <div class="container">
                    @foreach ($studentLists as $st)
                    <div class="row">
                        <div class="col-md-4 mb-3 mt-2">
                            <label for="">{{$st->studentFullName}}</label>
                            <button class="btn btn-primary veiwReport" value="{{$st->id}}">View</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="navs-top-semTwo" role="tabpanel">
                <h4>2nd sem</h4>
            </div>
            <div class="tab-pane fade" id="navs-top-semThee" role="tabpanel">
                <h4>3rd sem</h4>
            </div>
        </div>
    </div>


      {{-- student report model --}}
      <div class="modal fade" id="studentreportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Report Details</h5>
                    <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                </div>
                <div class="container">
                    <button id="printButton" class="btn btn-secondary">Print</button>
                    <hr>
                </div>
                <div class="modal-body" id="reprtBody">
                    <div class="row" id="subMarks">

                    </div>
                    <div class="row" id="summery">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        
        $(document).ready(function () {
            
            $(document).on('click','.veiwReport',function (e) {
                e.preventDefault();
                var id = $(this).val();
                
                $.ajax({
                    type: "get",
                    url: "/generateReport/1/"+id,
                    success: function (res) {

                        var reprtBdy ='';

                        for (let i = 0; i < res.marks.length; i++) {
                            reprtBdy +='<div class="row">\
                                    <p>'+ res.marks[i].subjectName +' - '+ res.marks[i].marks +'</p>\
                                </div>';
                        }

                        var summery = '<div class="row">\
                                <p><b>Total - '+ res.totalMarks +'</b></p>\
                                <p><b>Avarage - '+ res.averageMarks +' </b></p>\
                                <p><b>Rank - '+ res.rank +' </b></p>\
                                <p><b>Total students - {{ count($studentLists) }} </b></p>\
                            </div>'
                        $('#subMarks').html(reprtBdy);
                        $('#summery').html(summery);

                        $('#studentreportModal').modal('show');
                        console.log(res);
                    }
                });

            });

        });

    </script>
@endsection