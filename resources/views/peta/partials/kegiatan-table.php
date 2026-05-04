<?php
@if($kegiatans->count() > 0)
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead style="background: #f8f9fa; border-bottom: 2px solid #003d7a;">
            <tr>
                <th style="color: #003d7a; font-weight: 700;">Nama Kegiatan</th>
                <th style="color: #003d7a; font-weight: 700;">Jenis</th>
                <th style="color: #003d7a; font-weight: 700;">Tahun</th>
                <th style="color: #003d7a; font-weight: 700;">Periode</th>
                <th style="color: #003d7a; font-weight: 700;">Peserta</th>
                <th style="color: #003d7a; font-weight: 700;">Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $kegiatan)
            <tr class="kegiatan-row">
                <td><strong style="color: #003d7a;">{{ $kegiatan->nama_kegiatan }}</strong></td>
                <td>
                    @if($kegiatan->jenis_kegiatan == 'penyuluhan')
                        <span class="badge badge-custom" style="background: #0dcaf0; color: white;">Penyuluhan</span>
                    @else
                        <span class="badge badge-custom" style="background: #ffc107; color: #333;">Pembinaan</span>
                    @endif
                </td>
                <td><strong>{{ $kegiatan->tahun }}</strong></td>
                <td>
                    <small style="color: #666;">
                        {{ $kegiatan->tanggal_mulai?->format('d M Y') ?? '-' }}<br>
                        s/d<br>
                        {{ $kegiatan->tanggal_selesai?->format('d M Y') ?? '-' }}
                    </small>
                </td>
                <td>
                    <span class="badge" style="background: #003d7a; color: white;">
                        {{ $kegiatan->peserta_count }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm collapse-btn btn-outline-primary" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#detail{{ $kegiatan->id }}">
                        <i class="bi bi-chevron-down"></i> Buka
                    </button>
                </td>
            </tr>

            <!-- Detail Kegiatan (Collapsible) -->
            <tr class="table-light">
                <td colspan="6" style="padding: 0; border: none;">
                    <div class="collapse" id="detail{{ $kegiatan->id }}">
                        <div style="padding: 0;">
                            <!-- Deskripsi Container -->
                            @if($kegiatan->deskripsi || $kegiatan->tanggal_mulai || $kegiatan->peserta()->count() > 0)
                            <div style="background: linear-gradient(135deg, rgba(0,61,122,0.05) 0%, rgba(255,193,7,0.05) 100%); border-left: 5px solid #003d7a; padding: 30px; margin-bottom: 20px;">
                    
                                <div style="margin-bottom: 20px;">
                                    <div style="color: #003d7a; font-weight: 700; font-size: 16px;">Tahun {{ $kegiatan->tahun }}</div>
                                </div>

                                <div style="margin-bottom: 15px;">
                                    <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Nama Kegiatan</div>
                                    <div style="color: #555; font-size: 14px;">{{ $kegiatan->nama_kegiatan }}</div>
                                </div>

                                <div style="margin-bottom: 15px;">
                                    <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Waktu Pelaksanaan</div>
                                    <div style="color: #555; font-size: 14px;">
                                        {{ $kegiatan->tanggal_mulai?->format('d F Y') ?? '-' }} - {{ $kegiatan->tanggal_selesai?->format('d F Y') ?? '-' }}
                                    </div>
                                </div>

                                @if($kegiatan->deskripsi)
                                <div style="margin-bottom: 15px;">
                                    <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Tujuan Kegiatan</div>
                                    <div style="color: #555; font-size: 14px; line-height: 1.7;">
                                        {!! nl2br(e($kegiatan->deskripsi)) !!}
                                    </div>
                                </div>
                                @endif

                                @if($kegiatan->peserta()->count() > 0)
                                <div style="margin-bottom: 0;">
                                    <div style="color: #003d7a; font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 6px;">Narasumber</div>
                                    <ul style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                                        @foreach($kegiatan->peserta as $p)
                                        <li style="margin-bottom: 8px;">
                                            <strong>{{ $p->nama }}</strong>
                                            @if($p->instansi)
                                            <small style="color: #666;">
                                                <i class="bi bi-building"></i> {{ $p->instansi }}
                                            </small><br>
                                            @endif
                                            @if($p->email)
                                            <small style="color: #999;">
                                                <i class="bi bi-envelope"></i> {{ $p->email }}
                                            </small>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                    
                            </div>
                            @endif

                            <!-- Peserta & Arsip Section -->
                            <div style="padding: 20px; background: #fafafa;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                            <i class="bi bi-people"></i> Peserta ({{ $kegiatan->peserta()->count() }})
                                        </h6>
                                        @if($kegiatan->peserta()->count() > 0)
                                            <div class="peserta-list">
                                                @foreach($kegiatan->peserta as $p)
                                                <div class="peserta-item">
                                                    <strong style="color: #003d7a;">{{ $p->nama }}</strong><br>
                                                    @if($p->instansi)
                                                    <small style="color: #666;">
                                                        <i class="bi bi-building"></i> {{ $p->instansi }}
                                                    </small><br>
                                                    @endif
                                                    @if($p->email)
                                                    <small style="color: #999;">
                                                        <i class="bi bi-envelope"></i> {{ $p->email }}
                                                    </small>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum ada peserta</p>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <h6 style="color: #003d7a; font-weight: 700; margin-bottom: 12px;">
                                            <i class="bi bi-file-earmark"></i> Arsip ({{ $kegiatan->arsip()->count() }})
                                        </h6>
                                        @if($kegiatan->arsip()->count() > 0)
                                            <div class="arsip-list">
                                                @foreach($kegiatan->arsip as $a)
                                                <div class="arsip-item">
                                                    <strong style="color: #003d7a;">{{ $a->nama_file }}</strong><br>
                                                    <small style="color: #666;">
                                                        <i class="bi bi-file-earmark"></i> {{ strtoupper($a->tipe_file) }}<br>
                                                        <i class="bi bi-file-size"></i> {{ $a->formatted_file_size }}
                                                    </small>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum ada arsip</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="card-body text-center" style="padding: 40px;">
    <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
    <p class="text-muted mt-3">Belum ada kegiatan di kategori ini</p>
</div>
@endif