<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" /> --}}
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #ff0000;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar .navbar-brand {
            color: #ffffff;
            text-align: center;
            font-size: 1.5em;
            padding: 1rem;
            border-bottom: 1px solid #495057;
        }

        .sidebar .navbar-brand:hover{
            color: #ffffff;
        }
        .sidebar .nav-link {
            color: #ffffff;
        }
        .sidebar .nav-link:hover {
            background-color: #49505717;
        }
        .sidebar .nav-item {
            margin-bottom: 10px;
        }
        .main-content {
            margin-left: 250px; /* Adjust this value based on the width of the sidebar */
            padding: 20px;
        }

        .tags-list {
            list-style-type: none; /* Remove default list styles */
            padding-left: 0; /* Remove default list padding */
        }
        .tags-list .tag-item {
            color: #ffffff; /* Set text color to white */
            margin-bottom: 5px;
        }
        .tags-dropdown {
            display: none; /* Hide tags dropdown initially */
        }
        .tags-dropdown.show {
            display: block; /* Show tags dropdown when .show class is added */
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <div class="sidebar">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'App Name') }}
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/cycles/create">
                        <i class="fas fa-sync-alt"></i> New Cycle
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/template">
                        <i class="fas fa-file-alt"></i> Templates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#" id="tagsDropdownToggle" aria-haspopup="true" aria-expanded="false" onclick="toggleTagsDropdown()">
                        <i class="fas fa-tags"></i> Tags
                    </a>
                    <ul class="tags-list d-none" id="tagsList"> <!-- Add the "d-none" class here to hide it by default -->
                        @php
                        $uniqueTags = [];
                        @endphp

                        @foreach(auth()->user()->cycles as $cycle)
                            @foreach($cycle->tasks as $task)
                                @foreach($task->tags as $tag)
                                    @if(!in_array($tag->tag, $uniqueTags))
                                        @php
                                        $uniqueTags[] = $tag->tag;
                                        @endphp
                                        <li class="tag-item mx-5">
                                            <a class="tag-item" href="{{ route('tags.show', $tag->tag) }}">{{ $tag->tag }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="/calendar">
                        <i class="fas fa-calendar-alt"></i> Calendar
                    </a>
                </li>
            </ul>
        </div>


        <div class="main-content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>

                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" /> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for dropdown functionality -->
<script>
    // Function to handle dropdown toggle
       // Function to toggle tags dropdown visibility
       function toggleTagsDropdown() {
    var tagsDropdown = document.getElementById('tagsList');
    tagsDropdown.classList.toggle('d-none'); // Toggle the 'd-none' class instead of 'tags-dropdown'
}

</script>
</body>
</html>
