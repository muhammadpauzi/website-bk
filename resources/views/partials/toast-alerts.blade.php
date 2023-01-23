<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
        @if (session()->has('success'))
        <div class="toast align-items-center text-bg-success border-0 p-1 shadow-lg show" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body w-100">
                    <div class="d-flex align-items-center mb-2 justify-content-between">
                        <div>
                            <span data-feather="check-circle" class="align-text-middle me-2 icon-size"></span>
                            <span class="fw-bold">Berhasil</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('failed'))
        <div class="toast align-items-center text-bg-danger border-0 p-1 shadow-lg show" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="d-flex align-items-center mb-2 justify-content-between">
                        <div>
                            <span data-feather="x-circle" class="align-text-middle me-2 icon-size"></span>
                            <span class="fw-bold">Gagal</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    {{ session('failed') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
</div>