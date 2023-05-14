<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

<!-- Styles -->
<style>
  /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before {
    box-sizing: border-box;
    border-width: 0;
    border-style: solid;
    border-color: #e5e7eb
  }

  ::after,::before {
    --tw-content: ''
  }

  html {
    line-height: 1.5;
    -webkit-text-size-adjust: 100%;
    -moz-tab-size: 4;
    tab-size: 4;
    font-family: Figtree, sans-serif;
    font-feature-settings: normal
  }

  body {
    margin: 0;
    line-height: inherit
  }

  .box{
    width: 50px;
    height: 50px;
    border: 1px solid orange;
  }
  .row{
    display: flex;
    margin: 0px 30px;
  }
  
  .black{
    background: black;
  }
  
  .white{
    background: white;
  }
  </style>
</head>
<body class="antialiased">
  <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-orange-500 selection:text-white">
    @if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      @auth
      <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-orange-500">Home</a>
      @else
      <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-orange-500">Log in</a>

      @if (Route::has('register'))
      <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-orange-500">Register</a>
      @endif
      @endauth
    </div>
    @endif
        
        
        <div class="container">
          <div class="row">
            <div class="menu">
              <button type="button" id="btn">click</button>
            </div>
            
            <div style="background:red;" class="menu-data bg-info">
                  <ul>
                    <li>home</li>
                    <li>usus</li>
                    <li>xjjxj</li>
                  </ul>
            </div>
            
          </div>
        </div>


      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  
  
</body>
</html>