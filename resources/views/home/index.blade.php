@include('home.nav')



  <!-- HERO SLIDER -->
  <section class="bg-gradient-to-r from-blue-100 to-green-100 py-10 relative overflow-hidden">
    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-20 left-10 w-4 h-4 bg-green-400 rounded-full animate-pulse opacity-60"></div>
      <div class="absolute top-40 right-20 w-6 h-6 bg-blue-400 rounded-full animate-bounce opacity-40"></div>
      <div class="absolute bottom-20 left-1/4 w-3 h-3 bg-blue-200 rounded-full animate-ping opacity-50"></div>
      <div class="absolute top-1/2 right-1/3 w-5 h-5 bg-green-400 rounded-full animate-spin opacity-30"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
      <!-- Slider Container -->
      <div x-data="{
        currentSlide: 0,
        autoplay: true,
        slides: [
          {
            title: '6 Years WITH iGET',
            subtitle: 'Best Quality',
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

  <!-- Search Section -->
  <section class="bg-white py-8 border-b">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Find What You're Looking For</h2>
        <p class="text-gray-600">Search through our extensive collection of electronics</p>
      </div>

      <!-- Main Search Bar -->
      <div class="max-w-2xl mx-auto mb-6">
        <div class="relative">
          <input
            type="text"
            placeholder="Search for laptops, phones, accessories..."
            class="w-full px-6 py-4 pl-12 pr-12 text-lg text-gray-700 bg-white border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm"
            onkeypress="if(event.key==='Enter') { window.location.href='{{ route('search.results') }}?q=' + encodeURIComponent(this.value); }"
          />
          <div class="absolute inset-y-0 left-0 flex items-center pl-4">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <button onclick="performSearch(event)" class="absolute inset-y-0 right-0 flex items-center pr-4 bg-blue-500 text-white px-6 rounded-r-xl hover:bg-blue-600 transition-colors">
            Search
          </button>
        </div>
      </div>

      <!-- Category Quick Access -->
      <div class="text-center">
        <p class="text-sm text-gray-500 mb-3">Or browse by category:</p>
        <div class="flex flex-wrap justify-center gap-3">
          <a href="{{ route('home.laptops') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Laptops
          </a>
          <a href="{{ route('home.phones') }}" class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg hover:bg-green-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Phones
          </a>
          <a href="{{ route('home.accessories') }}" class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-lg hover:bg-purple-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            Accessories
          </a>
        </div>
      </div>

      <!-- Popular Searches -->
      <div class="text-center mt-6">
        <p class="text-sm text-gray-500 mb-3">Popular searches:</p>
        <div class="flex flex-wrap justify-center gap-2">
          <a href="{{ route('search.results') }}?q=gaming laptop" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">gaming laptop</a>
          <a href="{{ route('search.results') }}?q=iphone" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">iphone</a>
          <a href="{{ route('search.results') }}?q=headphones" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">headphones</a>
          <a href="{{ route('search.results') }}?q=macbook" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">macbook</a>
          <a href="{{ route('search.results') }}?q=samsung" class="text-xs px-3 py-1 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors">samsung</a>
        </div>
      </div>
    </div>
  </section>

  <script>
    function performSearch(event) {
      event.preventDefault();
      const searchInput = event.target.closest('.relative').querySelector('input');
      const query = searchInput.value.trim();
      if (query) {
        window.location.href = '{{ route('search.results') }}?q=' + encodeURIComponent(query);
      }
    }
  </script>

  <!-- Laptop DEALS -->
<section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-blue-500 text-white">
      <h2 class="text-lg font-bold">Laptops</h2>
      <a href="{{ route('home.laptops') }}" class="text-sm hover:underline">See All &rarr;</a>
  </div>
    <div class="flex flex-wrap gap-4 px-4 sm:px-6 py-6">
      @forelse($laptops as $laptop)
    <!-- Product Card -->
        <a href="{{ route('home.show', $laptop) }}" class="block">
          <div class="relative bg-white shadow rounded p-2 hover:transition duration-500 ease-in-out hover:bg-gray-100 transform hover:-translate-y-1 hover:scale-110">
            @if($laptop->condition)
              <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                {{ ucfirst($laptop->condition) }}
              </span>
            @endif
            @if($laptop->image)
              <img src="{{ Storage::url($laptop->image) }}" alt="{{ $laptop->name }}" class="w-full h-32 object-cover rounded mb-2" />
            @else
              <div class="w-full h-32 bg-blue-100 rounded mb-2 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
            <h3 class="text-sm font-semibold truncate">{{ $laptop->name }}</h3>
            <p class="text-green-600 font-bold text-sm">UGX {{ number_format($laptop->price) }}</p>
            @if($laptop->original_price && $laptop->original_price > $laptop->price)
              <p class="line-through text-xs text-gray-500">UGX {{ number_format($laptop->original_price) }}</p>
            @endif

            <!-- Stock Status -->
            <p class="text-xs {{ $laptop->stock_status_color }} font-medium">{{ $laptop->stock_status }}</p>

            <!-- Add to Cart Button -->
            @if($laptop->isInStock())
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $laptop->id }}">
                <input type="hidden" name="quantity" value="1">

                <div class="flex flex-col md:flex-row gap-2">
                    <!-- Add to Cart (visible on all screens) -->
                    <button type="submit"
                            class="w-full bg-blue-500 text-white text-xs py-2 px-4 rounded hover:bg-blue-600 transition">
                        Add to Cart
                    </button>

                    <!-- WhatsApp Button (visible only on small screens) -->
                    <a href="https://wa.me/2567014823881?text=I'm%20interested%20in%20{{ urlencode($laptop->name) }}"
                      target="_blank"
                      class="block md:hidden w-full bg-green-500 text-white text-xs py-2 px-4 rounded hover:bg-green-600 transition text-center">
                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp Us
                    </a>
                </div>
            </form>
            @else
              <div class="mt-2 text-center">
                <span class="text-xs text-red-600">Out of Stock</span>
              </div>
            @endif
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-8">
          <p class="text-gray-500">No laptops available at the moment.</p>
      </div>
      @endforelse
    </div>

  </section>


  <!--Accessories Details  -->
  <section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-blue-500 text-white">
      <h2 class="text-lg font-bold">Accessories</h2>
      <a href="{{ route('home.accessories') }}" class="text-sm hover:underline">See All &rarr;</a>
    </div>
    <div class="flex flex-wrap gap-4 px-4 sm:px-6 py-6">
      @forelse($accessories as $accessory)
      <!-- Product Card -->
        <a href="{{ route('home.show', $accessory) }}" class="block">
          <div class="relative bg-white shadow rounded p-2 hover:transition duration-500 ease-in-out hover:bg-gray-100 transform hover:-translate-y-1 hover:scale-110">
            @if($accessory->condition)
              <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                {{ ucfirst($accessory->condition) }}
              </span>
            @endif
            @if($accessory->image)
              <img src="{{ Storage::url($accessory->image) }}" alt="{{ $accessory->name }}" class="w-full h-32 object-cover rounded mb-2" />
            @else
              <div class="w-full h-32 bg-blue-100 rounded mb-2 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
            <h3 class="text-sm font-semibold truncate">{{ $accessory->name }}</h3>
            <p class="text-green-600 font-bold text-sm">UGX {{ number_format($accessory->price) }}</p>
            @if($accessory->original_price && $accessory->original_price > $accessory->price)
              <p class="line-through text-xs text-gray-500">UGX {{ number_format($accessory->original_price) }}</p>
            @endif

            <!-- Stock Status -->
            <p class="text-xs {{ $accessory->stock_status_color }} font-medium">{{ $accessory->stock_status }}</p>

            <!-- Add to Cart Button -->
            @if($accessory->isInStock())
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onclick="event.stopPropagation();">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $accessory->id }}">
                  <input type="hidden" name="quantity" value="1">

                  <div class="flex flex-col md:flex-row gap-2">
                      <!-- Add to Cart (visible on all screens) -->
                      <button type="submit"
                              class="w-full bg-blue-500 text-white text-xs py-2 px-4 rounded hover:bg-blue-600 transition">
                          Add to Cart
                      </button>

                      <!-- WhatsApp Button (visible only on small screens) -->
                      <a href="https://wa.me/2567014823881?text=I'm%20interested%20in%20{{ urlencode($accessory->name) }}"
                        target="_blank"
                        class="block md:hidden w-full bg-green-500 text-white text-xs py-2 px-4 rounded hover:bg-green-600 transition text-center">
                          <i class="fab fa-whatsapp mr-1"></i> WhatsApp Us
                      </a>
                  </div>
              </form>

            @else
              <div class="mt-2 text-center">
                <span class="text-xs text-red-600">Out of Stock</span>
              </div>
            @endif
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-8">
          <p class="text-gray-500">No accessories available at the moment.</p>
      </div>
      @endforelse
    </div>
  </section>

  <!-- Phones Details -->
  <section class="bg-white mt-10">
    <div class="flex justify-between items-center px-6 py-4 bg-blue-500 text-white">
      <h2 class="text-lg font-bold">Phones</h2>
      <a href="{{ route('home.phones') }}" class="text-sm hover:underline">See All &rarr;</a>
    </div>
    <div class="flex flex-wrap gap-4 px-4 sm:px-6 py-6">
      @forelse($phones as $phone)
      <!-- Product Card -->
        <a href="{{ route('home.show', $phone) }}" class="block">
          <div class="relative bg-white shadow rounded p-2 hover:transition duration-500 ease-in-out hover:bg-gray-100 transform hover:-translate-y-1 hover:scale-110">
            @if($phone->condition)
              <span class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">
                {{ ucfirst($phone->condition) }}
              </span>
            @endif
            @if($phone->image)
              <img src="{{ Storage::url($phone->image) }}" alt="{{ $phone->name }}" class="w-full h-32 object-cover rounded mb-2" />
            @else
              <div class="w-full h-32 bg-blue-100 rounded mb-2 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
            <h3 class="text-sm font-semibold truncate">{{ $phone->name }}</h3>
            <p class="text-green-600 font-bold text-sm">UGX {{ number_format($phone->price) }}</p>
            @if($phone->original_price && $phone->original_price > $phone->price)
              <p class="line-through text-xs text-blue-500">UGX {{ number_format($phone->original_price) }}</p>
            @endif

            <!-- Stock Status -->
            <p class="text-xs {{ $phone->stock_status_color }} font-medium">{{ $phone->stock_status }}</p>

            <!-- Add to Cart Button -->
            @if($phone->isInStock())
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $phone->id }}">
                <input type="hidden" name="quantity" value="1">

                <div class="flex flex-col md:flex-row gap-2">
                    <!-- Add to Cart (visible on all screens) -->
                    <button type="submit"
                            class="w-full bg-blue-500 text-white text-xs py-2 px-4 rounded hover:bg-blue-600 transition">
                        Add to Cart
                    </button>

                    <!-- WhatsApp Button (visible only on small screens) -->
                    <a href="https://wa.me/2567014823881?text=I'm%20interested%20in%20{{ urlencode($phone->name) }}"
                      target="_blank"
                      class="block md:hidden w-full bg-green-500 text-white text-xs py-2 px-4 rounded hover:bg-green-600 transition text-center">
                        <i class="fab fa-whatsapp mr-1"></i> WhatsApp Us
                    </a>
                </div>
            </form>

            @else
              <div class="mt-2 text-center">
                <span class="text-xs text-red-600 font-medium">Out of Stock</span>
              </div>
            @endif
          </div>
        </a>
      @empty
        <div class="col-span-full text-center py-8">
          <p class="text-gray-500">No phones available at the moment.</p>
      </div>
      @endforelse
  </div>
</section>

  <!-- Footer -->
  @include('home.footer')
