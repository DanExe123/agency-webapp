<x-layouts.app :title="__('Company')">
   
    <div class="min-h-screen bg-white" x-data="{ openFilter: true }">

       @livewire('companies')
    </div>
    
</x-layouts.app>
