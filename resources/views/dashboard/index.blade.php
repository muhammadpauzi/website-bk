@extends('layouts.app')

@section('content')
<div class="col">
    <div class="card shadow-lg p-4 mb-2">
        <div class="card-body">
            <h3 class="display-6">Hallo, <span class="fw-bold">{{ auth()->user()->name }}</span></h3>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            @foreach (array_chunk($cardStats, 3) as $cardStatItems)
            <div class="card-group mb-2">
                @foreach ($cardStatItems as $stat)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h3 class="fs-5">{{ $stat['label'] }}</h3>
                            <div>
                                <div class="bg-light border text-primary rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                                    style="width: 40px; height: 40px;">
                                    <span data-feather="{{ $stat['icon'] }}" class="icon-size"
                                        stroke-width="2.5"></span>
                                </div>
                            </div>
                        </div>
                        <h2 class="fs-1 fw-bold mb-2">{{ $stat['count'] }} <sup class="fs-6 text-muted fw-normal">{{
                                $stat['prefix']
                                }}</sup></h2>
                        @if ($stat['more_info_link'])
                        <a href="{{ $stat['more_info_link'] }}" class="text-decoration-none d-block">Lebih
                            Lengkap <span data-feather="arrow-right"></span></a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <canvas id="a"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="{{ asset('vendors/chartjs/chart.umd.min.js') }}"></script>
<script>
    const data = {
  labels: {!! json_encode($results[0]) !!},
  datasets: [{
    label: 'My First Dataset',
    data: {!! json_encode($results[1]) !!},
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)'
    ],
    borderWidth: 1
  }]
};
    const myChart = new Chart(document.getElementById('a'), {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                        }
                    }
                },
            });
</script>
@endpush