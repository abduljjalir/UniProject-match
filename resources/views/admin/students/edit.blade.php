@extends('admin.layouts.app')

@section('content')

<h2>Edit Student</h2>

<form method="POST" action="{{ route('students.update', $student->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $student->name }}"><br><br>
    <input type="text" name="student_id" value="{{ $student->student_id }}"><br><br>
    <input type="number" step="0.01" name="cgpa" value="{{ $student->cgpa }}"><br><br>

    <select name="speciality_id">
        @foreach($specialities as $s)
            <option value="{{ $s->id }}" {{ $student->speciality_id == $s->id ? 'selected' : '' }}>
                {{ $s->name }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Update</button>
</form>

@endsection