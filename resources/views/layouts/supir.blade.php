<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <title>Supir Panel - Rental Mobil Harkat Yogyakarta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 h-full">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-supir.sidebar />

        <!-- Content -->
        <div class="flex-1 flex flex-col">
            <x-supir.topbar />

            <!-- Main Section with Alpine State -->
            <main class="flex-1 p-4 md:ml-64" x-data="jobModal()" @open-modal.window="openModal($event.detail)">

                @yield('content')

                <!-- Modal Popup -->
                <div x-show="showModal"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                        <h2 class="text-lg font-bold mb-4">🚗 Job Baru Masuk!</h2>
                        <p><strong>Mobil:</strong> <span x-text="job?.mobil"></span></p>
                        <p><strong>Tanggal Sewa:</strong> <span x-text="job?.tanggal_sewa"></span></p>
                        <p><strong>Tanggal Kembali:</strong> <span x-text="job?.tanggal_kembali"></span></p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button @click="declineJob()"
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Decline</button>
                            <button @click="acceptJob()"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Accept</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <x-supir.bottomnav />

    <!-- Script Echo + AlpineJS -->
    <script>
        // Pusher / Echo example
        document.addEventListener("DOMContentLoaded", () => {
            if (window.Echo) {
                console.log("Echo connected ✅");

                Echo.channel('supir-available')
                    .listen('JobAssigned', (e) => {
                        console.log("Job baru masuk:", e);

                        // trigger Alpine modal event
                        window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: {
                                transaksi_id: e.transaksi_id,
                                mobil: e.mobil,
                                tanggal_sewa: e.tanggal_sewa,
                                tanggal_kembali: e.tanggal_kembali
                            }
                        }));
                    });
            } else {
                console.error("Echo not loaded ❌");
            }
        });

        function jobModal() {
            return {
                showModal: false,
                job: null,

                // Dipanggil saat Echo event diterima
                openModal(detail) {
                    console.log('Job baru masuk:', detail);
                    this.job = detail;
                    this.showModal = true;
                },

                // Accept job
                acceptJob() {
                    if (!this.job?.transaksi_id) return;
                    console.log('Accept clicked, id:', this.job.transaksi_id);

                    fetch("{{ route('supir.acceptJob', ['transaksiId' => 'TRANSAKSI_ID']) }}"
                            .replace('TRANSAKSI_ID', this.job.transaksi_id), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    // ambil langsung id supir dari auth
                                    supir_id: {{ auth('supir')->id() }}
                                })
                            })
                        .then(res => res.json())
                        .then(data => {
                            console.log("Job accepted ✅", data);
                            this.showModal = false;
                            this.job = null;
                        })
                        .catch(err => console.error('Error accept job:', err));
                },

                // Decline job
                declineJob() {
                    this.showModal = false;
                    this.job = null;
                }
            }
        }
    </script>

</body>

</html>
