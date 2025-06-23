@extends('layouts.main')
@push('css')
    <style>
        .font-dashboard-realtime {
            font-size: 50px;
        }

        .card {
            border: 2px solid #009EE3;
            border-radius: 10px;
        }
        .card-header {
            border-bottom: 2px solid #009EE3; /* Menambahkan garis bawah berwarna biru pada header */
        }

    </style>
@endpush
@section('content')
<div class="row row-cols-1 row-cols-lg-3">
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">pH</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">7</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">TSS</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">16</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">COD</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">240</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">Amonia</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">15</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">Debit</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">0,2</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col d-flex">
        <div class="card radius-10 w-100">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold">Totalizer</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-block text-center">
                    <div class="realtime my-4">
                        <span class="text-center fw-bold font-dashboard-realtime text-gray-800 hover-info tx-digital" id="">7</span> 
                        <span class="text-black">mg/L</span>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->
{{-- <div class="row row-cols-1 row-cols-lg-1">
    <div class="col">
        <table id="testTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john.doe@example.com</td>
                    <td>+1234567890</td>
                    <td>Edit | Delete</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane.smith@example.com</td>
                    <td>+0987654321</td>
                    <td>Edit | Delete</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}
@endsection
