<footer class="bg-blue-800 py-4 h-16">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
        <p>&copy; {{ date('Y') }} Your App. All rights reserved.</p>
    </div>
</footer>
<script>
    var lastScrollTop = 0;
    window.addEventListener("scroll", function() {
        var currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        // Memastikan top bar hanya muncul ketika scroll benar-benar di atas
        if (currentScroll === 0) {
            document.getElementById("top-bar").classList.remove("hidden");
            document.getElementById("navbar").classList.add("bg-blue-800");
            document.getElementById("navbar").classList.remove("bg-blue-700");
        } else {
            // Scroll down or up but not at the top
            if (currentScroll > lastScrollTop) {
                // Scroll down
                document.getElementById("top-bar").classList.add("hidden");
                document.getElementById("navbar").classList.remove("bg-blue-800");
                document.getElementById("navbar").classList.add("bg-blue-700");
            } else {
                // Scroll up but not at the very top
                document.getElementById("top-bar").classList.remove("hidden");
                document.getElementById("navbar").classList.add("bg-blue-800");
                document.getElementById("navbar").classList.remove("bg-blue-700");
            }
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Prevent negative scroll values
    });
</script>
