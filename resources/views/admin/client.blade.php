@extends('layouts.admin.client')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">List of Clients Account</h2>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-user-plus"></i> Add Acount</button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"> Add Clients Acount</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ url('register.action') }}">
                                                    @csrf

                                                    <div class="mb-3 row">
                                                        <label for="name" class="col-md-4 col-form-label text-md-end form-label">{{ __('Company Name') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="email" class="col-md-4 col-form-label text-md-end form-label">{{ __('Email Address') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>                         

                                                    <div class="mb-3 row">
                                                        <label for="phone_num" class="col-md-4 col-form-label text-md-end form-label">{{ __('Phone Number') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="phone_num" type="tel" class="form-control @error('phone_num') is-invalid @enderror" name="phone_num" value="{{ old('phone_num') }}" required autocomplete="phone_num" pattern="^\+[1-9]\d{1,14}$">
                                                            @error('phone_num')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row">
                                                        <label for="copyEmail" class="col-md-4 col-form-label text-md-end form-label">{{ __('Password') }}</label>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input id="copyEmail" readonly name="password" type="password" class="form-control">
                                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="mb-0 row">
                                                        <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-block w-100">
                                                            <i class="fas fa-user-plus"></i> {{ __('Add Account') }}
                                                        </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="container">
                                        <div class="card mt-3 mb-5 bg-light">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example" class="table table-bordered table-hover">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Company Name</th>
                                                                <th scope="col">User Status</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($users as $user)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                    <td>{{ $user->name }}</td>
                                                                    <td>
                                                                        @if ($user->is_disabled == 0)
                                                                            <span class="badge text-bg-success">Active</span>
                                                                        @else
                                                                            <span class="badge text-bg-danger">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $user->id }}"><i class="fas fa-edit fa-sm text-success fa-lg"></i></button>

                                                                        <!-- Modal -->

                                                                        <div class="modal fade" id="exampleModal1{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Company Details</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <form action="{{ route('update.user', ['id' => $user->id]) }}" method="POST" class="row g-3 needs-validation" novalidate>
                                                                                            @csrf
                                                                                            @method('PUT') <!-- Add this line -->

                                                                                            <div class="form-floating">
                                                                                                <input type="text" readonly id="validationCustom01 floatingInput" name="name" value="{{ $user->name }}" class="form-control" placeholder="Company Name" required>
                                                                                                <label for="floatingInput">Company Name</label>
                                                                                                <div class="valid-feedback">
                                                                                                    Looks good!
                                                                                                </div>
                                                                                                <div class="invalid-feedback">
                                                                                                    Please choose a Company Name.
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-floating">
                                                                                                <input type="text" readonly class="form-control" placeholder="Email Address" name="email" value="{{ $user->email }}" id="validationCustom02 floatingInput" required>
                                                                                                <label for="floatingInput">Email Address</label>
                                                                                                <div class="valid-feedback">
                                                                                                    Looks good!
                                                                                                </div>
                                                                                                <div class="invalid-feedback">
                                                                                                    Please choose an Email Address.
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-floating">
                                                                                                <input type="text" readonly class="form-control" placeholder="Phone Number" name="phone" value="{{ $user->phone_num }}"id="validationCustom02 floatingInput" required>
                                                                                                <label for="floatingInput">Phone Number</label>
                                                                                                <div class="valid-feedback">
                                                                                                    Looks good!
                                                                                                </div>
                                                                                                <div class="invalid-feedback">
                                                                                                    Please choose a Phone Number.
                                                                                                </div>
                                                                                            </div>                                                            

                                                                                            <div class="">
                                                                                                <label for="validationCustom04" class="form-label">User Status</label>
                                                                                                <select class="form-select" id="status" name="status" required>
                                                                                                    <option value="0" {{ $user->is_disabled == '0' ? 'selected' : '' }}>Active</option>
                                                                                                    <option value="1" {{ $user->is_disabled == '1' ? 'selected' : '' }}>Inactive</option>
                                                                                                </select>
                                                                                            </div>

                                                                                            <div class="modal-footer">
                                                                                                <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                                                                                            </div>


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