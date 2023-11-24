@extends('layouts.employee.employee')

@section('content')
@include('sweetalert::alert')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>{{ __('Welcome! ') }} {{ auth::user()->name }} {{ auth::user()->lname }}</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="page-content">
                            <section class="row">
                                <div class="col-12">
                                    <div class="row card-container">
                                        <div class="col-lg-6 col-12">
                                            <a href="{{ route('driver.transportation') }}">
                                                <div class="card wide-card border border-primary w-100">
                                                    <div class="card-body px-3 py-4">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="stats-icon float-start mb-2 purple">
                                                                    <i class="fas fa-truck"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h6 class="text-muted font-semibold">{{ __('Overall Transportation History') }}</h6>
                                                                <h6 class="font-extrabold mb-0">{{ $countDeliveredTranspo }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-lg-6 col-12">
                                            <div class="card wide-card border border-primary w-100">
                                                <a href="{{ route('driver.transportation') }}">
                                                    <div class="card-body px-3 py-4">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="stats-icon float-start mb-2 purple">
                                                                    <i class="fas fa-clock"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h6 class="text-muted font-semibold">{{ __('Upcoming Transportation') }}</h6>
                                                                <h6 class="font-extrabold mb-0">{{ $upcomingTranspo }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card mb-0 border border-primary w-100">
                                                <div class="card-header">
                                                    <h4>{{ __('Todays transportation') }} <span class="badge rounded-pill bg-primary">{{ $approvedTranspo }}</span></h4>
                                                    <p class="mb-0 float-end">Date: {{ date('F j, Y') }}</p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive-for-dashboard">
                                                        <table id="dashboardforDriver" class="table table-bordered letter-size">
                                                            <thead class="table-primary ">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Client name</th>
                                                                    <th scope="col">Plate no.</th>
                                                                    <th scope="col" class="tons-header">Tons</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                                @foreach ($transpo as $t)
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $t->booking->user->name }}</td>
                                                                    <td class="text-uppercase">{{ $t->truck->plate_number }}</td>
                                                                    <form method="post" action="{{ route('update_transportation', ['id' => $t->id]) }}">
                                                                        @csrf
                                                                        <td>
                                                                            <input id="originalInput" type="number" class="form-control form-control-sm" min="1" name="tons"
                                                                                value="{{ $t->booking->tons ?? 0 }}" style="width: 65px;" 
                                                                                @if (in_array($t->status, ['1','2','3','5', '6', '7'])) readonly @endif>
                                                                        </td>                                                 
                                                                        <td>
                                                                            <div class="row g-3">
                                                                                <div class="col-12">
                                                                                    <select name="status" class="form-select form-select-sm" aria-label=".form-select-sm example" onchange="this.form.submit()" @if (in_array($t->status, ['6'])) disabled @endif>
                                                                                        <option disabled value="1" @if ($t->status == '1') selected @endif>To be pick-up</option>
                                                                                        <option value="2" @if ($t->status == '3' || $t->status == '4' || $t->status == '5' || $t->status == '2') disabled @endif @if ($t->status == '2') selected @endif>Picked-up</option>
                                                                                        <option value="3" @if ($t->status == '3' || $t->status == '1' || $t->status == '4' || $t->status == '5') disabled @endif @if ($t->status == '3') selected @endif>Departed</option>
                                                                                        <option value="4" @if ($t->status == '4' || $t->status == '1' || $t->status == '2' || $t->status == '5') disabled @endif @if ($t->status == '4') selected @endif>In Transit</option>
                                                                                        <option value="5" @if ($t->status == '5' || $t->status == '1' || $t->status == '2' || $t->status == '3') disabled @endif @if ($t->status == '5') selected @endif>Delivered</option>
                                                                                        <option disabled value="6" @if ($t->status == '6' || $t->booking->tons !== 0) style="display: none;" @endif @if ($t->status == '6') selected @endif>Arrived at the station</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $t->id }}">
                                                                                <i class="fas fa-eye"></i>
                                                                            </button>


                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModal{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Transportation details</h1>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="container">
                                                                                                <div class="row">
                                                                                                    <div class="col col-md-4">
                                                                                                        <label for="staticEmail" class="col-form-label">Pick-up date:</label>
                                                                                                    </div>
                                                                                                    <div class="col col-md-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ \Carbon\Carbon::parse($t->booking->pickUp_date)->format('F j, Y') }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div class="col col-md-4">
                                                                                                        <label for="staticEmail" class="col-form-label">Helper:</label>
                                                                                                    </div>
                                                                                                    <div class="col col-md-8">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $t->helper->user->name }} {{ $t->helper->user->lname }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div class="col col-md-4">
                                                                                                        <label for="staticEmail" class="col-form-label">Origin:</label>
                                                                                                    </div>
                                                                                                    <div class="col col-md-8">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $t->booking->origin }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                               

                                                                                                <div class="row">
                                                                                                    <div class="col col-md-4">
                                                                                                        <label for="staticEmail" class="col-form-label">Destination:</label>
                                                                                                    </div>
                                                                                                    <div class="col col-md-8">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $t->booking->destination }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="mb-3 row">
                                                                                                    <div class="col col-md-4">
                                                                                                        <label for="staticEmail" class="col-form-label">Transportation date:</label>
                                                                                                    </div>
                                                                                                    <div class="col col-md-8">
                                                                                                        @php
                                                                                                            $transportationDate = date("F j, Y", strtotime($t->booking->transportation_date));
                                                                                                        @endphp
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $transportationDate }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="table-responseve table-responsive-for-modal-dashboard">
                                                                                                <table class="table table-bordered table-hover">
                                                                                                    <thead class="table-primary">
                                                                                                        <tr>
                                                                                                            <th scope="col">Transportation status</th>
                                                                                                            <th scope="col">Updated date & time</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @forelse ($t->updatedTime as $u)
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                @if ($u->status == 2)
                                                                                                                    <span class="badge bg-danger">Picked-up</span>
                                                                                                                @elseif ($u->status == 3)
                                                                                                                    <span class="badge bg-secondary">Departed</span>
                                                                                                                @elseif ($u->status == 4)
                                                                                                                    <span class="badge bg-success">In Transit</span>
                                                                                                                @elseif ($u->status == 5)
                                                                                                                    <span class="badge bg-success">Delivered</span>
                                                                                                                @elseif ($u->status == 6)
                                                                                                                    <span class="badge bg-info">Arrived at the station</span>
                                                                                                                @endif
                                                                                                            </td>
                                                                                                            <td>{{ $u->created_at->format('M. j, Y h:i A') }}</td>
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
                                                                    </form>
                                                                    
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