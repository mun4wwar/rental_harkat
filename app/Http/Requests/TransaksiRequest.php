<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $pelanggan_id
 * @property int $mobil_id
 * @property int|null $supir_id
 * @property string $tanggal_sewa
 * @property string $tanggal_kembali
 * @property int $status
 */

class TransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pelanggan_id'     => 'required|exists:pelanggans,id',
            'mobil_id'         => 'required|exists:mobils,id',
            'supir_id'         => 'nullable|exists:supirs,id', // Bisa null kalau sewa tanpa supir
            'tanggal_sewa'     => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_sewa',
            'status'           => 'required|in:1,2,3', // 1 = Booking, 2 = Berlangsung, 3 = Selesai
        ];
    }
    public function messages(): array
    {
        return [
            'pelanggan_id.required' => 'Pelanggan wajib dipilih.',
            'mobil_id.required'     => 'Mobil wajib dipilih.',
            'tanggal_sewa.required' => 'Tanggal sewa wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal sewa.',
            'status.in'             => 'Status hanya boleh 1 (Booking), 2 (Berlangsung), atau 3 (Selesai).',
        ];
    }
}
