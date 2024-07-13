<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Construction</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-to-r from-blue-400 to-indigo-500 h-screen flex items-center justify-center">
    <div class="text-center text-white">

        <h1 class="text-4xl font-bold mb-2">Under Construction</h1>
        <p class="text-lg mb-6">We're working hard to improve our site and we'll be back soon!</p>
        <img src="https://via.placeholder.com/150" alt="Under Construction" class="rounded-full mb-4 mx-auto">
        <p class="text-sm">
            Estimated time remaining: <span class="font-bold">
                {{ Carbon\Carbon::now()->diffForHumans(Carbon\Carbon::createFromFormat('Y-m-d', get_setting('site_maintenance_end_date'))) }}
                days
            </span> (until
            {{ Carbon\Carbon::createFromFormat('Y-m-d', get_setting('site_maintenance_end_date'))->format('j F Y') }})
        </p>
    </div>
</body>

</html>
