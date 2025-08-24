@extends('Backend.layout.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Audit Log Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('audit-logs.index') }}">Audit Logs</a></li>
        <li class="breadcrumb-item active">Log #{{ $auditLog->id }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Log Information
            <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-secondary float-end">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Log ID</th>
                            <td>{{ $auditLog->id }}</td>
                        </tr>
                        <tr>
                            <th>User</th>
                            <td>
                                @if($auditLog->user)
                                    {{ $auditLog->user->name }} (ID: {{ $auditLog->user_id }})
                                @else
                                    <span class="text-muted">Unknown User</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>User Type</th>
                            <td>{{ $auditLog->user_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Table</th>
                            <td>{{ ucfirst(str_replace('_', ' ', $auditLog->table_name)) }}</td>
                        </tr>
                        <tr>
                            <th>Record ID</th>
                            <td>{{ $auditLog->record_id }}</td>
                        </tr>
                        <tr>
                            <th>Action</th>
                            <td>
                                @if($auditLog->action == 'CREATE')
                                    <span class="badge bg-success">{{ $auditLog->formatted_action }}</span>
                                @elseif($auditLog->action == 'UPDATE')
                                    <span class="badge bg-warning">{{ $auditLog->formatted_action }}</span>
                                @elseif($auditLog->action == 'DELETE')
                                    <span class="badge bg-danger">{{ $auditLog->formatted_action }}</span>
                                @else
                                    <span class="badge bg-info">{{ $auditLog->formatted_action }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Timestamp</th>
                            <td>{{ $auditLog->timestamp->format('F j, Y, g:i a') }}</td>
                        </tr>
                        <tr>
                            <th>IP Address</th>
                            <td>{{ $auditLog->ip_address ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>User Agent</h5>
                    <div class="border p-3 mb-4" style="height: 100px; overflow-y: auto;">
                        {{ $auditLog->user_agent ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="valuesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="changes-tab" data-bs-toggle="tab" data-bs-target="#changes" type="button" role="tab" aria-controls="changes" aria-selected="true">
                                Changes Summary
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="old-values-tab" data-bs-toggle="tab" data-bs-target="#old-values" type="button" role="tab" aria-controls="old-values" aria-selected="false">
                                Old Values
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="new-values-tab" data-bs-toggle="tab" data-bs-target="#new-values" type="button" role="tab" aria-controls="new-values" aria-selected="false">
                                New Values
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-3 border border-top-0" id="valuesTabsContent">
                        <!-- Changes Summary Tab -->
                        <div class="tab-pane fade show active" id="changes" role="tabpanel" aria-labelledby="changes-tab">
                            @if($auditLog->action == 'UPDATE' && $auditLog->old_values && $auditLog->new_values)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Old Value</th>
                                                <th>New Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditLog->new_values as $key => $value)
                                                @if(isset($auditLog->old_values[$key]) && $auditLog->old_values[$key] != $value)
                                                    <tr>
                                                        <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                        <td>{{ is_array($auditLog->old_values[$key]) ? json_encode($auditLog->old_values[$key]) : $auditLog->old_values[$key] }}</td>
                                                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($auditLog->action == 'CREATE')
                                <div class="alert alert-info">
                                    This record was created with the values shown in the "New Values" tab.
                                </div>
                            @elseif($auditLog->action == 'DELETE')
                                <div class="alert alert-danger">
                                    This record was deleted. The deleted data is shown in the "Old Values" tab.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    No change summary available for this action.
                                </div>
                            @endif
                        </div>

                        <!-- Old Values Tab -->
                        <div class="tab-pane fade" id="old-values" role="tabpanel" aria-labelledby="old-values-tab">
                            @if($auditLog->old_values)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditLog->old_values as $key => $value)
                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                    <td>
                                                        @if(is_array($value))
                                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">No old values recorded for this action.</div>
                            @endif
                        </div>

                        <!-- New Values Tab -->
                        <div class="tab-pane fade" id="new-values" role="tabpanel" aria-labelledby="new-values-tab">
                            @if($auditLog->new_values)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auditLog->new_values as $key => $value)
                                                <tr>
                                                    <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                    <td>
                                                        @if(is_array($value))
                                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">No new values recorded for this action.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
