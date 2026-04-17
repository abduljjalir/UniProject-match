@extends('admin.layouts.app')

@section('content')

<h2>Students</h2>

<a href="{{ route('students.create') }}">+ Add Student</a>

<table border="1" cellpadding="10" style="margin-top:20px;width:100%;">
    <tr>
        <th>Name</th>
        <th>Student ID</th>
        <th>CGPA</th>
        <th>Speciality</th>
        <th>Actions</th>
    </tr>

    @foreach($students as $student)
    <tr>
        <td>{{ $student->name }}</td>
        <td>{{ $student->student_id }}</td>
        <td>{{ $student->cgpa }}</td>
        <td>{{ $student->speciality->name ?? '' }}</td>

        <td>
            <a href="{{ route('students.edit', $student->id) }}">Edit</a>

            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>

@endsection