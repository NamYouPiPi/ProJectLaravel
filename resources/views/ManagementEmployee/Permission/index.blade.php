@extends('Backend.layouts.app')
@section('title', 'Permission Management')
@section('menu-open', 'menu-open')
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Permission Management</h4>
            </div>

            @include('Backend.components.Toast')
            <form action="{{ route('permissions.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-white">Permission Groups</th>
                                @foreach($roles as $role)
                                    <th class="text-center text-white">
                                        {{ ucfirst($role->name) }}
                                        @if($role->is_protected)
                                            <i class="fas fa-lock text-warning" title="Protected Role"></i>
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $group => $permissionList)
                                <tr class="table-primary">
                                    <td colspan="{{ count($roles) + 1 }}" class="fw-bold">
                                        {{ ucwords(str_replace('_', ' ', $group)) }}
                                    </td>
                                </tr>
                                @foreach($permissionList as $permission)
                                    <tr>
                                        <td>{{ $permission->display_name }}</td>
                                        @foreach($roles as $role)
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="permissions[{{ $role->id }}][]" value="{{ $permission->id }}"
                                                        @if($role->permissions->contains($permission->id)) checked @endif
                                                        @if($role->is_protected) disabled @endif>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Permissions
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    @push('styles')
        <style>
            .form-check-input:checked {
                background-color: #0d6efd;
                border-color: #0d6efd;
            }

            .form-check-input:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .table th {
                background-color: #343a40;
            }

            .table-primary {
                background-color: #cfe2ff;
            }

            .fas.fa-lock {
                font-size: 0.8rem;
                margin-left: 0.5rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Enable Bootstrap tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Handle form submission
                const form = document.querySelector('form');
                form.addEventListener('submit', function (e) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
                });
            });
        </script>
    @endpush
@endsection
