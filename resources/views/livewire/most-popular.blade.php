<div>
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-duration="2000">
        
        @foreach($posts as $post)
        <div class="space-y-1">
            <h3 class="font-semibold text-gray-900">{{ $post->name }}</h3>
            <p class="text-sm text-gray-600 truncate">{{ $post->description }}</p>
            <p class="text-sm text-gray-500">Location: {{ $post->location }}</p>
        </div>
        @endforeach

    </div>
</div>
