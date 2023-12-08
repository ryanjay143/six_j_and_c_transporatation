@extends('layouts.user.billings')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
            <h2 class="mt-4">{{ __('List of Billing') }}</h2>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Payment Reports</li>
                    </ol>
                </nav> -->
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mr-sm-3 border border-primary w-100">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active me-2" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Unpaid billing <span class="badge rounded-pill bg-danger">
                                                    {{ $countUnpaidBilling }}
                                                </span></button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Paid billing</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                <div class="table-responsive mt-3">
                                                    <table id="table" class="table table-hover table-bordered">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Billing period</th>
                                                                <th scope="col">Total amount</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($unpaidBilling as $b)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                    <td>{{ \Carbon\Carbon::parse($b->billing_start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($b->billing_end_date)->format('M d, Y') }}</td>
                                                                    <td>&#8369; {{ $b->total_amount }}</td>
                                                                    <td>
                                                                        <a href="{{ route('view.billings.for.client', $b->id) }}" type="button" class="btn btn-outline-primary btn-sm">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                                <div class="table-responsive mt-3">
                                                    <table id="example" class="table table-hover table-bordered">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Invoice number</th>
                                                                <th scope="col">Billing period</th>
                                                                <th scope="col">Total amount</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($paidBilling as $b)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                    <td>{{ $b->invoice_num }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($b->billing_start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($b->billing_end_date)->format('M d, Y') }}</td>
                                                                    <td>&#8369; {{ $b->total_amount }}</td>
                                                                    <td>
                                                                        <a href="{{ route('view.billings.for.client', $b->id) }}" type="button" class="btn btn-outline-primary btn-sm">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
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