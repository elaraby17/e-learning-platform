<div>
    @if (session('success'))
        <div id="success-alert"
            class="fixed top-5 right-5 z-50 w-[350px] bg-white dark:bg-slate-900 border border-green-500/20 shadow-2xl shadow-green-500/10 rounded-2xl overflow-hidden backdrop-blur-xl transition-all duration-500">

            <div class="flex items-start gap-4 p-5">

                {{-- Icon --}}
                <div
                    class="w-11 h-11 rounded-xl bg-green-500 flex items-center justify-center shrink-0 shadow-lg shadow-green-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                {{-- Content --}}
                <div class="flex-1">
                    <h3 class="font-bold text-green-500 text-sm mb-1">
                        تمت العملية بنجاح
                    </h3>

                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        {{ session('success') }}
                    </p>
                </div>

                {{-- Close Button --}}
                <button onclick="closeSuccessAlert()" class="text-gray-400 hover:text-red-500 transition shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            {{-- Bottom Line --}}
            <div class="h-1 bg-green-500 animate-progress"></div>
        </div>

        <style>
            @keyframes progress {
                from {
                    width: 100%;
                }

                to {
                    width: 0%;
                }
            }

            .animate-progress {
                animation: progress 2s linear forwards;
            }
        </style>

        <script>
            function closeSuccessAlert() {
                const alert = document.getElementById('success-alert');

                alert.classList.add('opacity-0', 'translate-x-10');

                setTimeout(() => {
                    alert.remove();
                }, 300);
            }

            setTimeout(() => {
                closeSuccessAlert();
            }, 2000);
        </script>
    @endif
</div>
