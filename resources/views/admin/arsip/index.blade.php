@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-file-earmark"></i> Manajemen Arsip</h2>
            <p class="text-muted">Total: {{ $arsip->total() }} file</p>
        </div>
        <a href="{{ route('admin.arsip.create') }}" class="btn btn-primary">
            <i class="bi bi-cloud-upload"></i> Upload Arsip
        </a>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama File</th>
                        <th>Kegiatan</th>
                        <th>Tipe</th>
                        <th>Ukuran</th>
                        <th>Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $a)
                    <tr>
                        <td>{{ ($arsip->currentPage() - 1) * $arsip->perPage() + $loop->iteration }}</td>
                        <td>
                            <i class="bi bi-file-earmark"></i>
                            <strong>{{ $a->nama_file }}</strong>
                        </td>
                        <td>{{ $a->kegiatan->nama_kegiatan }}</td>
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
                        <td>{{ $a->created_at->format('d M Y') }}</td>
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
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada arsip
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $arsip->links() }}
    </div>
</div>

@endsection