@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 py-4">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-grd-info text-white">
                        Change Password
                    </div>

                    <div class="card-body px-4">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="mb-2">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                {{-- <a href="{{ url()->previous() }}" class="btn  text-white">Cancel</a>
                                <button type="submit" class="btn  text-white">Update</button> --}}
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
