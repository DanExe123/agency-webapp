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

<body class="font-sans antialiased bg-gray-50">

  <!-- Navbar -->
  <header class="bg-white shadow-sm relative py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        
        <!-- Left: Icon + Title -->
        <div class="flex items-center gap-2">
          <x-phosphor.icons::regular.briefcase class="w-8 h-8 text-gray-600" />
          <h1 class="font-bold text-2xl text-gray-700">ESecurityJobs</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- Login Section -->
  <main class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 space-y-6">
      

      <!-- Livewire Login Form -->
      @livewire('auth.login')

    </div>
  </main>

</body>
</html>
