@extends('admin.layouts.app')

@section('content')

<div class="max-w-xl mx-auto bg-[#1e293b] p-6 rounded-xl">

    <h2 class="text-xl text-white mb-4">✏️ Edit Selection</h2>

    <form method="POST" action="{{ route('selections.update', $selection->id) }}">
        @csrf
        @method('PUT')

        <!-- STUDENT -->
        <div class="mb-4">
            <label class="text-gray-400">Student</label>
            <select name="student_id"
                class="w-full p-2 bg-[#020617] text-white rounded border border-gray-600">

                @foreach($students as $s)
                    <option value="{{ $s->id }}"
                        {{ $selection->student_id == $s->id ? 'selected' : '' }}>
                        {{ $s->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- PROJECT -->
        <div class="mb-4">
            <label class="text-gray-400">Project</label>
            <select name="project_id"
                class="w-full p-2 bg-[#020617] text-white rounded border border-gray-600">

                @foreach($projects as $p)
                    <option value="{{ $p->id }}"
                        {{ $selection->project_id == $p->id ? 'selected' : '' }}>
                        {{ $p->title }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- PREFERENCE -->
        <div class="mb-4">
            <label class="text-gray-400">Preference Order</label>
            <input type="number" name="preference_order"
                value="{{ $selection->preference_order }}"
                class="w-full p-2 bg-[#020617] text-white rounded border border-gray-600">
        </div>

        <!-- BUTTON -->
        <button class="bg-purple-600 px-4 py-2 rounded text-white w-full">
            Update Selection
        </button>

    </form>

</div>

@endsection