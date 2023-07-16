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
    Teacher Dashboard
@endsection

@section('content')
    <h1>Teacher</h1>
@endsection

@section('script')

<script>
    console.log('hi');
</script>
    
@endsection