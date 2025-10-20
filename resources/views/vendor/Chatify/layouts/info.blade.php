{{-- user info and avatar --}}
<div class="av-l chatify-d-flex justify-center">
    <img 
    src="{{ Auth::user()->profile?->logo_path 
        ? asset('storage/' . Auth::user()->profile->logo_path) 
        : 'https://via.placeholder.com/80' }}" 
    class="rounded-full w-10 h-10 object-cover"
/>
</div>
<p class="info-name"></p>
<div class="messenger-infoView-btns">
    <a href="#" class="danger delete-conversation">Delete Conversation</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title"><span>Shared Photos</span></p>
    <div class="shared-photos-list"></div>
</div>
