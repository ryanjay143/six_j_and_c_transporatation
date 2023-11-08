@extends('layouts.admin.reports')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('List of Employee') }}</h2>
                        <div class="row">
                            <div class="container">
                                <div class="card mb-3 bg-light">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Employee name</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee as $e)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $e->user->name }} {{ $e->user->lname }}</td>
                                                            <td>
                                                                @if ($e->position == 0)
                                                                    <p class="fw-bold">Driver</p>
                                                                @elseif ($e->position == 1)
                                                                    <p class="fw-bold">Helper</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view.payroll.details', $e->id) }}" type="button" class="btn btn-outline-primary btn-sm">
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
                </main>
            </div>
        </div>


@endsection