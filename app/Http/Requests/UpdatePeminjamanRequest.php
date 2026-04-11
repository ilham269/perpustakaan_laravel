<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_request' => 'required|date',
            'tanggal_pinjam' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:pending,disetujui,ditolak,dikembalikan',
        ];
    }
}
