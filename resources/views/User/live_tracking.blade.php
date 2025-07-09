<<<<<<< Updated upstream
{{-- resources/views/User/live_tracking.blade.php --}}

<x-app-layout> {{-- Panggil ini sebagai komponen! --}}
    {{-- Konten halaman ini akan secara otomatis menjadi $slot di dalam x-app-layout --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        /* Style untuk pesan error tracking, jika belum ada di CSS global Anda */
        .tracking-error {
            color: #ef4444; /* Tailwind red-500 */
            font-weight: bold;
            margin-top: 0.5rem;
        }

        /* Pastikan peta memiliki tinggi yang cukup */
        .leaflet-map {
            height: 300px;
            border-radius: 0.5rem; /* rounded-md */
        }
    </style>

    <div class="relative">
        {{-- Breadcrumbs/Background Kuning --}}
        {{-- Ini adalah div yang akan memberikan background kuning penuh lebar --}}
        {{-- Jika x-app-layout sudah memiliki background kuning ini, Anda bisa menghapusnya dari sini --}}
        <div class="bg-yellow-400 p-6 shadow-md h-40 w-full absolute top-0 left-0 z-0"></div>

        {{-- Konten Utama Halaman --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 py-8">
            {{-- Judul Halaman --}}
            <h1 class="text-2xl font-bold text-black mb-8">Live Tracking Pengiriman</h1>

            {{-- Kotak Pencarian dan Hasil Live Tracking --}}
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold mb-2">Lacak Pengiriman Anda</h3>
                <div class="flex gap-2 flex-col md:flex-row">
                    <input type="text" id="user_tracking_number" placeholder="Masukkan Nomor Resi Anda"
                           class="input input-bordered w-full" />
                    <button onclick="trackShipment()" class="btn bg-gradient-to-r from-yellow-400 to-yellow-300 text-black shadow font-semibold">
                        Lacak
                    </button>
                </div>
                <div id="tracking_result" class="mt-4 hidden">
                    <p class="font-semibold">Status Pengiriman: <span id="shipment_status" class="font-normal"></span></p>
                    <p class="font-semibold">Terakhir Diperbarui: <span id="last_tracked_at" class="font-normal"></span></p>
                    <div id="user_map" class="mt-4 leaflet-map"></div>
                </div>
                <p id="tracking_error_message" class="tracking-error hidden"></p>
=======
<x-app-layout>
    {{-- Halaman ini didedikasikan untuk melacak satu nomor resi --}}

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    <div class="relative">
        <div class="bg-yellow-400 p-6 shadow-md h-40 w-full absolute top-0 left-0 z-0"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-black mb-8">Lacak Pengiriman Anda</h1>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="max-w-xl mx-auto">
                    <h3 class="font-bold mb-2 text-center">Masukkan Nomor Resi</h3>
                    <div class="flex gap-2 flex-col md:flex-row">
                        <input type="text" id="user_tracking_number" placeholder="Contoh: SJ-XXXX-XXXX" class="input input-bordered w-full" />
                        <button id="track_btn" class="btn bg-yellow-400 hover:bg-yellow-500 text-black shadow font-semibold">
                            Lacak
                        </button>
                    </div>
                    
                    {{-- Kontainer untuk menampilkan semua hasil --}}
                    <div id="tracking_result" class="mt-4 hidden">
                        {{-- Hasil akan dirender oleh JavaScript di sini --}}
                    </div>

                    <p id="tracking_error_message" class="text-red-600 font-semibold mt-2 hidden"></p>
                </div>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>

    @push('scripts')
<<<<<<< Updated upstream
    <script>
        let userMap, userMarker;

        // Fungsi untuk inisialisasi atau memperbarui peta user
        function initUserMap(lat, long) {
            if (!userMap) {
                userMap = L.map('user_map').setView([lat, long], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(userMap);
            }

            if (userMarker) {
                userMarker.setLatLng([lat, long]);
            } else {
                userMarker = L.marker([lat, long]).addTo(userMap)
                    .bindPopup('Lokasi Kurir Saat Ini').openPopup();
            }

            userMap.setView([lat, long], 15);
            // Memastikan peta di-resize jika div-nya sebelumnya hidden
            setTimeout(() => {
                userMap.invalidateSize();
            }, 100);
        }

        // Fungsi untuk melacak pengiriman
        function trackShipment() {
            const trackingNumber = document.getElementById('user_tracking_number').value;
            const trackingResultDiv = document.getElementById('tracking_result');
            const shipmentStatusSpan = document.getElementById('shipment_status');
            const lastTrackedAtSpan = document.getElementById('last_tracked_at');
            const trackingErrorMessage = document.getElementById('tracking_error_message');

            // Sembunyikan hasil sebelumnya dan pesan error
            trackingResultDiv.classList.add('hidden');
            trackingErrorMessage.classList.add('hidden');
            trackingErrorMessage.innerText = '';
=======
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let userMap, userMarker, trackingInterval;
        const POLLING_INTERVAL_MS = 15000; // 15 detik

        const trackBtn = document.getElementById('track_btn');
        const trackingInput = document.getElementById('user_tracking_number');
        const trackingResultDiv = document.getElementById('tracking_result');
        const trackingErrorMessage = document.getElementById('tracking_error_message');

        function initUserMap(lat, long) {
            // Pastikan div peta ada sebelum inisialisasi
            if (!document.getElementById('user_map')) return;

            if (!userMap) {
                userMap = L.map('user_map').setView([lat, long], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(userMap);
            }
            if (userMarker) {
                userMarker.setLatLng([lat, long]);
            } else {
                const courierIcon = L.icon({
                    iconUrl: '{{ asset("images/user/courier-icon.png") }}', // Pastikan path icon benar
                    iconSize: [40, 40],
                    iconAnchor: [20, 40],
                    popupAnchor: [0, -40]
                });
                userMarker = L.marker([lat, long], { icon: courierIcon }).addTo(userMap)
                    .bindPopup('Lokasi Kurir Saat Ini').openPopup();
            }
            userMap.setView([lat, long], 15);
        }

        function stopCurrentTracking() {
            if (trackingInterval) {
                clearInterval(trackingInterval);
                trackingInterval = null;
            }
        }
        
        function renderShipmentDetails(data) {
            const details = data.details;
            const message = data.message || 'Detail Pengiriman:';
            
            return `
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="mb-4">
                        <p><strong>Status Pengiriman:</strong> <span class="font-normal badge badge-info">${data.shipment_status || 'N/A'}</span></p>
                        <p><strong>Terakhir Diperbarui:</strong> <span class="font-normal">${data.last_tracked_at || 'N/A'}</span></p>
                    </div>
                    <div class="p-4 border rounded-md bg-white">
                        <h4 class="font-semibold mb-2 text-center">${message}</h4>
                        <div class="divider my-1"></div>
                        <div class="text-sm space-y-1">
                            <p><strong>Penerima:</strong> ${details.receiver_name}</p>
                            <p><strong>Alamat:</strong> ${details.receiver_address}</p>
                            <p><strong>Barang:</strong> ${details.item_type} (${details.weight_kg} Kg)</p>
                        </div>
                    </div>
                </div>
            `;
        }
        
        function renderMap(data) {
             return `
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="mb-2">
                        <p><strong>Status:</strong> <span class="font-normal badge badge-success">${data.shipment_status || 'N/A'}</span></p>
                        <p><strong>Terakhir Diperbarui:</strong> <span class="font-normal">${data.last_tracked_at || 'N/A'}</span></p>
                    </div>
                    <div id="user_map" class="mt-2 rounded-md border" style="height: 400px;"></div>
                </div>
            `;
        }

        function trackShipment() {
            const trackingNumber = trackingInput.value.trim();
            stopCurrentTracking();

            // Reset UI
            trackingErrorMessage.classList.add('hidden');
            trackingResultDiv.classList.add('hidden');
            trackingResultDiv.innerHTML = ''; // Kosongkan hasil sebelumnya
            if (userMap) {
                userMap.remove();
                userMap = null;
                userMarker = null;
            }
>>>>>>> Stashed changes

            if (!trackingNumber) {
                trackingErrorMessage.innerText = 'Nomor resi wajib diisi.';
                trackingErrorMessage.classList.remove('hidden');
                return;
            }

<<<<<<< Updated upstream
            // Tampilkan loading atau pesan bahwa sedang melacak
            shipmentStatusSpan.innerText = 'Mencari data...';
            lastTrackedAtSpan.innerText = '';
            trackingResultDiv.classList.remove('hidden'); // Tampilkan div hasil walaupun masih loading

            fetch("{{ route('api.shipment_location') }}?tracking_number=" + trackingNumber)
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => Promise.reject(err));
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.lat && data.long) {
                        initUserMap(data.lat, data.long);
                    } else {
                        // Jika tidak ada lat/long (mungkin belum di-track oleh kurir)
                        if (userMap) {
                            userMap.remove(); // Hapus peta jika sudah ada
                            userMap = null;
                            userMarker = null;
                        }
                        document.getElementById('user_map').innerHTML = '<p class="text-center text-gray-500">Lokasi kurir belum tersedia atau tidak di-update.</p>';
                        // Tambahkan kelas leaflet-map kembali jika dihilangkan, agar styling tetap ada
                        document.getElementById('user_map').classList.add('leaflet-map');
                    }

                    shipmentStatusSpan.innerText = data.status || 'N/A';
                    lastTrackedAtSpan.innerText = data.last_tracked_at || 'N/A';
                    trackingResultDiv.classList.remove('hidden');
                    trackingErrorMessage.classList.add('hidden'); // Pastikan error disembunyikan jika sukses
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (userMap) {
                        userMap.remove(); // Hapus peta jika ada error
                        userMap = null;
                        userMarker = null;
                    }
                    document.getElementById('user_map').innerHTML = ''; // Kosongkan area peta
                    // Tambahkan kelas leaflet-map kembali jika dihilangkan, agar styling tetap ada
                    document.getElementById('user_map').classList.add('leaflet-map');
                    trackingResultDiv.classList.add('hidden'); // Sembunyikan div hasil jika ada error
                    trackingErrorMessage.innerText = error.message || 'Terjadi kesalahan saat melacak pengiriman. Mohon periksa nomor resi Anda.';
                    trackingErrorMessage.classList.remove('hidden');
                });
        }
=======
            trackBtn.disabled = true;
            trackBtn.innerHTML = `<span class="loading loading-spinner loading-xs"></span> Melacak...`;

            const fetchLocation = async () => {
                // Hanya tampilkan spinner pada fetch pertama
                if (!trackingResultDiv.classList.contains('hidden')) {
                    trackBtn.disabled = true;
                    trackBtn.innerHTML = 'Lacak';
                }

                try {
                    const response = await fetch(`{{ route('api.shipment_location') }}?tracking_number=${trackingNumber}`);
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal mengambil data pengiriman.');
                    }
                    
                    trackingResultDiv.classList.remove('hidden');

                    if (data.status === 'finished' || data.tracking_status === 'inactive') {
                        stopCurrentTracking();
                        trackingResultDiv.innerHTML = renderShipmentDetails(data);
                    } 
                    else if (data.tracking_status === 'active' && data.lat && data.long) {
                        // Hanya render ulang peta jika belum ada
                        if (!userMap) {
                            trackingResultDiv.innerHTML = renderMap(data);
                            initUserMap(data.lat, data.long);
                        } else {
                            // Cukup update marker dan view
                            userMarker.setLatLng([data.lat, data.long]);
                            userMap.panTo([data.lat, data.long]);
                        }
                        
                        // Mulai polling jika belum berjalan
                        if (!trackingInterval) {
                            trackingInterval = setInterval(fetchLocation, POLLING_INTERVAL_MS);
                        }
                    }

                } catch (error) {
                    stopCurrentTracking();
                    trackingResultDiv.classList.add('hidden');
                    trackingErrorMessage.innerText = error.message;
                    trackingErrorMessage.classList.remove('hidden');
                } finally {
                    if (!trackingInterval) {
                        trackBtn.disabled = false;
                        trackBtn.innerHTML = 'Lacak';
                    }
                }
            };

            fetchLocation();
        }

        trackBtn.addEventListener('click', trackShipment);
        trackingInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                trackShipment();
            }
        });
    });
>>>>>>> Stashed changes
    </script>
    @endpush
</x-app-layout>