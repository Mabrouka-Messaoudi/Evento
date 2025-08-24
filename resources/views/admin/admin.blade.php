<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Evento - Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Fixed Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            z-index: 1030;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .header .logo {
            background-color: #1a252f;
            color: white;
            padding: 8px 20px;
            font-weight: bold;
            font-size: 18px;
            border-radius: 5px;
            margin-right: 40px;
        }

        .header .nav-links {
            display: flex;
            gap: 30px;
            margin-left: auto;
        }

        .header .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
            position: relative;
        }

        .header .nav-links a:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .header .nav-links a.active {
            color: #e74c3c;
            font-weight: 600;
        }

        .header .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background-color: #e74c3c;
            border-radius: 2px;
        }
        /* Make logout button look like a nav link */
.nav-links .nav-logout-form {
    display: inline-block;
    margin: 0;
    padding: 0;
}

.nav-links .nav-logout-form button {
    all: unset; /* removes default button styles */
    display: inline-block;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-family: inherit;
    font-size: inherit;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* Hover effect same as links */
.nav-links .nav-logout-form button:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateY(-2px);
}


        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 280px;
            height: calc(100vh - 70px);
            background: linear-gradient(180deg, #1a252f 0%, #2c3e50 100%);
            color: white;
            padding: 30px 0;
            overflow-y: auto;
            box-shadow: 3px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 24px;
            font-weight: 300;
            letter-spacing: 1px;
            color: #ecf0f1;
        }

        .sidebar .nav-item {
            margin: 0 20px 8px 20px;
        }

        .sidebar .nav-item a {
            display: flex;
            align-items: center;
            color: #bdc3c7;
            text-decoration: none;
            padding: 15px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-item a i {
            margin-right: 15px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-item a:hover {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        .sidebar .nav-item a.active {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }

        .content-card h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }

        .content-card h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 2px;
        }

        /* Form Styling */
        .form-container {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            align-items: end;
        }

        .form-container .form-group {
            flex: 1;
        }

        .form-container input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-container input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn-add {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }

        /* Table Styling */
        .custom-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        }

        .custom-table thead th {
            color: white;
            padding: 18px 15px;
            font-weight: 600;
            border: none;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .custom-table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
            color: #495057;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Action Buttons */
        .btn-edit {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            margin-right: 8px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(243, 156, 18, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }

            .main-content {
                margin-left: 0;
                margin-top: 70px;
            }

            .header .nav-links {
                display: none;
            }

            .form-container {
                flex-direction: column;
                gap: 15px;
            }
        }
        /* Hamburger menu */
.menu-toggle {
    display: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    margin-left: auto;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .header {
        flex-wrap: wrap;
        height: auto;
        padding: 10px 20px;
    }

    .menu-toggle {
        display: block;
    }

    .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        gap: 10px;
        margin-top: 10px;
    }

    .nav-links a,
    .nav-links .nav-logout-form button {
        width: 100%;
        text-align: center;
        padding: 10px 0;
    }

    .nav-links.show {
        display: flex;
    }
}

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #1a252f;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>
    <div class="header">
    <div class="logo">EVENTO</div>

    <!-- Hamburger Menu for mobile -->
    <div class="menu-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>

    <div class="nav-links" id="nav-links">
        <a href="{{ route('home') }}" class="active">HOME</a>
        <a href="{{ url('/about') }}">À PROPOS DE NOUS</a>
        <a href="{{ url('/evenements') }}">NOS ÉVÉNEMENTS</a>

        {{-- Auth based navigation --}}
        @if (Route::has('login'))
            @auth
                @php
                    $redirectRoute = '#';
                    if (Auth::user()->role === 'admin') {
                        $redirectRoute = route('admin.dashboard');
                    } elseif (Auth::user()->role === 'organisateur') {
                        $redirectRoute = route('organisateur.dashboard');
                    } elseif (Auth::user()->role === 'participant') {
                        $redirectRoute = route('participant.dashboard');
                    }
                @endphp
                <a href="{{ $redirectRoute }}">DASHBOARD</a>
                <a href="{{ route('profile.edit') }}">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</a>

                {{-- Logout button styled as link --}}
                <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                    @csrf
                    <button type="submit">DÉCONNEXION</button>
                </form>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </div>
</div>




    <!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <div class="nav-item">
        <a href="#categories" class="active">
            <i class="fas fa-tags"></i>
            Gestion des Catégories
        </a>
    </div>
    <div class="nav-item">
        <a href="#users">
            <i class="fas fa-users"></i>
            Utilisateurs
        </a>
    </div>
</div>
 <!-- Close sidebar here -->

<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

<script>
document.querySelectorAll('.sidebar .nav-item a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // Remove active class from all links
        document.querySelectorAll('.sidebar .nav-item a').forEach(l => l.classList.remove('active'));

        // Add active class to clicked link
        this.classList.add('active');

        // Smooth scroll to the section
        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.getElementById('nav-links');

    mobileMenu.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
</script>

</script>

</body>

</html>
