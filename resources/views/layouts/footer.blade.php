<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-main">
            <section class="footer-column" aria-labelledby="footer-help-heading">
                <h2 id="footer-help-heading" class="footer-heading">Customer Care</h2>

                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">Contact us</a></li>
                    <li><a href="{{ route('menu') }}">Browse the menu</a></li>
                    
                    <li><a href="mailto:castrojhannasofhia@gmail.com">Email Coco Cakes</a></li>
                </ul>
            </section>

            <section class="footer-column" aria-labelledby="footer-discover-heading">
                <h2 id="footer-discover-heading" class="footer-heading">Discover</h2>

                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">Our story</a></li>
                    <li><a href="{{ route('home') }}">Celebration ideas</a></li>
                    
                    <li><a href="{{ route('order.create') }}">Start a cake request</a></li>
                </ul>
            </section>

            <section class="footer-column" aria-labelledby="footer-account-heading">
                <h2 id="footer-account-heading" class="footer-heading">My Account</h2>

                <ul class="footer-links">
                    @guest
                        <li><a href="{{ route('login') }}">Sign in</a></li>
                        <li><a href="{{ route('register') }}">Create an account</a></li>
                    @endguest

                    @auth
                        <li><a href="{{ route('customer.requests') }}">My cake requests</a></li>
                        <li><a href="{{ route('customer.favorites') }}">Saved cakes</a></li>
                        <li><a href="{{ route('customer.pets') }}">My pets</a></li>
                        <li><a href="{{ route('profile.edit') }}">Account settings</a></li>
                    @endauth
                </ul>
            </section>

            <section class="footer-connect" aria-labelledby="footer-connect-heading">
                <p class="footer-eyebrow">Let's celebrate</p>
                <h2 id="footer-connect-heading" class="footer-heading">Planning a special day?</h2>
                <p>
                    Tell us about your pet and the occasion. We'll help you plan a treat made for the moment.
                </p>

                <a class="footer-cta" href="{{ route('order.create') }}">Plan a celebration</a>
            </section>
        </div>

        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} Coco Cakes. Baked with love for every wag.
            </p>

            <ul class="footer-promises" aria-label="Our service promises">
                <li>
                    <svg aria-hidden="true" viewBox="0 0 24 24">
                        <path d="M12 2.5c3.9 0 7 2.9 7 6.5 0 5.2-7 12.5-7 12.5S5 14.2 5 9c0-3.6 3.1-6.5 7-6.5Zm0 3C10 5.5 8.5 7 8.5 9c0 2.4 2 5.6 3.5 7.7 1.5-2.1 3.5-5.3 3.5-7.7 0-2-1.5-3.5-3.5-3.5Z"/>
                    </svg>
                    Local pickup
                </li>
                <li>
                    <svg aria-hidden="true" viewBox="0 0 24 24">
                        <path d="M12 21.4 10.6 20C5.4 15.3 2 12.2 2 8.4 2 5.3 4.4 3 7.5 3c1.7 0 3.4.8 4.5 2.1A6 6 0 0 1 16.5 3C19.6 3 22 5.3 22 8.4c0 3.8-3.4 6.9-8.6 11.6L12 21.4Z"/>
                    </svg>
                    Made with care
                </li>
                <li>
                    <svg aria-hidden="true" viewBox="0 0 24 24">
                        <path d="m9.6 17.2-4.8-4.8 2.1-2.1 2.7 2.7 7.5-7.5 2.1 2.1-9.6 9.6Z"/>
                    </svg>
                    Custom requests
                </li>
            </ul>
        </div>
    </div>
</footer>
