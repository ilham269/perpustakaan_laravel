<div class="form-group-custom">
    <label for="judul">Judul Buku</label>
    <input type="text" id="judul" name="judul"
           class="form-input {{ $errors->has('judul') ? 'is-invalid' : '' }}"
           value="{{ old('judul', $buku->judul ?? '') }}"
           placeholder="Masukkan judul buku" required>
    @error('judul') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group-custom">
    <label for="penulis">Penulis</label>
    <input type="text" id="penulis" name="penulis"
           class="form-input {{ $errors->has('penulis') ? 'is-invalid' : '' }}"
           value="{{ old('penulis', $buku->penulis ?? '') }}"
           placeholder="Nama penulis" required>
    @error('penulis') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group-custom">
    <label for="stok">Stok</label>
    <input type="number" id="stok" name="stok" min="0"
           class="form-input {{ $errors->has('stok') ? 'is-invalid' : '' }}"
           value="{{ old('stok', $buku->stok ?? 0) }}"
           required>
    @error('stok') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group-custom">
    <label for="deskripsi">Deskripsi <span class="text-muted">(opsional)</span></label>
    <textarea id="deskripsi" name="deskripsi" rows="4"
              class="form-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
              placeholder="Deskripsi singkat buku...">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <span class="form-error">{{ $message }}</span> @enderror
</div>
<div class="form-group-custom">
    <label for="gambar">Cover Buku <span class="text-muted">(opsional)</span></label>

    {{-- PREVIEW GAMBAR --}}
    @if(!empty($buku->gambar))
        <div class="mb-2">
            <img src="{{ asset('storage/' . $buku->gambar) }}" 
                 style="width:100px; height:140px; object-fit:cover; border-radius:8px;">
        </div>
    @endif

    <input type="file" id="gambar" name="gambar"
           class="form-input {{ $errors->has('gambar') ? 'is-invalid' : '' }}"
           accept="image/*">

    @error('gambar') 
        <span class="form-error">{{ $message }}</span> 
    @enderror
</div>
