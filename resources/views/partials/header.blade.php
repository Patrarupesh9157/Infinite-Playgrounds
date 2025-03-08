<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" style="width: 158px;">
                    </a>

                    <!-- Navigation -->
                    <ul class="nav">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Our Game</a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
                        
                        @auth
                            <li class="nav-item dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" id="userDropdown">
                                    {{ auth()->user()->name }} <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-sign-out"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a></li>
                            <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a></li>
                        @endauth
                    </ul>   

                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

@push('styles')
<style>
    .nav-item.dropdown {
        position: relative;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        padding: 10px 0;
        min-width: 180px;
        display: none;
        z-index: 1000;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu li {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .dropdown-menu a,
    .dropdown-menu button {
        display: block;
        padding: 10px 20px;
        color: #1e1e1e;
        text-decoration: none;
        font-size: 14px;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dropdown-menu a:hover,
    .dropdown-menu button:hover {
        background: #f8f9fa;
        color: #ee626b;
    }

    .dropdown-menu i {
        margin-right: 10px;
        width: 16px;
    }

    .dropdown-toggle i {
        margin-left: 5px;
        font-size: 12px;
    }

    @media (max-width: 767px) {
        .dropdown-menu {
            position: static;
            box-shadow: none;
            border-radius: 0;
            background: #f8f9fa;
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Menu trigger for mobile
    $('.menu-trigger').click(function() {
        $('.nav').toggleClass('active');
    });

    // Dropdown toggle
    $('.dropdown-toggle').click(function(e) {
        e.preventDefault();
        $(this).siblings('.dropdown-menu').toggleClass('show');
    });

    // Close dropdown when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.nav-item.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});
</script>
@endpush