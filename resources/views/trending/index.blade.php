<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @include('layouts.partials.head')
    <link rel="icon" href="{{ asset('assets/images/polsri/logo-pupr.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #chartjs-tooltip {
            opacity: 0;
            position: absolute;
            background: rgba(33, 37, 41, 0.9);
            color: white;
            border-radius: 6px;
            padding: 8px 12px;
            pointer-events: none;
            transition: opacity .1s ease;
            transform: translate(-50%, -120%);
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            white-space: nowrap;
        }
        .tooltip-title {
            font-weight: 500;
            margin-bottom: 4px;
            text-align: center;
        }
        .tooltip-body {
            font-weight: 400;
            text-align: center;
        }
    </style>

    <title>Grafik Historis: {{ $sensorName }}</title>
</head>

<body>
	<div class="wrapper">
		<div class="header-wrapper">
			@include('layouts.partials.navbar')
			<div class="primary-menu">
                @include('layouts.partials.nav-menu')
			</div>
		</div>
		<div class="page-wrapper">
			<div class="page-content">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Grafik Historis: {{ $sensorName }}</h5>
                            <div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='bx bx-pencil'></i> Line
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item drawing-tool" href="#" data-tool="horizontal"><i class='bx bx-ruler' ></i> Garis Horizontal</a></li>
                                        <li><a class="dropdown-item drawing-tool" href="#" data-tool="vertical"><i class='bx bx-ruler' style="transform: rotate(90deg);"></i> Garis Vertikal</a></li>
                                        <li><a class="dropdown-item drawing-tool" href="#" data-tool="cross"><i class='bx bx-crosshair'></i> Garis Silang (Cross)</a></li>
                                        <li><a class="dropdown-item drawing-tool" href="#" data-tool="trend"><i class='bx bx-line-chart'></i> Garis Tren (Trend Line)</a></li>
                                    </ul>
                                </div>
                                <button id="clearAnnotations" class="btn btn-sm btn-danger" title="Hapus semua garis yang telah digambar"><i class='bx bx-trash'></i> Hapus Gambar</button>
                                <a href="{{ route('trending.selection') }}" class="btn btn-sm btn-outline-secondary ms-2"><i class='bx bx-arrow-back'></i> Kembali</a>
                            </div>
                        </div>
                        
                        <form id="filterForm" action="{{ route('trending.index', ['sensorName' => $sensorName]) }}" method="GET" class="row g-3 align-items-center my-3 border-top pt-3">
                            {{-- Input tersembunyi ini yang akan dikirim ke controller --}}
                            <input type="hidden" name="tanggal_mulai" id="tanggal_mulai_hidden" value="{{ $currentTanggalMulai }}">
                            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir_hidden" value="{{ $currentTanggalAkhir }}">
                            
                            <div class="col-md-3">
                                <label for="periode" class="form-label">Periode</label>
                                <select name="periode" id="periode" class="form-select">
                                    <option value="harian" {{ $currentPeriode == 'harian' ? 'selected' : '' }}>Harian</option>
                                    <option value="mingguan" {{ $currentPeriode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="bulanan" {{ $currentPeriode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="all_time" {{ $currentPeriode == 'all_time' ? 'selected' : '' }}>Semua (All Time)</option>
                                    <option value="custom_range" {{ $currentPeriode == 'custom_range' ? 'selected' : '' }}>Rentang Kustom</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3" id="single-date-container">
                                <label for="tanggal_single" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" id="tanggal_single">
                            </div>

                            <div class="col-md-4" id="range-date-container">
                                <label class="form-label">Rentang Tanggal</label>
                                <input type="text" class="form-control" id="tanggal_range">
                            </div>

                            <div class="col-auto">
                                <div style="padding-top: 28px;">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        
                        <div style="position: relative; height: 60vh;">
                            <canvas id="sensorChart" 
                                data-chart_data="{{ json_encode($chartData) }}"
                                data-color="{{ $chartColor }}"
                                data-unit="{{ $unit }}"
                                data-name="{{ $sensorName }}"
                                data-periode="{{ $currentPeriode }}">
                            </canvas>
                        </div>
            
                        <div class="text-center text-muted mt-2">
                            <small><i class='bx bx-mouse-alt'></i> Gunakan scroll mouse untuk zoom dan klik-tahan-geser untuk menggeser grafik.</small>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		
		@include('layouts.partials.footer')
	</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@3.0.1/dist/chartjs-plugin-annotation.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- BAGIAN 1: LOGIKA INTERAKSI FILTER ---
            const periodeDropdown = document.getElementById('periode');
            const singleDateContainer = document.getElementById('single-date-container');
            const rangeDateContainer = document.getElementById('range-date-container');
            const hiddenTanggalMulai = document.getElementById('tanggal_mulai_hidden');
            const hiddenTanggalAkhir = document.getElementById('tanggal_akhir_hidden');

            const singlePicker = flatpickr("#tanggal_single", {
                dateFormat: "Y-m-d",
                defaultDate: "{{ $currentTanggalMulai }}",
                onChange: function(selectedDates, dateStr, instance) {
                    hiddenTanggalMulai.value = dateStr;
                    hiddenTanggalAkhir.value = dateStr;
                }
            });

            const rangePicker = flatpickr("#tanggal_range", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: ["{{ $currentTanggalMulai }}", "{{ $currentTanggalAkhir }}"],
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        hiddenTanggalMulai.value = instance.formatDate(selectedDates[0], "Y-m-d");
                        hiddenTanggalAkhir.value = instance.formatDate(selectedDates[1], "Y-m-d");
                    }
                }
            });

            function toggleDatePickers() {
                const isCustomRange = periodeDropdown.value === 'custom_range';
                const isAllTime = periodeDropdown.value === 'all_time';
                singleDateContainer.style.display = (isCustomRange || isAllTime) ? 'none' : 'block';
                rangeDateContainer.style.display = isCustomRange ? 'block' : 'none';
            }
            toggleDatePickers();
            periodeDropdown.addEventListener('change', toggleDatePickers);

            // --- BAGIAN 2: PERSIAPAN DATA GRAFIK ---
            const canvas = document.getElementById('sensorChart');
            if (!canvas) return;
            const chartData = JSON.parse(canvas.dataset.chart_data || '[]');

            if (chartData.length === 0) {
                canvas.parentElement.innerHTML = `<div class="alert alert-warning text-center">Tidak ada data untuk ditampilkan pada periode yang dipilih.</div>`;
                return;
            }

            const chartColor = canvas.dataset.color;
            const sensorUnit = canvas.dataset.unit;
            const sensorName = canvas.dataset.name;
            const currentPeriode = canvas.dataset.periode;
            const ctx = canvas.getContext('2d');
            const storageKey = `chartAnnotations-${sensorName.replace(/\s+/g, '-')}`;
            
            // --- BAGIAN 3: KUMPULAN FUNGSI HELPER ---
            function loadAnnotationsFromStorage() { const saved = localStorage.getItem(storageKey); return saved ? JSON.parse(saved) : {}; }
            function hexToRgba(hex, alpha) { let r=0,g=0,b=0;if(hex.length==4){r="0x"+hex[1]+hex[1];g="0x"+hex[2]+hex[2];b="0x"+hex[3]+hex[3]}else if(hex.length==7){r="0x"+hex[1]+hex[2];g="0x"+hex[3]+hex[4];b="0x"+hex[5]+hex[6]}return"rgba("+ +r+"," + +g+"," + +b+","+alpha+")"}
            
            const getOrCreateTooltip = (chart) => {
                let tooltipEl = chart.canvas.parentNode.querySelector('div#chartjs-tooltip');
                if (!tooltipEl) {
                    tooltipEl = document.createElement('div');
                    tooltipEl.id = 'chartjs-tooltip';
                    chart.canvas.parentNode.appendChild(tooltipEl);
                }
                return tooltipEl;
            };

            const externalTooltipHandler = (context) => {
                const {chart, tooltip} = context;
                const tooltipEl = getOrCreateTooltip(chart);
                if(tooltip.opacity===0){tooltipEl.style.opacity=0;return}
                if(tooltip.body){
                    const title=tooltip.title[0]||'';
                    const dataPoint=tooltip.dataPoints[0];
                    const value=dataPoint.parsed.y;
                    let tooltipDisplayName = sensorName;
                    if (sensorName === 'Barometric Pressure') {
                        tooltipDisplayName = 'B. Pressure';
                    }
                    const bodyText=`${tooltipDisplayName}: ${value.toFixed(2)} ${sensorUnit}`;
                    tooltipEl.innerHTML=`<div class="tooltip-title">${title}</div><div class="tooltip-body">${bodyText}</div>`;
                }
                const {offsetLeft:posX,offsetTop:posY}=chart.canvas;
                tooltipEl.style.opacity=1;
                tooltipEl.style.left=posX+tooltip.caretX+'px';
                tooltipEl.style.top=posY+tooltip.caretY+'px';
            };

            // --- BAGIAN 4: KONFIGURASI CHART.JS ---
            let timeConfig = { tooltipFormat: 'dd MMM yy, HH:mm' };
            if (currentPeriode === 'harian') {
                timeConfig.unit = 'hour';
                timeConfig.displayFormats = { hour: 'HH:00' };
            } else {
                timeConfig.unit = 'day';
                timeConfig.displayFormats = { day: 'dd MMM' };
            }
            
            const myChart = new Chart(ctx, {
                type: 'line', 
                data: {
                    datasets: [{
                        label: `Nilai ${sensorName}`, data: chartData, borderColor: chartColor,
                        backgroundColor: (c) => { const {chart:{ctx,chartArea:a}}=c;if(!a)return null;const g=ctx.createLinearGradient(0,a.top,0,a.bottom);g.addColorStop(0,hexToRgba(chartColor,0.3));g.addColorStop(1,hexToRgba(chartColor,0.01));return g; },
                        fill: true, borderWidth: 2, pointRadius: 0, pointHoverRadius: 6, tension: 0.3
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { intersect: false, mode: 'index' },
                    plugins: {
                        annotation: { annotations: loadAnnotationsFromStorage() },
                        legend: { display: false },
                        tooltip: {
                            enabled: false, external: externalTooltipHandler,
                            callbacks: {
                                title: (ctx) => { const ts=ctx[0].parsed.x; const d=new Date(ts); return `${d.toLocaleDateString('id-ID',{day:'numeric',month:'short'})}, ${d.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'})}`; }
                            }
                        },
                        zoom: { pan: { enabled: true, mode: 'x' }, zoom: { wheel: { enabled: true }, mode: 'x' } }
                    },
                    scales: {
                        x: {
                            type: 'timeseries', time: timeConfig, grid: { display: false }, 
                            ticks: { color: '#6c757d', maxRotation: 0, autoSkip: true, maxTicksLimit: (currentPeriode === 'harian' ? 12 : 7) }
                        },
                        y: { grid: { color: '#e9ecef', borderDash: [3, 3] }, ticks: { color: '#6c757d' } }
                    }
                }
            });

            // --- BAGIAN 5: PLUGIN DAN LOGIKA TOOL GAMBAR ---
            const verticalLinePlugin = {
                id: 'verticalLine',
                afterDraw: (c) => { if(c.tooltip?._active?.length){let x=c.tooltip._active[0].element.x;let y=c.scales.y;let a=c.ctx;a.save();a.beginPath();a.setLineDash([5,5]);a.moveTo(x,y.top);a.lineTo(x,y.bottom);a.lineWidth=1;a.strokeStyle='rgba(0,0,0,0.5)';a.stroke();a.restore()} }
            };
            Chart.register(verticalLinePlugin);
            
            function saveAnnotationsToStorage() { localStorage.setItem(storageKey, JSON.stringify(myChart.options.plugins.annotation.annotations)); }
            let drawingMode=null, trendLineStartPoint=null, annotationCounter=Object.keys(loadAnnotationsFromStorage()).length;
            const drawingTools=document.querySelectorAll('.drawing-tool');
            const clearAnnotationsBtn=document.getElementById('clearAnnotations');
            function resetTrendLine(){if(myChart.options.plugins.annotation.annotations['startPoint']){delete myChart.options.plugins.annotation.annotations['startPoint'];myChart.update('none')}trendLineStartPoint=null}
            drawingTools.forEach(t=>{t.addEventListener('click',function(e){e.preventDefault();drawingMode=this.dataset.tool;ctx.canvas.style.cursor='crosshair';if(trendLineStartPoint){resetTrendLine()}})});
            clearAnnotationsBtn.addEventListener('click',()=>{myChart.options.plugins.annotation.annotations={};resetTrendLine();myChart.update();saveAnnotationsToStorage()});
            ctx.canvas.addEventListener('click',(e)=>{
                if(!drawingMode)return;
                const xAxis=myChart.scales.x;
                const yAxis=myChart.scales.y;
                const xValue=xAxis.getValueForPixel(e.offsetX);
                const yValue=yAxis.getValueForPixel(e.offsetY);
                annotationCounter++;
                switch(drawingMode){
                    case'horizontal':myChart.options.plugins.annotation.annotations['line'+annotationCounter]={type:'line',yMin:yValue,yMax:yValue,borderColor:'rgb(255,99,132)',borderWidth:2};break;
                    case'vertical':myChart.options.plugins.annotation.annotations['line'+annotationCounter]={type:'line',xMin:xValue,xMax:xValue,borderColor:'rgb(54,162,235)',borderWidth:2};break;
                    case'cross':myChart.options.plugins.annotation.annotations['crossH'+annotationCounter]={type:'line',yMin:yValue,yMax:yValue,borderColor:'rgb(153,102,255)',borderWidth:1,borderDash:[5,5]};myChart.options.plugins.annotation.annotations['crossV'+annotationCounter]={type:'line',xMin:xValue,xMax:xValue,borderColor:'rgb(153,102,255)',borderWidth:1,borderDash:[5,5]};break;
                    case'trend':if(!trendLineStartPoint){trendLineStartPoint={x:xValue,y:yValue};myChart.options.plugins.annotation.annotations['startPoint']={type:'point',xValue:xValue,yValue:yValue,backgroundColor:'rgba(255,206,86,0.8)',radius:5}}else{myChart.options.plugins.annotation.annotations['trend'+annotationCounter]={type:'line',xMin:trendLineStartPoint.x,yMin:trendLineStartPoint.y,xMax:xValue,yMax:yValue,borderColor:'rgb(255,206,86)',borderWidth:2};resetTrendLine()}break;
                }
                if(drawingMode!=='trend'||!trendLineStartPoint){drawingMode=null;ctx.canvas.style.cursor='default'}
                myChart.update();
                saveAnnotationsToStorage()
            });
        });
    </script>
</body>
</html>