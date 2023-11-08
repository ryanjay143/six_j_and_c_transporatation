@extends('layouts.admin.trucks')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('List of Trucks') }}</h2>
                        <div class="row size">
                            <div class="container">
                                <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                    <i class="bi bi-plus-circle"></i> Add truck
                                </button>
                                <div class="card mb-3 bg-light">
                                    <div class="card-body">
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Truck</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="{{ route('save.truck') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <input type="email" class="form-control text-uppercase" readOnly id="floatingInput" value="isuzu forward">
                                                            <label for="floatingInput">Truck type</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control @error('plate_number') is-invalid @enderror" name="plate_number" oninput="this.value = this.value.toUpperCase()" placeholder="name@example.com" value="{{ old('plate_number') }}">
                                                            <label for="floatingInput">Plate Number</label>
                                                            @error('plate_number')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formGroupExampleInput" class="form-label">Truck Photo</label>
                                                            <input type="file" class="form-control @error('truck_photo') is-invalid @enderror" name="truck_photo" id="truck_photo_input" placeholder="Example input placeholder">
                                                            @error('truck_photo')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            <div class="mt-2" id="truck_photo_preview_container" style="display: none;">
                                                                <img id="truck_photo_preview" src="#" alt="Truck Photo Preview" style="max-width: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary btn-sm">Save truck</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-respnsive">
                                            <table id="table" class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Truck Type</th>
                                                        <th scope="col">Plate Number</th>
                                                        <th scope="col">Photo</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($trucks as $t)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td class="text-uppercase">{{ $t->truck_type }}</td>
                                                            <td class="text-uppercase">{{ $t->plate_number }}</td>
                                                            <td>
                                                                <a href="{{ asset($t->truck_image) }}" >
                                                                    <img
                                                                        id="truck_photo_view_{{ $t->id }}"
                                                                        class="p-2 zoomable-image"
                                                                        src="{{ asset($t->truck_image) }}"
                                                                        data-title="Truck Photo"
                                                                        data-lightbox="truck-photos"
                                                                        alt="Truck Photo"
                                                                        width="60"
                                                                        height="50">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if ($t->status == 0)
                                                                    <span class="badge text-bg-success">Available</span>
                                                                @else
                                                                    <span class="badge text-bg-danger">Not Available</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#truckInfo{{ $t->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="truckInfo{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Truck information</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover">
                                                                                            <thead class="table-primary">
                                                                                                <tr>
                                                                                                    <th scope="col">Truck status</th>
                                                                                                    <th scope="col">Updated date & time</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @if (count($t->truckInformation) === 0)
                                                                                                    <tr>
                                                                                                        <td colspan="2" class="text-center">No data available</td>
                                                                                                    </tr>
                                                                                                @else
                                                                                                    @foreach ($t->truckInformation as $truckInfo)
                                                                                                        @php
                                                                                                            $today = now()->format('Y-m-d'); // Get today's date
                                                                                                            $infoDate = $truckInfo->updated_at->format('Y-m-d'); // Get the date from the updated_at column
                                                                                                        @endphp

                                                                                                        @if ($today === $infoDate)
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    @if ($truckInfo->status == 1)
                                                                                                                        <span class="badge bg-primary">Assigned</span>
                                                                                                                    @elseif ($truckInfo->status == 2)
                                                                                                                        <span class="badge bg-danger">Picked-up</span>
                                                                                                                    @elseif ($truckInfo->status == 3)
                                                                                                                        <span class="badge bg-secondary">Departure</span>
                                                                                                                    @elseif ($truckInfo->status == 4)
                                                                                                                        <span class="badge bg-success">Delivery on the way</span>
                                                                                                                    @elseif ($truckInfo->status == 5)
                                                                                                                        <span class="badge bg-success">Delivered</span>
                                                                                                                    @elseif ($truckInfo->status == 6)
                                                                                                                        <span class="badge bg-info">Arrived at the station</span>
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                                <td>{{ $truckInfo->updated_at->format('F j, Y h:i A') }}</td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2{{ $t->id }}">
                                                                    <i class="bi bi-pen-fill"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal2{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Truck</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('update.truck', $t->id) }}" method="post" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="email" class="form-control text-uppercase" readOnly id="floatingInput" value="isuzu forward">
                                                                                        <label for="floatingInput">Truck type</label>
                                                                                    </div>
                                                                                    <div class="form-floating mb-3">
                                                                                        <input type="text" class="form-control text-uppercase" readonly name="plate_number" value="{{ $t->plate_number }}">
                                                                                        <label for="plate_number">Plate Number</label>
                                                                                    </div>

                                                                                    <div class="form-floating mb-3">
                                                                                        <select class="form-select" name="status">
                                                                                            <option value="0" @if ($t->status == 0) selected @endif>Available (In good condition)</option>
                                                                                            <option value="1" @if ($t->status == 1) selected @endif>Not available</option>
                                                                                        </select>
                                                                                        <label for="plate_number">Status</label>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="truck_photo_{{ $t->id }}" class="form-label">Truck Photo</label>
                                                                                        <input type="file" class="form-control" id="truck_photo_{{ $t->id }}" name="truck_photos[]" data-truck-id="{{ $t->id }}">
                                                                                        <img class="p-2" src="{{ asset($t->truck_image) }}" alt="Truck Photo" style="max-width: 200px;">
                                                                                    </div>
                                                                                    <button type="submit" class="btn btn-primary btn-sm float-end">Update Truck</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

@endsection