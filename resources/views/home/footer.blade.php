<footer class="bg-gray-800 text-white py-10">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
        <!-- Logo & Social Icons -->
        <div>
          <img class="w-16 mb-4" src="{{ asset('images/logo1.png') }}" alt="iGET Logo">
          <p class="text-sm text-blue-200 mb-4">Your trusted partner for quality electronics and IT solutions.</p>
          <ul class="flex space-x-4 text-xl">
            <li><a href="#" class="hover:text-blue-500 transition-colors"><i class="fab fa-facebook"></i></a></li>
            <li><a href="https://x.com/igetUG?t=y-TA99mjjTytwBqfa1LqSQ&s=09" class="hover:text-blue-400 transition-colors"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.tiktok.com/@iget.ug?is_from_webapp=1&sender_device=pc" class="hover:text-blue-700 transition-colors"><i class="fab fa-tiktok"></i></a></li>
            <li><a href="https://www.instagram.com/iget.ug?igsh=bTF1MGU5eGc5aG8w" class="hover:text-green-500 transition-colors"><i class="fab fa-instagram"></i></a></li>

          </ul>
        </div>

        <!-- Quick Links -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="{{ route('home') }}" class="hover:underline text-blue-200 hover:text-white transition-colors">Home</a></li>
            <li><a href="{{ route('home.laptops') }}" class="hover:underline text-blue-200 hover:text-white transition-colors">Laptops</a></li>
            <li><a href="{{ route('home.accessories') }}" class="hover:underline text-blue-200 hover:text-white transition-colors">Accessories</a></li>
            <li><a href="{{ route('home.phones') }}" class="hover:underline text-blue-200 hover:text-white transition-colors">Phones</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
          <address class="not-italic space-y-2 text-sm text-blue-200">
            <p class="flex items-center">
              <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
              ETower, Level 3, Room C10,<br>
              Kampala Road, Kampala, Uganda.
            </p>
            <p class="flex items-center">
              <i class="fas fa-phone mr-2 text-green-500"></i>
              <a href="tel:+256123456789" class="hover:text-white transition-colors">+256 7014823881</a>
            </p>
            <p class="flex items-center">
              <i class="fas fa-envelope mr-2 text-green-500"></i>
              <a href="mailto:info@igets.com" class="hover:text-white transition-colors">igetstores256@gmail.com</a>
            </p>
          </address>
        </div>

        <!-- Newsletter Subscription -->
        <div>
          <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
          <p class="text-sm text-blue-200 mb-3">Stay updated with our latest offers and products.</p>
          <form action="#" method="POST" class="flex flex-col space-y-3">
            @csrf
            <input
              type="email"
              name="email"
              placeholder="Enter your email"
              required
              class="px-4 py-2 rounded border border-blue-600 text-blue-900 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
            />
            <button
              type="submit"
              class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded transition-colors"
            >
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-blue-700 mt-8 pt-6">
      <div class="container mx-auto text-center text-sm text-blue-300">
        <p>&copy; 2025 iGET Technologies. All Rights Reserved. Designed by 
          <a href="#" class="underline hover:text-white transition-colors">Oyerol Tech</a>
        </p>
      </div>
    </div>
  </footer>

</body>
</html>
