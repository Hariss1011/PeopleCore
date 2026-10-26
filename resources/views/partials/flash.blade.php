{{-- Success Notification --}}
@if (session('success'))
    <div role="status" class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-4 shadow-sm">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div class="min-w-0 flex-1 pt-0.5">
            <p class="text-sm font-semibold text-green-800">Berhasil</p>
            <p class="mt-1 text-sm leading-5 text-green-700">
                {{ session('success') }}
            </p>
        </div>
    </div>
@endif

{{-- Error Notification --}}
@if (session('error'))
    <div role="alert" class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-4 shadow-sm">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z" />
            </svg>
        </div>

        <div class="min-w-0 flex-1 pt-0.5">
            <p class="text-sm font-semibold text-red-800">Terjadi Kesalahan</p>
            <p class="mt-1 text-sm leading-5 text-red-700">
                {{ session('error') }}
            </p>
        </div>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any() && !request()->routeIs('login'))
    <div role="alert" class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-4 shadow-sm">
        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z" />
            </svg>
        </div>

        <div class="min-w-0 flex-1 pt-0.5">
            <p class="text-sm font-semibold text-red-800">
                Periksa Kembali Data Anda
            </p>
            <p class="mt-1 text-sm leading-5 text-red-700">
                Ada {{ $errors->count() }} kesalahan yang perlu diperbaiki sebelum data dapat disimpan.
            </p>

            <ul class="mt-3 space-y-2">
                @foreach ($errors->all() as $error)
                    <li class="flex items-start gap-2 text-sm leading-5 text-red-700">
                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500"></span>
                        <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
