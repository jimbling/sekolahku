<footer class="footer bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 text-white py-8 p-8">
    <nav data-aos="fade-up">
        <h2 class="footer-title">Menu</h2>
        <a href="/" class="link link-hover text-lg font-medium">Home</a>
        <a href="/pages/tentang-kami" class="link link-hover text-lg font-medium">Profil</a>
        <a href="/berita" class="link link-hover text-lg font-medium">Berita</a>
        <a href="/unduhan" class="link link-hover text-lg font-medium">Unduhan</a>
    </nav>
    <nav data-aos="fade-up">
        <h2 class="footer-title">Kontak Kami</h2>
        <div class="space-y-4">
            <!-- Alamat -->
            <div class="flex flex-col space-y-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 mr-3">
                        <path fill-rule="evenodd"
                            d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <span class="text-lg font-medium">Alamat:</span>
                        <div class="text-base font-semibold mt-1">
                            {{ get_setting('sub_village') }},
                            {{ get_setting('rt') }}/{{ get_setting('rw') }},
                            {{ get_setting('village') }},
                            {{ get_setting('sub_district') }},
                            {{ get_setting('district') }},
                            {{ get_setting('postal_code') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="flex flex-col space-y-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 mr-3">
                        <path
                            d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path
                            d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                    <div class="flex-1">
                        <span class="text-lg font-medium">Email:</span>
                        <div class="text-base font-semibold mt-1">
                            {{ get_setting('email') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Telepon -->
            <div class="flex flex-col space-y-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 mr-3">
                        <path fill-rule="evenodd"
                            d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <span class="text-lg font-medium">Telepon:</span>
                        <div class="text-base font-semibold mt-1">
                            {{ get_setting('phone') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Website -->
            <div class="flex flex-col space-y-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 mr-3">
                        <path fill-rule="evenodd"
                            d="M4.5 9.75a6 6 0 0 1 11.573-2.226 3.75 3.75 0 0 1 4.133 4.303A4.5 4.5 0 0 1 18 20.25H6.75a5.25 5.25 0 0 1-2.23-10.004 6.072 6.072 0 0 1-.02-.496Z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <span class="text-lg font-medium">Website:</span>
                        <div class="text-base font-semibold mt-1">
                            {{ get_setting('website') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <nav data-aos="fade-up">
        <h2 class="footer-title">Media Sosial</h2>
        <div class="grid grid-flow-col gap-4 mb-6">
            <a href="{{ get_setting('twitter') }}" class="transition-colors duration-300 hover:text-blue-400"
                aria-label="Halaman Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                    </path>
                </svg>
            </a>
            <a href="{{ get_setting('youtube') }}" class="transition-colors duration-300 hover:text-red-600"
                aria-label="YouTube Channel">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                        d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z">
                    </path>
                </svg>
            </a>
            <a href="{{ get_setting('facebook') }}" class="transition-colors duration-300 hover:text-blue-600"
                aria-label="Halaman Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    class="fill-current">
                    <path
                        d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z">
                    </path>
                </svg>
            </a>

            <a href="{{ get_setting('instagram') }}" class="transition-colors duration-300 hover:text-pink-600"
                aria-label="Halaman Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2476 2476"
                    id="instagram">
                    <path
                        d="M825.4 1238c0-227.9 184.7-412.7 412.6-412.7 227.9 0 412.7 184.8 412.7 412.7 0 227.9-184.8 412.7-412.7 412.7-227.9 0-412.6-184.8-412.6-412.7m-223.1 0c0 351.1 284.6 635.7 635.7 635.7s635.7-284.6 635.7-635.7-284.6-635.7-635.7-635.7S602.3 886.9 602.3 1238m1148-660.9c0 82 66.5 148.6 148.6 148.6 82 0 148.6-66.6 148.6-148.6s-66.5-148.5-148.6-148.5-148.6 66.5-148.6 148.5M737.8 2245.7c-120.7-5.5-186.3-25.6-229.9-42.6-57.8-22.5-99-49.3-142.4-92.6-43.3-43.3-70.2-84.5-92.6-142.3-17-43.6-37.1-109.2-42.6-229.9-6-130.5-7.2-169.7-7.2-500.3s1.3-369.7 7.2-500.3c5.5-120.7 25.7-186.2 42.6-229.9 22.5-57.8 49.3-99 92.6-142.4 43.3-43.3 84.5-70.2 142.4-92.6 43.6-17 109.2-37.1 229.9-42.6 130.5-6 169.7-7.2 500.2-7.2 330.6 0 369.7 1.3 500.3 7.2 120.7 5.5 186.2 25.7 229.9 42.6 57.8 22.4 99 49.3 142.4 92.6 43.3 43.3 70.1 84.6 92.6 142.4 17 43.6 37.1 109.2 42.6 229.9 6 130.6 7.2 169.7 7.2 500.3 0 330.5-1.2 369.7-7.2 500.3-5.5 120.7-25.7 186.3-42.6 229.9-22.5 57.8-49.3 99-92.6 142.3-43.3 43.3-84.6 70.1-142.4 92.6-43.6 17-109.2 37.1-229.9 42.6-130.5 6-169.7 7.2-500.3 7.2-330.5 0-369.7-1.2-500.2-7.2M727.6 7.5c-131.8 6-221.8 26.9-300.5 57.5-81.4 31.6-150.4 74-219.3 142.8C139 276.6 96.6 345.6 65 427.1 34.4 505.8 13.5 595.8 7.5 727.6 1.4 859.6 0 901.8 0 1238s1.4 378.4 7.5 510.4c6 131.8 26.9 221.8 57.5 300.5 31.6 81.4 73.9 150.5 142.8 219.3 68.8 68.8 137.8 111.1 219.3 142.8 78.8 30.6 168.7 51.5 300.5 57.5 132.1 6 174.2 7.5 510.4 7.5 336.3 0 378.4-1.4 510.4-7.5 131.8-6 221.8-26.9 300.5-57.5 81.4-31.7 150.4-74 219.3-142.8 68.8-68.8 111.1-137.9 142.8-219.3 30.6-78.7 51.6-168.7 57.5-300.5 6-132.1 7.4-174.2 7.4-510.4s-1.4-378.4-7.4-510.4c-6-131.8-26.9-221.8-57.5-300.5-31.7-81.4-74-150.4-142.8-219.3C2199.4 139 2130.3 96.6 2049 65c-78.8-30.6-168.8-51.6-300.5-57.5-132-6-174.2-7.5-510.4-7.5-336.3 0-378.4 1.4-510.5 7.5"
                        fill="currentColor"></path>
                </svg>

            </a>



        </div>

        <!-- Form Langganan -->

        <form action="{{ route('subscribe') }}" method="POST" class="w-full px-4">
            @csrf

            <fieldset class="form-control w-full max-w-md mx-auto">
                <div class="join w-full">
                    <input type="email" name="email" placeholder="username@site.com"
                        class="input input-bordered join-item w-full text-gray-500" />
                    <button class="btn btn-primary join-item whitespace-nowrap">Subscribe</button>
                </div>
            </fieldset>
        </form>


        <div class="mt-4 text-center font-semibold max-w-full">
            <p>&copy; {{ date('Y') }} - <a
                    href="{{ get_setting('website') }}">{{ get_setting('school_name') }}</a>. Semua hak cipta
                dilindungi.</p>
            <span>Tema <strong>{{ getActiveThemeName() }}</strong> oleh <a href="{{ get_setting('website') }}">CMS
                    Sinau</a></span>
        </div>
    </nav>
</footer>

<footer
    class="footer bg-gradient-to-r from-blue-700 via-teal-700 to-green-700 text-white py-4 flex flex-col md:flex-row items-center justify-center gap-2 text-center text-sm md:text-base">
    <aside class="flex flex-col md:flex-row items-center gap-1">
        <div class="flex items-center gap-1">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="fill-current">
                <path
                    d="M22.672 15.226l-2.432.811.841 2.515c.33 1.019-.209 2.127-1.23 2.456-1.15.325-2.148-.321-2.463-1.226l-.84-2.518-5.013 1.677.84 2.517c.391 1.203-.434 2.542-1.831 2.542-.88 0-1.601-.564-1.86-1.314l-.842-2.516-2.431.809c-1.135.328-2.145-.317-2.463-1.229-.329-1.018.211-2.127 1.231-2.456l2.432-.809-1.621-4.823-2.432.808c-1.355.384-2.558-.59-2.558-1.839 0-.817.509-1.582 1.327-1.846l2.433-.809-.842-2.515c-.33-1.02.211-2.129 1.232-2.458 1.02-.329 2.13.209 2.461 1.229l.842 2.515 5.011-1.677-.839-2.517c-.403-1.238.484-2.553 1.843-2.553.819 0 1.585.509 1.85 1.326l.841 2.517 2.431-.81c1.02-.33 2.131.211 2.461 1.229.332 1.018-.21 2.126-1.23 2.456l-2.433.809 1.622 4.823 2.433-.809c1.242-.401 2.557.484 2.557 1.838 0 .819-.51 1.583-1.328 1.847m-8.992-6.428l-5.01 1.675 1.619 4.828 5.011-1.674-1.62-4.829z">
                </path>
            </svg>

        </div>
        <div class="flex items-center gap-1">
            <span>&nbsp; dibuat dengan sepenuh</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-5 h-5 fill-pink-400">
                <path
                    d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
            </svg>
            <span>oleh <a href="{{ get_setting('website') }}">CMS Sinau</a></span>
        </div>
    </aside>
</footer>


<div id="toast-container" class="fixed top-4 right-4 space-y-2">
    <div id="toast" class="toast hidden bg-blue-500 text-white p-4 rounded shadow-lg">
        <p id="toast-message">Pesan berhasil dikirim!</p>
    </div>
</div>







<script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            var disqus_config = function() {
                this.page.url = "{{ url()->current() }}"; // PAGE URL
                this.page.identifier = "{{ $post->id ?? 'generic_identifier' }}"; // PAGE IDENTIFIER
            };

            (function() {
                var d = document,
                    s = d.createElement('script');
                var shortname_disqus = "{{ get_setting('shortname_disqus') }}";
                s.src =
                    `https://${shortname_disqus}.disqus.com/embed.js`; // GET SHORTNAME_DISQUS FROM DATABASE
                s.setAttribute('data-timestamp', +new Date());
                s.onload = function() {
                    var errorBox = document.getElementById('disqus_error');
                    if (errorBox) {
                        errorBox.classList.add('hidden');
                    }
                };
                s.onerror = function() {
                    var errorBox = document.getElementById('disqus_error');
                    if (errorBox) {
                        errorBox.classList.remove('hidden');
                    }
                };
                (d.head || d.body).appendChild(s);
            })();
        } catch (e) {
            console.log('Disqus loading error:', e);
        }
    });
</script>

<script>
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.add('show');

        // Automatically hide toast after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.classList.add('hidden'), 500);
        }, 5000); // Toast will be shown for 5 seconds
    }

    // Show toast if session 'success' message is present
    @if (session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}');
        });
    @endif
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('.sticky-header');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 0) {
                header.classList.add('sticky-active');
            } else {
                header.classList.remove('sticky-active');
            }
        });

    });
</script>

{{-- <script>
    async function submitForm(event) {
        event.preventDefault();
        const nisn = document.getElementById('nisn').value;
        const url = `https://bantuan-pd.sdnkedungrejo.sch.id/api/bantuan/searchByNisn?nisn=${nisn}`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (response.ok) {
                if (data.status === 'success') {
                    displayResults(data);
                } else {
                    showNotFound();
                }
            } else {
                showError(`Error: ${data.message}`);
            }
        } catch (error) {
            console.error('Error:', error);
            showError(`Terjadi kesalahan: ${error.message}`);
        }
    }

    function displayResults(data) {
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = `
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-bold mb-4">Hasil Pencarian</h3>
                <div class="grid grid-cols-1 gap-4">
                    ${data.data.map(item => `
                        <div class="border border-gray-200 rounded-md p-3">
                            <p class="font-semibold">Nama: ${item.nama_pd}</p>
                            <p class="text-sm">Jenis Bantuan: ${item.jenis_bantuan}</p>
                            <p class="text-sm">Tanggal SK: ${item.tanggal_sk}</p>
                            <p class="text-sm">Tahap ID: ${item.tahap_id}</p>
                        </div>
                    `).join('')}
                </div>
                <p class="mt-4 text-sm">Tahun Saat Ini: ${data.currentYear}</p>
            </div>
        `;
    }

    function showNotFound() {
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = `
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-bold text-red-600 mb-4">Data tidak ditemukan</h3>
            </div>
        `;
    }

    function showError(message) {
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = `<div class="text-red-600">${message}</div>`;
    }
</script> --}}
