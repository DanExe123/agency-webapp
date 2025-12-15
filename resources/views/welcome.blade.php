<!DOCTYPE html>
<html lang="en" x-data="{ openMenu: false }" class="bg-gray-50">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agency</title>
  <script src="https://unpkg.com/feather-icons"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<style>
  /* Hide scrollbar for Chrome, Safari and Opera */
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge */
.scrollbar-hide {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;     /* Firefox */
}
</style>

<body class="font-sans antialiased">

  <!-- Navbar -->
  @include('partials.first-header.first-nav')
  @include('partials.first-header.second-nav')
  <!-- Hero Section -->
  @include('partials.first-section')
 <!-- Most Popular Agencies Section -->
  @include('partials.second-section')
  <!-- Most Popular Agencies Section -->
  @include('partials.third-section')
<!-- company post Section -->
  @include('partials.fourth-section')
  <hr>
<!--  yudipotaa Section -->
  @include('partials.subscription')
  <!-- footer Section -->
  @include('partials.footer')

  <script>
    AOS.init();
  </script>

</body>
</html>
