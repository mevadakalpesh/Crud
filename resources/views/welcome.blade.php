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

    <div class="max-w-7xl mx-auto p-6 lg:p-8">

      <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
        
        

        <div class="chee">
          <?php 
          $color = [
            '3' => 'yellow',
            '5' => 'orange',
            '7' => 'red',
            '9' => 'green',
            '11' => 'pink',
            '13' => 'yellow',
            '15' => 'orange',
            ];
          $html = '';
          for ($i = 1; $i <= 8; $i++) {
             $html .= '<div class="row">';
                 for ($b = 1; $b <= 8; $b++) {
                   $total = $i + $b;
                   if($total % 2 == 0){
                     $html .= ' <div class="box white">'.($i * $b) .'</div>';
                   }else{
                    $html .= ' <div class="box " style="background:'.$color[$total].';">'. ($i * $b)  .'</div>';
                   }
                 }
             $html .= '</div>';
          }
    
          echo $html;
        ?>
        </div>



      </div>
    </div>
  </div>
</body>
</html>