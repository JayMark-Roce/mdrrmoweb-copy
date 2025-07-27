HTML
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- ✅ Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/stylish.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Vite for Tailwind/JS if needed -->

</head>
<body>
<!-- Toggle Button for Mobile -->
<button class="toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

    <!-- Sidenav -->
    <aside class="sidenav" id="sidenav">
    <div class="logo-container">
        <img src="{{ asset('image/mdrrmologo.jpg') }}" alt="Logo" class="logo-img">
    </div>
    <nav class="nav-links">
        <a href="#carousel"><i class="fas fa-chart-pie"></i> Dashboard</a>
        <a href="#mission-vision"><i class="fas fa-pen"></i> Posting</a>
        <a href="#about"><i class="fas fa-car"></i> Drivers</a>
        <div class="logout-form">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </nav>
</aside>


    <!-- Fixed Top Header -->
   <!-- ✅ Fixed Top Header -->
<div class="mdrrmo-header" style="border: 2px solid #031273;">
    <h2 class="header-title">SILANG MDRRMO</h2>

</div>


    <!-- Main content (with padding top to not hide under fixed header) -->
    <main class="main-content pt-24">

        {{-- Carousel --}}
        <div id="carousel" class="grid gap-6 p-6 rounded shadow mb-8">
            <div class="border p-4 rounded">
                <h3 class="section-title"><i class="fas fa-images"></i> Carousel</h3>
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
                    <div class="text-center">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca;">
                            <i class="fas fa-upload mr-2"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Mission & Vision --}}
        <div id="mission-vision" class="grid gap-6 p-6 rounded shadow mb-8">
            <div class="border p-4 rounded">
                <h3 class="section-title"><i class="fas fa-bullseye"></i> Mission & Vision</h3>
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
                    <div class="text-center">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca;">
                            <i class="fas fa-save mr-2"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- About --}}
        <div id="about" class="grid gap-6 p-6 rounded shadow mb-8">
            <div class="border p-4 rounded">
                <h3 class="section-title"><i class="fas fa-book"></i> About MDRRMO</h3>
                <form action="{{ url('/admin/posting/about') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="block mb-1">Description</label>

                        <textarea name="text" class="border p-2 w-full" rows="3"></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="block">Image (optional)</label>
                        <input type="file" name="image" class="border p-2 w-full">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca;">
                            <i class="fas fa-paper-plane mr-2"></i> Post
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Officials --}}
        <div class="grid gap-6 p-6 rounded shadow mb-8">
            <div class="border p-4 rounded">
                <h3 class="section-title"><i class="fas fa-user-tie"></i> Officials</h3>
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
                    <div class="text-center">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca;">
                            <i class="fas fa-user-plus mr-2"></i> Add Official
                        </button>
                    </div>
                </form>
            </div>
        </div>
      

        {{-- Training --}}
        <div class="grid gap-6 p-6 rounded shadow mb-8">
            <div class="border p-4 rounded">
                <h3 class="section-title"><i class="fas fa-chalkboard-teacher"></i> Post New Training</h3>
                <form action="/admin/posting/trainings" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="block">Title</label>
                        <input type="text" name="title" class="border p-2 w-full" required>
                    </div>
                    <div class="mb-2">
                        <label class="block">Description</label>
                        <textarea name="description" class="border p-2 w-full" rows="3" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="block">Upload Image</label>
                        <input type="file" name="image" class="border p-2 w-full">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-white px-4 py-2 rounded" style="width: 170px; background-color: #4338ca;">
                            <i class="fas fa-dumbbell mr-2"></i> Post Training
                        </button>
                    </div>
                </form>
            </div>
        </div>
<hr class="my-divider"> 
    </main>
<script>
    function toggleSidebar() {
        const sidenav = document.querySelector('.sidenav');
        sidenav.classList.toggle('active');
    }
</script>

</body>
</html>
