<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Project Management') }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3.3.4/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect/dist/vue-multiselect.min.css">
    <!-- Additional styles (if needed) -->
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header Section -->
    <header class="bg-blue-600 text-white py-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-semibold">{{ config('app.name', 'Project Management') }}</a>
            <nav class="space-x-4">
                <a href="{{ route('home') }}" class="hover:text-blue-200">Projects</a>
                <a href="{{ route('projects.create') }}" class="hover:text-blue-200">Create Project</a>
                <!-- Add other links here -->
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="py-6">
        @yield('content')
    </main>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Project Management') }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <script src="https://unpkg.com/vue-multiselect"></script>
    @yield('scripts')

</body>
</html>
