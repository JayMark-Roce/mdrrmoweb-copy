<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MDRRMO-Silang Information System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ✅ External CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Your Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
<<<<<<< HEAD
=======

>>>>>>> 887899e7221396f620d0d6dad872e632d494197b
</head>

<body>

  <!-- Showcase Header -->
  <section class="showcase">
    <div class="logo">
      <img src="{{ asset('image/test.png') }}" alt="MDRRMO Logo">
    </div>
    <div class="text-content">
      <p>THE OFFICIAL WEBSITE OF THE</p>
      <h1>SILANG DISASTER RISK REDUCTION MANAGEMENT OFFICE</h1>
    </div>
  </section>

  <!-- ETO YUNG PANG IMPORT NG NAV -->
  @include('public.partials.navbar')


  <!-- ✅ Carousel Section -->
    <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade custom-carousel" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        @foreach($carousels as $key => $item)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ asset('image/' . $item->image) }}" class="d-block w-100" alt="Carousel Image">
            @if($item->caption)
            <div class="carousel-caption d-none d-md-block">
                <p>{{ $item->caption }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    </div>


  <!-- Mission and Vision Section -->
<section class="section">
  <div class="flex-container-headings">
    <h2>MISSION</h2>
    <h2>VISION</h2>
  </div>
  <div class="flex-container">
    <div class="box">
      <p>{{ $missionVision->mission ?? 'No mission posted yet.' }}</p>
    </div>
    <div class="box">
      <p>{{ $missionVision->vision ?? 'No vision posted yet.' }}</p>
    </div>
  </div>
</section>


  <!-- About -->
<!-- About -->
<section class="section">
  <div class="flex-container-headings">
    <h2>About MDRRMO</h2>
  </div>

  <div class="card-container">
    @foreach ($about as $entry)
      <div class="card">
        @if ($entry->image)
          <img src="{{ asset('image/' . $entry->image) }}" alt="About Image">
        @endif
        <p>{{ $entry->text }}</p>
      </div>
    @endforeach
  </div>
</section>




<!-- Officials -->
<div class="flex-container-headings">
  <h2>Officials</h2>
</div>

<div class="card-container">
  @foreach ($officials as $official)
    <div class="card">
      <img src="{{ asset('image/' . $official->image) }}" alt="{{ $official->name }}">
      <h3>{{ $official->name }}</h3>
      <p>{{ $official->position }}</p>
    </div>
  @endforeach
</div>


<!-- TRAININGS -->
<div class="flex-container-headings">
    <h2>Trainings We Offer</h2>
</div>

<div class="card-container">
    @foreach($trainings as $item)
    <div class="card">
        @if ($item->image)
            <img src="{{ asset('image/' . $item->image) }}" alt="Training Image">
        @endif
        <h3>{{ $item->title }}</h3>
        <p>{{ $item->description }}</p>
    </div>
    @endforeach
</div>


    <!-- Ambulance -->
    <div class="flex-container-headings">
      <h2>Ambulance</h2>
    </div>
    <div class="card-container">
      <div class="card">
        <p>Ambulance Available</p>
        <h1>8</h1>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 MDRRMO-Silang | All Rights Reserved</p>
  </footer>

  <!-- ✅ Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
