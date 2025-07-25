@extends('layouts.admin')

@section('title', 'Manage Drivers')

@section('content')
@includeIf('admin.partials.navbar')

<div class="container p-4">
    <h2 class="text-2xl font-bold mb-4">👨‍✈️ Create New Driver</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.drivers.store') }}" method="POST" class="bg-white p-4 rounded shadow mb-6">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-3">
            <label>Assign Ambulance:</label>
        <select name="ambulance_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Select Ambulance --</option>
            @foreach($ambulances as $amb)
                <option value="{{ $amb->id }}">{{ $amb->name }}</option>
            @endforeach
        </select>

        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Driver</button>
    </form>

    <h3 class="text-xl font-semibold mb-2">📋 Existing Drivers</h3>
    <table class="w-full text-sm border bg-white shadow rounded">
        <thead class="bg-gray-100 text-xs uppercase text-gray-600 border-b">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Ambulance</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($drivers as $driver)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $driver->name }}</td>
                    <td class="px-4 py-2">{{ $driver->email }}</td>
                    <td class="px-4 py-2">
                        {{ $driver->ambulance->name ?? 'Unassigned' }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center py-4">No drivers yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
