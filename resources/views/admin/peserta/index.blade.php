@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-people"></i> Manajemen Peserta</h2>
            <p class="text-muted">Total: {{ $peserta->total() }} peserta</p>
        </div>
        <a href="{{ route('admin.peserta.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Peserta
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama/Lembaga</th>
                        <th>Kegiatan</th>
                        <th>Jenis</th>
                        <th>Instansi</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta as $p)
                    <tr>
                        <td>{{ ($peserta->currentPage() - 1) * $peserta->perPage() + $loop->iteration }}</td>
                        <td>
                            <strong>
                                @if($p->kegiatan->jenis_kegiatan === 'Pembinaan Lembaga')
                                    {{ $p->instansi ?? '-' }}
                                @else
                                    {{ $p->nama ?? '-' }}
                                @endif
                            </strong>
                        </td>
                        <td>
                            <small>{{ $p->kegiatan->nama_kegiatan }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $p->kegiatan->jenis_kegiatan }}</span>
                        </td>
                        <td>
                            @if($p->kegiatan->jenis_kegiatan === 'Penyuluhan Bahasa')
                                <small>{{ $p->instansi ?? '-' }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td>
                            <small>
                                @if($p->email)
                                    <div>{{ $p->email }}</div>
                                @endif
                                @if($p->no_telp)
                                    <div>{{ $p->no_telp }}</div>
                                @endif
                                @if(!$p->email && !$p->no_telp)
                                    <span class="text-muted">-</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('admin.peserta.edit', $p->id) }}" 
                               class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.peserta.destroy', $p->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data peserta
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $peserta->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

