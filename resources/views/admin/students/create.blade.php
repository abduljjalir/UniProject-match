@extends('admin.layouts.app')

@section('content')

<h2>Add Student</h2>

<form method="POST" action="{{ route('students.store') }}">
    @csrf

    <input type="text" name="name" placeholder="Name"><br><br>
    <input type="text" name="student_id" placeholder="Student ID"><br><br>
    <input type="number" step="0.01" name="cgpa" placeholder="CGPA"><br><br>

    <select name="speciality_id">
        @foreach($specialities as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
        @endforeach
    </select><br><br>

    <button type="submit">Save</button>
</form>

@endsection
