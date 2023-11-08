@extends('layouts.user.dashboard')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mr-sm-3 border border-primary w-100">
                                    <div class="card-header">
                                        <h4>{{ __('Todays transportation') }} <span class="badge bg-primary rounded-pill">{{ $todaysTranspo }}</span></h4>
                                        <p class="mb-0 float-end">Date: {{ date('F j, Y') }}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered letter-size">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">Driver</th>
                                                        <th scope="col">Photo</th>
                                                        <th scope="col">Route</th>
                                                        <th scope="col">Truck type</th>
                                                        <th scope="col">Plate no.</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transpo as $t)
                                                        <tr>
                                                            <td>{{ $t->employee->user->name }} {{ $t->employee->user->lname }}</td>
                                                            <td>
                                                                <a href="{{ $t->employee->photo ? asset('storage/' . $t->employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}" data-lightbox="profile-image">
                                                                    <img id="profile-preview" class="rounded-circle"  height="35px" src="{{ $t->employee->photo ? asset('storage/' . $t->employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                                </a>
                                                            </td>
                                                            <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>
                                                            <td class="text-uppercase">{{ $t->truck->truck_type }}</td>
                                                            <td>{{ $t->truck->plate_number }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $t->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">View status</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered table-hover">
                                                                                        <thead class="table-primary">
                                                                                            <tr>
                                                                                                <th scope="col">Transportation status</th>
                                                                                                <th scope="col">Time</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @forelse ($t->updatedTime as $u)
                                                                                            <tr>
                                                                                                <td>
                                                                                                    @if ($u->status == 2)
                                                                                                        <span class="badge bg-danger">Picked-up</span>
                                                                                                    @elseif ($u->status == 3)
                                                                                                        <span class="badge bg-secondary">Departure</span>
                                                                                                    @elseif ($u->status == 4)
                                                                                                        <span class="badge bg-success">Delivery on the way</span>
                                                                                                    @elseif ($u->status == 5)
                                                                                                        <span class="badge bg-success">Delivered</span>
                                                                                                    @elseif ($u->status == 6)
                                                                                                        <span class="badge bg-info">Arrived</span>
                                                                                                    @elseif ($u->status == 7)
                                                                                                        <span class="badge bg-success">Completed</span>

                                                                                                    @endif
                                                                                                </td>
                                                                                                <td>{{ $u->created_at->format('F d, Y h:i A') }}</td>
                                                                                            </tr>
                                                                                            @empty
                                                                                                <tr>
                                                                                                    <td colspan="2" class="text-center">No data available</td>
                                                                                                </tr>
                                                                                            @endforelse
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
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
                </section>
            </div>

            <!-- <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer> -->
        </div>


    @endsection