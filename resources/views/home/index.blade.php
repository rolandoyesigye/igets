<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF‑8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>iGETS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100" x-data="{ open: false }">

  <!-- NAVBAR -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
      <!-- Logo -->
       <a href="{{ route('home') }}"><img src="{{ asset('images/logo1.png') }}" width="100px" height="100px" alt="iGETS Logo"></a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center space-x-6">
        <a href="#" class="text-gray-700 hover:text-orange-500">Home</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Laptops</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Accessories</a>
        <a href="#" class="text-gray-700 hover:text-orange-500">Desktops</a>
        <div class="relative">
          <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-l-md focus:outline-none"/>
          <button class="absolute top-0 right-0 bg-orange-500 text-white px-3 py-1 rounded-r-md">Go</button>
        </div>
      </nav>

      <!-- Auth Buttons (md+) -->
      <div class="hidden md:flex items-center space-x-4">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="px-4 py-2 border rounded">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="bg-orange-500 text-white px-4 py-2 rounded">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded">Register</a>
            @endif
          @endauth
        @endif
      </div>

      <!-- Mobile Menu Button -->
      <button @click="open = !open" class="md:hidden text-gray-700">
        <span x-show="!open">☰</span>
        <span x-show="open">✕</span>
      </button>
    </div>

    <!-- Mobile Nav -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="md:hidden bg-white border-t border-gray-200">
      <nav class="px-6 py-4 space-y-2">
        <a href="#" class="block text-gray-700 hover:text-orange-500">Home</a>
        <a href="#" class="block text-gray-700 hover:text-orange-500">Laptops</a>
        <a href="#" class="block text-gray-700 hover:text-orange-500">Accessories</a>
        <a href="#" class="block text-gray-700 hover:text-orange-500">Desktops</a>
        <div class="pt-4 border-t">
          @if (Route::has('login'))
            @auth
              <a href="{{ url('/dashboard') }}" class="block px-4 py-2 border rounded mb-2">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="block bg-orange-500 text-white px-4 py-2 rounded mb-2">Log in</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="block bg-orange-500 text-white px-4 py-2 rounded">Register</a>
              @endif
            @endauth
          @endif
        </div>
      </nav>
    </div>
  </header>

  <!-- HERO SLIDER -->
  <section class="bg-gradient-to-r from-blue-100 to-purple-100 py-10 relative overflow-hidden">
    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-20 left-10 w-4 h-4 bg-orange-400 rounded-full animate-pulse opacity-60"></div>
      <div class="absolute top-40 right-20 w-6 h-6 bg-blue-400 rounded-full animate-bounce opacity-40"></div>
      <div class="absolute bottom-20 left-1/4 w-3 h-3 bg-purple-400 rounded-full animate-ping opacity-50"></div>
      <div class="absolute top-1/2 right-1/3 w-5 h-5 bg-green-400 rounded-full animate-spin opacity-30"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-6">
      <!-- Slider Container -->
      <div x-data="{ 
        currentSlide: 0,
        autoplay: true,
        slides: [
          {
            title: '13 Years WITH iGETS',
            subtitle: '26 May – 22 June',
            heading: 'Electronics Wano byonna!',
            discount: '70%',
            image: '{{ asset('images/pct.png') }}',
            bgColor: 'from-blue-100 to-purple-100',
            emoji1: '🎉',
            emoji2: '🎈'
          },
          {
            title: 'Latest Laptops',
            subtitle: 'Premium Quality',
            heading: 'Gaming & Business Laptops',
            discount: '50%',
            image: '{{ asset('images/pct.png') }}',
            bgColor: 'from-orange-100 to-red-100',
            emoji1: '💻',
            emoji2: '⚡'
          },
          {
            title: 'Smart Accessories',
            subtitle: 'Essential Tech',
            heading: 'Complete Your Setup',
            discount: '30%',
            image: '{{ asset('images/pct.png') }}',
            bgColor: 'from-green-100 to-teal-100',
            emoji1: '🎧',
            emoji2: '🖱️'
          }
        ],
        nextSlide() {
          this.currentSlide = this.currentSlide === this.slides.length - 1 ? 0 : this.currentSlide + 1;
        },
        prevSlide() {
          this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
        },
        goToSlide(index) {
          this.currentSlide = index;
        }
      }" 
      x-init="
        setInterval(() => {
          if (autoplay) nextSlide();
        }, 5000);
      "
      class="relative">
        
        <!-- Slides -->
        <div class="relative h-96 md:h-[500px] overflow-hidden rounded-2xl shadow-2xl">
          <template x-for="(slide, index) in slides" :key="index">
            <div 
              x-show="currentSlide === index"
              x-transition:enter="transition ease-out duration-700"
              x-transition:enter-start="opacity-0 transform translate-x-full scale-95"
              x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
              x-transition:leave="transition ease-in duration-700"
              x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
              x-transition:leave-end="opacity-0 transform -translate-x-full scale-95"
              :class="`absolute inset-0 bg-gradient-to-r ${slide.bgColor} flex items-center`"
            >
              <!-- Progress Bar for Auto-play -->
              <div x-show="autoplay" class="absolute top-0 left-0 h-1 bg-white/30 w-full z-30">
                <div class="h-full bg-white transition-all duration-5000 ease-linear" 
                     :style="`width: ${((currentSlide + 1) / slides.length) * 100}%`"></div>
              </div>
              
              <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center px-6 gap-10 w-full">
                <!-- Left Side: Text Content -->
                <div class="flex-1 space-y-6 text-center lg:text-left z-10">
                  <div class="flex items-center justify-center lg:justify-start space-x-4">
                    <span class="text-6xl" x-text="slide.emoji1"></span>
                    <h2 class="text-4xl md:text-6xl font-extrabold text-gray-800">
                      <span x-text="slide.title.split(' ')[0]"></span>
                      <span class="ml-2 text-2xl relative">
                        <span class="absolute -top-4 -left-4 rotate-12" x-text="slide.emoji2"></span>
                        <span x-text="slide.title.split(' ').slice(1).join(' ')"></span>
                      </span>
                    </h2>
                  </div>
                  
                  <p class="text-lg md:text-xl text-gray-600 font-medium" x-text="slide.subtitle"></p>
                  
                  <h3 class="text-3xl md:text-5xl font-bold text-gray-800 leading-tight" x-text="slide.heading"></h3>
                  
                  <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-6">
                    <div class="bg-white px-8 py-4 rounded-full shadow-lg transform hover:scale-105 transition-transform">
                      <p class="text-2xl font-bold">
                        UP TO <span class="text-blue-800" x-text="slide.discount"></span> OFF
                      </p>
                    </div>
                    <button class="bg-black text-white px-8 py-4 rounded-full hover:bg-gray-800 transform hover:scale-105 transition-all duration-300 shadow-lg font-semibold text-lg">
                      SHOP NOW →
                    </button>
                  </div>
                  
                  <p class="text-sm text-gray-500">T&Cs Apply</p>
                </div>

                <!-- Right Side: Image -->
                <div class="flex-1 relative flex justify-center lg:justify-end">
                  <div class="relative">
                    <!-- Floating Elements -->
                    <div class="absolute -top-8 -left-8 text-4xl animate-bounce" x-text="slide.emoji1"></div>
                    <div class="absolute -top-12 -right-12 text-4xl animate-pulse" x-text="slide.emoji2"></div>
                    
                    <!-- Main Image Container -->
                    <div class="bg-white rounded-2xl p-6 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                      <img :src="slide.image" alt="Promo" class="rounded-xl w-full max-w-sm" />
                      <div class="mt-6 text-center">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-full font-bold text-lg shadow-lg">
                          Limited Time Offer!
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>

        <!-- Navigation Arrows -->
        <button 
          @click="prevSlide(); autoplay = false; setTimeout(() => autoplay = true, 10000)"
          class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 z-20 group"
        >
          <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
        </button>
        
        <button 
          @click="nextSlide(); autoplay = false; setTimeout(() => autoplay = true, 10000)"
          class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 z-20 group"
        >
          <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </button>

        <!-- Dots Navigation -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
          <template x-for="(slide, index) in slides" :key="index">
            <button 
              @click="goToSlide(index); autoplay = false; setTimeout(() => autoplay = true, 10000)"
              :class="currentSlide === index ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/75'"
              class="w-3 h-3 rounded-full transition-all duration-300 shadow-lg hover:scale-110"
            ></button>
          </template>
        </div>

        <!-- Auto-play indicator and controls -->
        <div class="absolute top-6 right-6 flex items-center space-x-3">
          <button 
            @click="autoplay = !autoplay"
            :class="autoplay ? 'bg-green-500' : 'bg-red-500'"
            class="text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm transition-colors"
          >
            <span x-show="autoplay">▶️</span>
            <span x-show="!autoplay">⏸️</span>
          </button>
          <div class="bg-black/20 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
            <span x-text="currentSlide + 1"></span>/<span x-text="slides.length"></span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Laptop DEALS -->
  <section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-orange-500 text-white">
      <h2 class="text-lg font-bold">Laptops</h2>
      <a href="#" class="text-sm hover:underline">See All &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 px-4 sm:px-6 py-6">
      <!-- Product Card -->
      <div class="relative bg-white shadow rounded p-2">
        <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">-43%</span>
        <img src="https://dummyimage.com/200x120/ccc/000.png&text=VIDAA+TV" alt="Hisense 43 Inch FHD LED" class="w-full h-auto mb-2" />
        <h3 class="text-sm font-semibold truncate">Hisense 43 Inch FHD LED …</h3>
        <p class="text-orange-600 font-bold text-sm">UGX 679,000</p>
        <p class="line-through text-xs text-gray-500">UGX 1,200,015</p>
      </div>
      <!-- Duplicate cards below as needed -->
    </div>
  </section>

  <!--Accessories Details  -->
  <section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-orange-500 text-white">
      <h2 class="text-lg font-bold">Accessories</h2>
      <a href="#" class="text-sm hover:underline">See All &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 px-4 sm:px-6 py-6">
      <!-- Product Card -->
      <div class="relative bg-white shadow rounded p-2">
        <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">-43%</span>
        <img src="https://dummyimage.com/200x120/ccc/000.png&text=VIDAA+TV" alt="Hisense 43 Inch FHD LED" class="w-full h-auto mb-2" />
        <h3 class="text-sm font-semibold truncate">Hisense 43 Inch FHD LED …</h3>
        <p class="text-orange-600 font-bold text-sm">UGX 679,000</p>
        <p class="line-through text-xs text-gray-500">UGX 1,200,015</p>
      </div>
      <!-- Duplicate cards below as needed -->
    </div>
  </section>

  <!-- Desktop Details -->
  <section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-orange-500 text-white">
      <h2 class="text-lg font-bold">Desktops</h2>
      <a href="#" class="text-sm hover:underline">See All &rarr;</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 px-4 sm:px-6 py-6">
      <!-- Product Card -->
      <div class="relative bg-white shadow rounded p-2">
        <span class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">-43%</span>
        <img src="https://dummyimage.com/200x120/ccc/000.png&text=VIDAA+TV" alt="Hisense 43 Inch FHD LED" class="w-full h-auto mb-2" />
        <h3 class="text-sm font-semibold truncate">Hisense 43 Inch FHD LED …</h3>
        <p class="text-orange-600 font-bold text-sm">UGX 679,000</p>
        <p class="line-through text-xs text-gray-500">UGX 1,200,015</p>
      </div>
      <!-- Duplicate cards below as needed -->
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-10">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Logo & Social Icons -->
        <div>
          <img class="w-16 mb-4" src="{{ asset('images/logo1.png') }}" alt="iGETS Logo">
          <p class="text-sm text-gray-300 mb-4">Your trusted partner for quality electronics and IT solutions.</p>
          <ul class="flex space-x-4 text-xl">
            <li><a href="#" class="hover:text-blue-500 transition-colors"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#" class="hover:text-blue-400 transition-colors"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#" class="hover:text-blue-700 transition-colors"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="#" class="hover:text-pink-500 transition-colors"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="{{ route('home') }}" class="hover:underline text-gray-300 hover:text-white transition-colors">Home</a></li>
            <li><a href="#" class="hover:underline text-gray-300 hover:text-white transition-colors">Laptops</a></li>
            <li><a href="#" class="hover:underline text-gray-300 hover:text-white transition-colors">Accessories</a></li>
            <li><a href="#" class="hover:underline text-gray-300 hover:text-white transition-colors">Desktops</a></li>
            <li><a href="#" class="hover:underline text-gray-300 hover:text-white transition-colors">Contact</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
          <address class="not-italic space-y-2 text-sm text-gray-300">
            <p class="flex items-center">
              <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
              ETower, Level 3, Room C10,<br>
              Kampala Road, Kampala, Uganda.
            </p>
            <p class="flex items-center">
              <i class="fas fa-phone mr-2 text-orange-500"></i>
              <a href="tel:+256123456789" class="hover:text-white transition-colors">+256 123 456 789</a>
            </p>
            <p class="flex items-center">
              <i class="fas fa-envelope mr-2 text-orange-500"></i>
              <a href="mailto:info@igets.com" class="hover:text-white transition-colors">info@igets.com</a>
            </p>
          </address>
        </div>

        <!-- Newsletter Subscription -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-sm text-gray-300 mb-3">Stay updated with our latest offers and products.</p>
          <form action="#" method="POST" class="flex flex-col space-y-3">
            @csrf
            <input
              type="email"
              name="email"
              placeholder="Enter your email"
              required
              class="px-4 py-2 rounded border border-gray-600 text-gray-900 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white"
            />
            <button
              type="submit"
              class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded transition-colors"
            >
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-gray-700 mt-8 pt-6">
      <div class="container mx-auto text-center text-sm text-gray-400">
        <p>&copy; 2025 iGETS IT Solutions. All Rights Reserved. Designed by 
          <a href="#" class="underline hover:text-white transition-colors">Oyerol Technologies</a>
        </p>
      </div>
    </div>
  </footer>

</body>
</html>
