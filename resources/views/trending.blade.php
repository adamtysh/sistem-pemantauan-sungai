@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endpush

@section('content')
<div class="card">
    <div class="card-body">

        <form method="GET" action="" class="mb-4">
            <div class="row g-3 align-items-end">
                {{-- Type Filter --}}
                <div class="col-md-3">
                    <label for="type" class="form-label">Periode</label>
                    <select id="type" name="type" class="form-select">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                </div>

                {{-- Date --}}
                <div class="col-md-3">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="text" id="date" name="date" value=""
                        class="form-control" placeholder="Select date">
                </div>

                {{-- Submit --}}
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="chart-wrapper mb-5">
            <div id="chart3" class="chart-container"></div>
        </div>

        <div class="table-responsive">
            <table id="sensor-reading-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sensor</th>
                        <th>Value</th>
                        <th>Reading Time</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($readings as $index => $reading)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sensor->name }}</td>
                            <td>{{ $reading->value }}</td>
                            <td>{{ $reading->reading_time }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const sensor = @json($sensorSetting);
    const locationSensor = @json($location);
    // chart 3
	var options = {
		series: [{
			name: sensor.sensor_name,
			data: [31, 40, 68, 31, 92, 55, 100]
		}],
		chart: {
			foreColor: '#9ba7b2',
			height: 360,
			type: 'area',
			zoom: {
				enabled: false
			},
			toolbar: {
				show: true
			},
		},
		colors: ["#0d6efd", '#f41127'],
		title: {
			text: locationSensor.name + ' - ' + sensor.sensor_name,
			align: 'left',
			style: {
				fontSize: "16px",
				color: '#666'
			}
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth'
		},
		xaxis: {
			type: 'datetime',
			categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
		},
		tooltip: {
			x: {
				format: 'dd/MM/yy HH:mm'
			},
		},
	};
	var chart = new ApexCharts(document.querySelector("#chart3"), options);
	chart.render();
</script>
@endpush