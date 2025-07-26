@extends('layouts.admin')

@section('title', 'Admin Posting')

@section('content')

@includeIf('admin.partials.navbar')

<div class="grid gap-6 p-6 bg-white rounded shadow">

   <!-- Ambulance Billing Table -->
<div class="mt-10 bg-white shadow rounded p-6">
    <h3 class="text-2xl font-bold text-green-700 mb-4">🚑 Ambulance Billing Records</h3>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">#</th>
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Address</th>
                <th class="p-2 border">Service Type</th>
                <th class="p-2 border">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($billings as $billing)
                <tr>
                    <td class="p-2 border">{{ $loop->iteration }}</td>
                    <td class="p-2 border">{{ $billing->name }}</td>
                    <td class="p-2 border">{{ $billing->address }}</td>
                    <td class="p-2 border">{{ $billing->service_type }}</td>
                    <td class="p-2 border">{{ $billing->created_at->format('F j, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
