<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLokasiRequest extends FormRequest
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
            'nama_kabupaten' => 'required|string|max:255|unique:lokasis,nama_kabupaten',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'nullable|string|max:1000',
            'zoom_level' => 'nullable|integer|min:1|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_kabupaten.required' => 'Nama kabupaten harus diisi',
            'nama_kabupaten.unique' => 'Nama kabupaten sudah terdaftar',
            'nama_kabupaten.max' => 'Nama kabupaten maksimal 255 karakter',
            'latitude.required' => 'Latitude harus diisi',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude harus antara -90 sampai 90',
            'longitude.required' => 'Longitude harus diisi',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude harus antara -180 sampai 180',
            'zoom_level.integer' => 'Zoom level harus berupa angka',
            'zoom_level.min' => 'Zoom level minimal 1',
            'zoom_level.max' => 'Zoom level maksimal 20',
        ];
    }
}
