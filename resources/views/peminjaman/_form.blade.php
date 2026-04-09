<div class="form-group-custom">
    <label for="user_id">Peminjam</label>
    <select id="user_id" name="user_id"
            class="form-input {{ $errors->has('user_id') ? 'is-invalid' : '' }}" required>
        <option value="">-- Pilih Peminjam --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                {{ old('user_id', $peminjaman->user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('user_id') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group-custom">
    <label for="buku_id">Buku</label>
    <select id="buku_id" name="buku_id"
            class="form-input {{ $errors->has('buku_id') ? 'is-invalid' : '' }}" required>
        <option value="">-- Pilih Buku --</option>
        @foreach ($bukus as $buku)
            <option value="{{ $buku->id }}"
                {{ old('buku_id', $peminjaman->buku_id ?? '') == $buku->id ? 'selected' : '' }}>
                {{ $buku->judul }} (Stok: {{ $buku->stok }})
            </option>
        @endforeach
    </select>
    @error('buku_id') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_request">Tanggal Request</label>
            <input type="date" id="tanggal_request" name="tanggal_request"
                   class="form-input {{ $errors->has('tanggal_request') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_request', isset($peminjaman) ? $peminjaman->tanggal_request?->format('Y-m-d') : '') }}"
                   required>
            @error('tanggal_request') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_pinjam">Tanggal Pinjam <span class="text-muted">(opsional)</span></label>
            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
                   class="form-input {{ $errors->has('tanggal_pinjam') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_pinjam', isset($peminjaman) ? $peminjaman->tanggal_pinjam?->format('Y-m-d') : '') }}">
            @error('tanggal_pinjam') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="tanggal_kembali">Tanggal Kembali <span class="text-muted">(opsional)</span></label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali"
                   class="form-input {{ $errors->has('tanggal_kembali') ? 'is-invalid' : '' }}"
                   value="{{ old('tanggal_kembali', isset($peminjaman) ? $peminjaman->tanggal_kembali?->format('Y-m-d') : '') }}">
            @error('tanggal_kembali') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group-custom">
            <label for="status">Status</label>
            <select id="status" name="status"
                    class="form-input {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                @foreach (['pending', 'disetujui', 'ditolak', 'dikembalikan'] as $s)
                    <option value="{{ $s }}"
                        {{ old('status', $peminjaman->status ?? 'pending') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                @endforeach
            </select>
            @error('status') <span class="form-error">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
