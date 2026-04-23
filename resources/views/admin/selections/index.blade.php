@extends('admin.layouts.app')

@section('content')

<div class="bg-[#1e293b] p-6 rounded-xl">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl text-white">📌 Selections</h2>

        <a href="{{ route('selections.create') }}"
           class="bg-purple-600 px-4 py-2 rounded text-white hover:bg-purple-700">
           + Add Selection
        </a>
    </div>

    <table class="w-full text-left border-collapse">

        <thead>
            <tr class="text-gray-400 border-b border-gray-700">
                <th class="p-2">Student</th>
                <th class="p-2">Project</th>
                <th class="p-2">Preference</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse($selections as $selection)
                <tr class="border-b border-gray-800 hover:bg-[#020617]">

                    <td class="p-2 text-white">
                        {{ $selection->student->name ?? 'N/A' }}
                    </td>

                    <td class="p-2 text-gray-300">
                        {{ $selection->project->title ?? 'N/A' }}
                    </td>

                    <td class="p-2 text-purple-400">
                        #{{ $selection->preference_order }}
                    </td>

                    <td class="p-2 flex gap-2">

                        <a href="{{ route('selections.edit', $selection->id) }}"
                           class="bg-blue-600 px-3 py-1 rounded text-white hover:bg-blue-700">
                           Edit
                        </a>

                        <form action="{{ route('selections.destroy', $selection->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 px-3 py-1 rounded text-white hover:bg-red-700">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-400 p-4">
                        No selections found
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection

