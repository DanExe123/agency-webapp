<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('icon/avatar-people-user-profile-man-boy-cap-young-512.webp') }}">


        <title>Agency Chat App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
        <script src="https://kit.fontawesome.com/YOUR_KIT_ID.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <header class="bg-white shadow-sm relative py-4">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Icon + Search with Flag -->
            <div class="flex items-center space-x-3">
                <!-- Icon -->
                <div class="flex gap-1 justify-start">
                    <x-phosphor.icons::regular.briefcase class="w-6 h-6 text-gray-600" />
                    <h1 class="font-bold text-gray-700">ESecurityJobs</h1>
                </div>

                <!-- Search Box with Flag Selector -->
                <div class="relative flex items-center border border-gray-300 rounded-md overflow-hidden">
                    <!-- Flag Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center px-2 py-1 text-sm hover:bg-gray-100">
                            <!-- Static PH flag -->
                            <img src="{{ asset('ph.png') }}" alt="PH Flag" class="w-5 h-3 mr-1">
                            <x-phosphor.icons::regular.caret-down class="w-4 h-4 text-gray-900 ml-1" />
                        </button>
                    </div>
                    <!-- Divider -->
                    <div class="w-px h-6 bg-gray-300 mx-2"></div>

                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <input type="text" placeholder="agency title, keyword, company"
                               class="w-[500px] pl-8 pr-3 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 border-0">
                        <x-phosphor.icons::regular.magnifying-glass class="w-5 h-5 text-gray-400 absolute left-2 top-3" />
                    </div>
                </div>
            </div>

            <!-- Right: Sign In Button -->
            <div>
                <a wire:navigate href="{{ route('loginform') }}">
                    <button class="px-4 py-2 border bg-black rounded-md text-sm font-medium hover:bg-gray-100 hover:text-black text-white">
                        Log Out
                    </button>
                </a>
            </div>

        </div>
    </div>
</header>

 <!-- Navbar -->
 <header class="bg-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
        @role('Company')
        <h2 class="text-lg font-semibold">Messages</h2>
        @endrole
        @role('Agency')
        <h2 class="text-lg font-semibold">Chat with the Company</h2>
        @endrole
        <nav class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Home</a> / Chat
        </nav>        
    </div>
</header>

@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox !text-[#354657]"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn !text-[#354657]"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Tabs --}}
            {{-- 
             <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div>  --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title"><span>Favorites</span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">    
                    </div>
                    <a href="#" class="user-name"></a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home !text-[#354657]"></i></a>
                    <a href="#" class="show-infoSide "><i class="fas fa-info-circle !text-[#354657]"></i></a>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message ">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times !text-[#354657]"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
    
        
    </body>
</html>