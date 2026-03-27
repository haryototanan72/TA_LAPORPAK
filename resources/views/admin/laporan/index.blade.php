@extends('layouts.adminlayout')

@section('content')
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="fw-bold mb-4" style="letter-spacing: 1px; color: #2763ba;">Laporan</h2>
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="d-flex align-items-center mb-3 gap-2">
                        <label class="mb-0">Filter</label>
                        <select name="tanggal" class="form-select w-auto">
                            <option value="">Urutkan Tanggal</option>
                            <option value="terbaru" {{ request('tanggal') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('tanggal') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                        <select name="status" class="form-select w-auto">
                            <option value="">Status Laporan</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="ditindaklanjuti" {{ request('status') == 'ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                            <option value="ditanggapi" {{ request('status') == 'ditanggapi' ? 'selected' : '' }}>Ditanggapi</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Terapkan</button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-danger ms-auto">
                            <i class="bi bi-arrow-clockwise"></i> Atur Ulang Filter
                        </a>
                    </form>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nomor Laporan</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $index => $laporan)
                                <tr>
                                    <td>{{ $laporans->firstItem() + $index }}</td>
                                    <td>{{ $laporan->nomor_laporan }}</td>
                                    <td>{{ $laporan->user->role === 'user' ? $laporan->user->name : '********************' }}</td>
                                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($laporan->status == 'diajukan')
                                            <span class="badge bg-secondary">Diajukan</span>
                                        @elseif($laporan->status == 'diverifikasi')
                                            <span class="badge bg-info text-dark">Diverifikasi</span>
                                        @elseif($laporan->status == 'diterima')
                                            <span class="badge bg-primary">Diterima</span>
                                        @elseif($laporan->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($laporan->status == 'ditindaklanjuti')
                                            <span class="badge bg-warning text-dark">Ditindaklanjuti</span>
                                        @elseif($laporan->status == 'ditanggapi')
                                            <span class="badge bg-info text-dark">Ditanggapi</span>
                                        @elseif($laporan->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ ucfirst($laporan->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.laporan.detail', $laporan->nomor_laporan) }}" class="btn btn-warning btn-sm text-white" style="background: #fbb03b; border: none; font-weight: 600;">
                                            Detail
                                        </a>
                                        @if(in_array($laporan->status, ['ditolak', 'selesai']))
                                            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="font-weight:600;">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $laporans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
