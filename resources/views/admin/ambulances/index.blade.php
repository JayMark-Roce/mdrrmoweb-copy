@extends('layouts.admin')

@section('title', 'Manage Ambulances')

@section('content')
@includeIf('admin.partials.navbar')

<div class="container p-4">
    <h2 class="text-2xl font-bold mb-4">🚑 Add Ambulance</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ambulances.store') }}" method="POST" class="bg-white p-4 rounded shadow mb-6">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="Available">Available</option>
                <option value="Out">Out</option>
                <option value="Unavailable">Unavailable</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Ambulance</button>
    </form>

    <h3 class="text-xl font-semibold mb-2">📋 Existing Ambulances</h3>
    <table class="w-full text-sm border bg-white shadow rounded">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600 border-b">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ambulances as $amb)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $amb->name }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-white 
                            @if($amb->status === 'Available') bg-green-500 
                            @elseif($amb->status === 'Out') bg-yellow-500 
                            @else bg-red-500 
                            @endif">
                            {{ $amb->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center py-4">No ambulances yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
