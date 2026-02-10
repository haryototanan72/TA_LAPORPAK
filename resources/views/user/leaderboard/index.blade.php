@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">🏆 Leaderboard Pelapor Teraktif</h3>

    {{-- Info user login --}}
    <div class="alert alert-info">
        Posisi kamu saat ini: <strong>#{{ $userRank }}</strong>  
        ({{ auth()->user()->points }} poin)
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama</th>
                <th>Title</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaderboard as $index => $user)
                <tr class="{{ auth()->id() == $user->id ? 'table-success' : '' }}">
                    <td>#{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        {{ $user->title ?? '-' }}
                    </td>
                    <td>{{ $user->points }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
