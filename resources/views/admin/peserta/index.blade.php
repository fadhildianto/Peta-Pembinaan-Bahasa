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
                        <th>Nama</th>
                        <th>Kegiatan</th>
                        <th>Instansi</th>
                        <th>Email</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peserta as $p)
                    <tr>
                        <td>{{ ($peserta->currentPage() - 1) * $peserta->perPage() + $loop->iteration }}</td>
                        <td>
                            <strong>{{ $p->nama }}</strong>
                        </td>
                        <td>{{ $p->kegiatan->nama_kegiatan }}</td>
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
        {{ $peserta->links() }}
    </div>
</div>

@endsection