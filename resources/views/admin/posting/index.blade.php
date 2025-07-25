<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-blue-700">
            📝 Admin Posting Page
        </h2>
    </x-slot>

    <div class="grid gap-6 p-6 bg-white rounded shadow">

        {{-- ✅ Carousel Upload --}}
        <div class="border p-4 rounded">
            <h3 class="text-xl font-semibold mb-2 text-purple-700">🎠 Carousel</h3>
            <form action="{{ url('/admin/posting/carousel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="block">Image</label>
                    <input type="file" name="image" class="border p-2 w-full">
                </div>
                <div class="mb-2">
                    <label class="block">Caption (optional)</label>
                    <input type="text" name="caption" class="border p-2 w-full">
                </div>
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">Upload</button>
            </form>
        </div>

        {{-- ✅ Mission and Vision --}}
        <div class="border p-4 rounded">
            <h3 class="text-xl font-semibold mb-2 text-green-700">🎯 Mission & Vision</h3>
            <form action="{{ url('/admin/posting/mission-vision') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="block">Mission</label>
                    <textarea name="mission" class="border p-2 w-full" rows="2"></textarea>
                </div>
                <div class="mb-2">
                    <label class="block">Vision</label>
                    <textarea name="vision" class="border p-2 w-full" rows="2"></textarea>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
            </form>
        </div>

        {{-- ✅ About MDRRMO --}}
        <div class="border p-4 rounded">
            <h3 class="text-xl font-semibold mb-2 text-blue-700">📘 About MDRRMO</h3>
            <form action="{{ url('/admin/posting/about') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="block">Description</label>
                    <textarea name="text" class="border p-2 w-full" rows="3"></textarea>
                </div>
                <div class="mb-2">
                    <label class="block">Image (optional)</label>
                    <input type="file" name="image" class="border p-2 w-full">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Post</button>
            </form>
        </div>


        {{-- ✅ Officials --}}
        <div class="border p-4 rounded">
            <h3 class="text-xl font-semibold mb-2 text-pink-700">👨‍💼 Officials</h3>
            <form action="{{ url('/admin/posting/officials') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="block">Name</label>
                    <input type="text" name="name" class="border p-2 w-full" required>
                </div>
                <div class="mb-2">
                    <label class="block">Position</label>
                    <input type="text" name="position" class="border p-2 w-full" required>
                </div>
                <div class="mb-2">
                    <label class="block">Image (optional)</label>
                    <input type="file" name="image" class="border p-2 w-full">
                </div>
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded">Add Official</button>
            </form>
        </div>


        <!-- TRAINING -->
        <div class="mb-4">
    <h3>Post New Training</h3>
    <form action="/admin/posting/trainings" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-2">
            <label for="image">Upload Image:</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Post Training</button>
    </form>
</div>


    </div>
</x-app-layout>
