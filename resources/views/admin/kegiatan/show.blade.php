@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-calendar-event"></i> {{ $kegiatan->nama_kegiatan }}</h2>
            <p class="text-muted">Detail lengkap kegiatan</p>
        </div>
        <div>
            <a href="{{ route('admin.kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('admin.kegiatan.destroy', $kegiatan->id) }}" 
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Jenis Kegiatan</small>
                    <div class="mt-2">
                        @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                            <span class="badge bg-info fs-6">Penyuluhan</span>
                        @else
                            <span class="badge bg-warning fs-6">Pembinaan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Lokasi</small>
                    <div class="mt-2">
                        <strong>{{ $kegiatan->lokasi->nama_kabupaten }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Tahun</small>
                    <div class="mt-2">
                        <strong class="fs-5">{{ $kegiatan->tahun }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Tanggal</small>
                    <div class="mt-2">
                        <small>
                            {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }}<br>
                            s/d<br>
                            {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    @if($kegiatan->deskripsi)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Deskripsi</h5>
        </div>
        <div class="card-body">
            {{ $kegiatan->deskripsi }}
        </div>
    </div>
    @endif

    <!-- Peserta Section -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta_count }})</h5>
            <a href="{{ route('admin.peserta.create') }}?kegiatan_id={{ $kegiatan->id }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus"></i> Tambah Peserta
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan->peserta as $p)
                    <tr>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->instansi ?? '-' }}</td>
                        <td>{{ $p->email ?? '-' }}</td>
                        <td>{{ $p->no_telp ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.peserta.edit', $p->id) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.peserta.destroy', $p->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada peserta</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Arsip Section -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip_count }})</h5>
            <a href="{{ route('admin.arsip.create') }}?kegiatan_id={{ $kegiatan->id }}" class="btn btn-sm btn-primary">
                <i class="bi bi-cloud-upload"></i> Upload File
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>Tipe</th>
                        <th>Ukuran</th>
                        <th>Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan->arsip as $a)
                    <tr>
                        <td><i class="bi bi-file-earmark"></i> {{ $a->nama_file }}</td>
                        <td>
                            @php
                                $colors = [
                                    'pdf' => 'danger',
                                    'jpg' => 'info',
                                    'jpeg' => 'info',
                                    'png' => 'info',
                                    'doc' => 'primary',
                                    'docx' => 'primary'
                                ];
                                $color = $colors[$a->tipe_file] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ strtoupper($a->tipe_file) }}</span>
                        </td>
                        <td>{{ $a->formatted_file_size }}</td>
                        <td><small>{{ $a->created_at->format('d M Y') }}</small></td>
                        <td>
                            <a href="{{ route('admin.arsip.show', $a->id) }}" 
                               class="btn btn-sm btn-info" download>
                                <i class="bi bi-download"></i>
                            </a>
                            <form action="{{ route('admin.arsip.destroy', $a->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada arsip</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
