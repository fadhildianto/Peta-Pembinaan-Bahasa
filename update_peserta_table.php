<?php
$filePath = 'resources/views/peta/detail.blade.php';
$content = file_get_contents($filePath);

$oldText = <<<'EOL'
                                        <!-- Peserta Section -->
                                        <div style="padding: 20px; background: #fafafa;">
                                            <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                            </h6>
                                            @if($kegiatan->peserta()->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0 participant-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px;">No.</th>
                                                                <th>Nama Peserta</th>
                                                                <th>Asal Instansi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($kegiatan->peserta as $p)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}.</td>
                                                                <td>{{ $p->nama }}</td>
                                                                <td>{{ $p->instansi ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Belum ada peserta</p>
                                            @endif
                                        </div>
EOL;

$newText = <<<'EOL'
                                        <!-- Peserta Section -->
                                        <div style="padding: 20px; background: #fafafa;">
                                            <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                                <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                            </h6>
                                            @if($kegiatan->peserta()->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0 participant-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 70px;">No.</th>
                                                                @if($kegiatan->jenis_kegiatan !== 'Pembinaan Lembaga')
                                                                <th>Nama Peserta</th>
                                                                @endif
                                                                <th>Asal Instansi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($kegiatan->peserta as $p)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}.</td>
                                                                @if($kegiatan->jenis_kegiatan !== 'Pembinaan Lembaga')
                                                                <td>{{ $p->nama }}</td>
                                                                @endif
                                                                <td>{{ $p->instansi ?? '-' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted">Belum ada peserta</p>
                                            @endif
                                        </div>
EOL;

$newContent = str_replace($oldText, $newText, $content);

if ($newContent !== $content) {
    file_put_contents($filePath, $newContent);
    echo "✓ File berhasil diperbarui!\n";
} else {
    echo "✗ Pattern tidak ditemukan\n";
}
?>
