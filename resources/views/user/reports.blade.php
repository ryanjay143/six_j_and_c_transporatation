@extends('layouts.user.reports')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <h2 class="mt-4">{{ __('Payment Reports') }}</h2>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mr-sm-3 border border-primary w-100">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Billing Peroid</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Payment method</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payment as $b)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ date('F j', strtotime($b->billing->billing_start_date)) }}- {{ date('F j, Y', strtotime($b->billing->billing_end_date)) }} </td>
                                                            <td>&#8369; {{ number_format($b->amount, 2) }}</td>
                                                            <td>
                                                                @if ($b->payment_method == 'Chique')
                                                                    <span class="badge border border-dark bg-success">Chique</span>
                                                                @elseif ($b->payment_method == 'Bank Transfer')
                                                                    <span class="badge border border-dark bg-primary">Bank Transfer</span>
                                                                @else
                                                                    <span class="badge text-dark border border-dark bg-light">Cash</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view.billing.for.client', $b->id) }}" type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i></a>
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