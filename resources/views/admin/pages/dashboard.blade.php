@extends('admin.layouts.app')

@section('content')

<h2>Welcome Admin 👨‍💼</h2>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px;">
    
    <div style="background:#e2e8f0;padding:20px;border-radius:10px;">
        <h3>Students</h3>
    </div>

    <div style="background:#e2e8f0;padding:20px;border-radius:10px;">
        <h3>Professors</h3>
    </div>

    <div style="background:#e2e8f0;padding:20px;border-radius:10px;">
        <h3>Projects</h3>
    </div>

</div>

@endsection