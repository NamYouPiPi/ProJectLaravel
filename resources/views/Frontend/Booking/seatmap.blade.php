@extends('layouts.app')

@section('content')
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th colspan="{{ $seats->max(fn($row) => $row->count()) + 2 }}">
                    <div style="height:8px;background:linear-gradient(to right, #f00, #c00);border-radius:8px;"></div>
                    <div class="fw-bold mt-2">SCREEN</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($seats as $rowLetter => $rowSeats)
                <tr>
                    <td class="fw-bold">{{ $rowLetter }}</td>
                    @foreach($rowSeats as $seat)
                        <td>
                            {{ $rowLetter }}{{ $seat->seat_number }}
                            {{-- Add seat status, button, etc. here if needed --}}
                        </td>
                    @endforeach
                    <td class="fw-bold">{{ $rowLetter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection 
