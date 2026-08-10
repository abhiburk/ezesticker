<footer class="sticky-footer text-dark bg-transparent p-2 shadow-lg">
    <div class="container d-sm-block d-lg-flex justify-content-between align-items-center">
        <p>&copy; {{ env('APP_NAME') }} {{ date('Y') }}. All Rights Reserved. Product by <a href="http://techmounten.com/">Techmounten</a></p>
        
        <ul class="list-inline ">
            <li class="list-inline-item">
                <a href="{{ route('page.show', 'privacy-policy') }}" target="_blank" class="text-dark">Privacy & Policy</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('page.show', 'terms-conditions') }}" target="_blank" class="text-dark">Terms & Condition</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('page.show', 'return-refund') }}" target="_blank" class="text-dark">Return & Refund</a>
            </li>
            <li class="list-inline-item">
                <a class="nav-link text-dark" href="#contact">Contact Us</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('reseller.create') }}" class="text-dark">Become a Reseller</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('faq') }}" class="text-dark">FAQ</a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('how-it-works') }}" class="text-dark">How it Works?</a>
            </li>
        </ul>
    </div>
    {{-- <a href="#" class="btn btn-outline-primary position-absolute" style="right:50px; bottom:50px;">Feedback</a> --}}
</footer>
