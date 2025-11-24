<!DOCTYPE html>
<html lang="en" x-data="{ openMenu: false }" class="bg-gray-50">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @role('Agency')
  <title>Agency | Account</title>
  @endrole
  @role('Company')
  <title>Company | Account</title>
  @endrole
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
  

  {{-- Only show this layout if user has any of these roles --}}
  @hasanyrole('Admin|Agency|Company')
    
    <!-- Navbar -->
    @include('partials.first-header.first-nav')
    @include('partials.first-header.second-nav')

    <!-- Hero Section -->
    @include('partials.first-section')

    <!-- Most Popular Agencies Section -->
    @role('Company')
      @include('partials.second-section')
    @endrole

    @include('partials.third-section')

    @role('Agency')
    <!-- Company post Section -->
      @include('partials.fourth-section')
    @endrole

    @role('Company')
      @include('partials.fifth-section')
    @endrole

    <!-- Footer Section -->
    @include('partials.footer')

  @else
    <div class="text-center p-6">
      <h2 class="text-xl font-bold text-red-600">Unauthorized</h2>
      <p>You don’t have permission to view this page.</p>
    </div>
  @endhasanyrole

  <script>
    AOS.init();
  </script>
</body>
</html>
