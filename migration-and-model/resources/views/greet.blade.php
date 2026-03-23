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
                Hi {{ $name }} , Welcome! 🎉
            </h1>
        @else
            <!-- ONLY HELLO -->
            <h1 class="text-3xl font-bold text-purple-300">
                Hello 👋
            </h1>
        @endif

    </div>

</body>
</html>