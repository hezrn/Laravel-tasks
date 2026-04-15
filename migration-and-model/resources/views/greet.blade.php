<!DOCTYPE html>
<html>
<head>
    <title>Greeting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-900 via-black to-purple-700 min-h-screen flex items-center justify-center text-white">

    <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl shadow-lg text-center border border-purple-400 w-[350px]">

        @if(!empty($name))
            <!-- WITH NAME -->
            <h1 class="text-3xl font-bold text-purple-300">
                Hi {{ $name }}, welcome!
            </h1>
        @else
            <!-- ONLY HELLO -->
            <h1 class="text-3xl font-bold text-purple-300">
                Hello
            </h1>
        @endif

        <div class="mt-8">
            <a href="/tasks" class="inline-flex items-center justify-center rounded-full bg-purple-600 px-6 py-3 text-sm font-semibold text-white shadow-xl shadow-purple-500/25 transition hover:bg-purple-700">
                Go to Tasks
            </a>
        </div>

    </div>

</body>
</html>