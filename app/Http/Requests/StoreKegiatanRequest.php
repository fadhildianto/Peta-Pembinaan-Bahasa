<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKegiatanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|in:penyuluhan,pembinaan',
            'tahun' => 'required|integer|min:2000|max:2100',
            'lokasi_id' => 'required|exists:lokasis,id',
            'deskripsi' => 'nullable|string|max:1000',
            'tanggal_mulai' => 'required|date|date_format:Y-m-d',
            'tanggal_selesai' => 'required|date|date_format:Y-m-d|after_or_equal:tanggal_mulai',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_kegiatan.required' => 'Nama kegiatan harus diisi',
            'nama_kegiatan.max' => 'Nama kegiatan maksimal 255 karakter',
            'jenis_kegiatan.required' => 'Jenis kegiatan harus dipilih',
            'jenis_kegiatan.in' => 'Jenis kegiatan hanya bisa penyuluhan atau pembinaan',
            'tahun.required' => 'Tahun harus diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'lokasi_id.required' => 'Lokasi harus dipilih',
            'lokasi_id.exists' => 'Lokasi tidak ditemukan',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_mulai.date_format' => 'Format tanggal mulai: YYYY-MM-DD',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai',
        ];
    }
}
