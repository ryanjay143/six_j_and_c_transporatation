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
                                        <div class="table-responsive">
                                            <table id="table" class="table table-hover table-bordered">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Billing period</th>
                                                        <th scope="col">Total amount</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($billing as $b)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ \Carbon\Carbon::parse($b->billing_start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($b->billing_end_date)->format('M d, Y') }}</td>
                                                            <td>&#8369; {{ $b->total_amount }}</td>
                                                            <td>
                                                                @if ($b->status == 0)
                                                                    <span class="badge bg-secondary">Unpaid</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view.billings.for.client', $b->id) }}" type="button" class="btn btn-outline-primary">
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