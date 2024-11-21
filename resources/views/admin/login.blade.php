@extends('admin.layout')

@section('content')
    <!-- Main Container -->
    <div class="main-container">

        <!-- Logo Section (Mobile Only) -->
        <div class="logo-mobile">
            <img
                src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png"
                alt="Pacific-Enterprise Mobile"
                class="logo-mobile-image"
            />
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Left Image Section (Desktop Only) -->
            <div class="image-section">
                <img
                    src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png"
                    alt="Pacific-Enterprise"
                    class="image"
                />
            </div>

            <!-- Right Login Section -->
            <div class="login-section">
                <!-- Login Header -->
                <h1 class="login-title">
                    Login
                </h1>

                <!-- Login Form -->
                <form class="login-form" action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <!-- Username Input -->
                    <div class="form-group">
                        <input
                            type="text"
                            name="username"
                            class="input"
                            placeholder="Username"
                            required
                        />
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <input
                            type="password"
                            name="password"
                            class="input"
                            placeholder="Password"
                            required
                        />
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="submit-button"
                    >
                        Login
                    </button>
                </form>

                <!-- Error Message -->
                @if ($errors->has('login_error'))
                    <div class="error-message">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <!-- Loading Spinner -->
                <div id="spinner" class="spinner invisible">
                    <div class="spinner-animation"></div>
                </div>

            </div>
        </div>
    </div>

    <!-- Spinner Script -->
    <script>
        // Mostrar el spinner cuando se envía el formulario
        document.querySelector('form').addEventListener('submit', function (event) {
            document.getElementById('spinner').classList.remove('invisible');
            document.getElementById('spinner').classList.add('visible');
        });

    </script>

    <style>
        /* General Styles */
        .main-container {
            height: 100vh;
            background: var(--secondary-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 16px;
            position: relative;
            width: 100%;
            max-width: 768px;
            margin: 0 auto;
        }

        /* Logo Mobile */
        .logo-mobile {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
        }

        .logo-mobile-image {
            max-width: 200px;
            width: 100%;
            height: auto;
        }

        /* Media Queries */
        @media (min-width: 1024px) {
            .main-container {
                max-width: 90%;
                padding: 32px;
            }
        }

        @media (min-width: 1440px) {
            .main-container {
                max-width: 1200px;
                padding: 48px;
            }
        }

        @media (min-width: 768px) {
            .logo-mobile {
                display: none;
            }

            .image-section {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 24px;
                height: 100%;
            }
        }

        @media (max-width: 767px) {
            .logo-mobile {
                display: flex;
            }

            .image-section {
                display: none;
            }
        }

        .content-wrapper {
            width: 100%;
            max-width: 64rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            background: #6b46c1;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .content-wrapper {
                grid-template-columns: 1fr 1fr;
            }
        }

        .image {
            width: 100%;
            height: auto;
            transition: transform 0.5s ease-in-out;
        }

        .image:hover {
            transform: scale(1.05);
        }

        .login-section {
            padding: 32px;
            background: #f9fafb;
            position: relative;
        }

        .login-title {
            font-size: 1.875rem;
            font-weight: bold;
            text-align: center;
            color: #6b46c1;
            margin-bottom: 32px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d2d6dc;
            border-radius: 8px;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            color: #374151;
        }

        .submit-button {
            width: 100%;
            padding: 12px 16px;
            background-color: #6b46c1;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: #553c9a;
        }

        .error-message {
            margin-top: 16px;
            text-align: center;
            color: #e53e3e;
        }

        /* Spinner oculto */
        .spinner {
            display: none;
            justify-content: center;
            align-items: center;
            margin-top: 24px;
        }

        /* Mostrar spinner */
        .spinner.visible {
            display: flex;
        }

        /* Estilo del spinner */
        .spinner-animation {
            width: 24px;
            height: 24px;
            border: 4px solid #6b46c1;
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }

    </style>
@endsection
