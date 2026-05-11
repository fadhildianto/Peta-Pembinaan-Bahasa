@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="admin-page-hero d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2><i class="bi bi-calendar-event"></i> Manajemen Kegiatan</h2>
            <p>Total: {{ $kegiatan->total() }} kegiatan</p>
        </div>
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-light text-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kegiatan
        </a>
    </div>

    <!-- Filters -->
    <div class="card admin-card-interactive admin-toolbar-card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kegiatan.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama kegiatan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="penyuluhan" @if(request('jenis') == 'penyuluhan') selected @endif>Penyuluhan</option>
                        <option value="pembinaan" @if(request('jenis') == 'pembinaan') selected @endif>Pembinaan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for($year = now()->year; $year >= 2020; $year--)
                            <option value="{{ $year }}" @if(request('tahun') == $year) selected @endif>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card admin-card-interactive">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kegiatan</th>
                        <th>Jenis</th>
                        <th>Tahun</th>
                        <th>Lokasi</th>
                        <th>Peserta</th>
                        <th>Arsip</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $k)
                    <tr>
                        <td>{{ ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + $loop->iteration }}</td>
                        <td>
                            <strong>{{ $k->nama_kegiatan }}</strong>
                        </td>
                        <td>
                            @if(in_array(strtolower($k->jenis_kegiatan), ['penyuluhan', 'penyuluhan bahasa']))
                                <span class="badge bg-info">Penyuluhan</span>
                            @else
                                <span class="badge bg-warning">Pembinaan</span>
                            @endif
                        </td>
                        <td>{{ $k->tahun }}</td>
                        <td>{{ $k->lokasi->nama_kabupaten ?? '-' }}</td>
                        <td><span class="badge bg-primary">{{ $k->peserta_count }}</span></td>
                        <td><span class="badge bg-secondary">{{ $k->arsip_count }}</span></td>
                        <td>
                            <small>
                                @if($k->tanggal_mulai && $k->tanggal_selesai)
                                    {{ $k->tanggal_mulai->format('d M') }} - {{ $k->tanggal_selesai->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </small>
                        </td>
                        <td>
                            <div class="admin-action-group">
                            <a href="{{ route('admin.kegiatan.show', $k->id) }}" 
                               class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.kegiatan.edit', $k->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.kegiatan.destroy', $k->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus kegiatan dan data terkaitnya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center admin-empty-state">
                            <i class="bi bi-calendar-x"></i>
                            Belum ada kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $kegiatan->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
