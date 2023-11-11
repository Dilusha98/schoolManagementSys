@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'admin')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('layout')

@section('title')
    Reports
@endsection

@section('content')
    <div class=" mt-4">
        <button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#StudentWiseReport">Student wise Report</button>
        <button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SubjectReport">Subject wise Report</button>
    </div>



        {{-- Subject wise current Year report modal --}}
        <div class="modal fade" id="SubjectReport" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Subject Report - {{ now()->format('Y-m-d') }}</h5>
                        <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                    </div>
                    <div class="container">
                        <hr>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive text-nowrap mt-3 mb-3">
                            <table class="table table-hover mb-10">
                                <thead>
                                    <tr>
                                        <td>Subject</td>
                                        <td>Previous year</td>
                                        <td>Current year</td>
                                    </tr>
                                    <tbody>
                                        @foreach ($subjectReport as $data)
                                            <tr>
                                                <td>{{$data->subject}}</td>
                                                <td>{{number_format($data->previous_year_average_marks, 2)}}</td>
                                                <td>{{number_format($data->current_year_average_marks, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="container">
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="PrintSubjectReport" class="btn btn-primary">Print</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Student wise current Year report modal --}}
        <div class="modal fade" id="StudentWiseReport" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle2">Student Report - {{ now()->format('Y-m-d') }}</h5>
                        <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                    </div>
                    <div class="container">
                        <hr>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-control">
                                        <option value="" selected>-Select-</option>
                                        @for ($year = date("Y"); $year >= 2015; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="Subjects">Subjects</label>
                                    <select name="Subjects" id="Subjects" class="form-control">
                                        <option value="" selected>-Select-</option>
                                        @foreach ($subjects as $data)
                                            <option value="{{$data->id}}">{{$data->subject}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="From">From</label>
                                            <select name="From" id="From" class="form-control">
                                                @for ($i = 0; $i <= 99; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="To">To</label>
                                            <select name="To" id="To" class="form-control">
                                                @for ($i = 2; $i <= 100; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="table-responsive text-nowrap mt-3 mb-3">
                                <table class="table table-hover mb-10">
                                    <thead>
                                        <td>Student Name</td>
                                        <td>Grade</td>
                                        <td>Class</td>
                                        <td>Stream</td>
                                        <td>Mdium</td>
                                        <td>Average</td>
                                    </thead>
                                    <tbody>
                                    @foreach ($studentAvgReport as $data)
                                        <tr>
                                            <td>{{$data->studentFullName}}</td>
                                            <td>{{$data->grade}}</td>
                                            <td>{{$data->class}}</td>
                                            <td>{{$data->stream}}</td>
                                            <td>{{$data->medium}}</td>
                                            <td>{{number_format($data->average_marks,2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="PrintSubjectReport" class="btn btn-primary">Print</button>
                    </div>
                </div>
            </div>
        </div>
@endsection