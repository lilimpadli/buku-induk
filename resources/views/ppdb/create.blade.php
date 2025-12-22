<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran PPDB</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --success-color: #48bb78;
            --warning-color: #f6ad55;
            --danger-color: #f56565;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: var(--dark-color);
            padding: 30px 0;
        }
        
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 25px 30px;
            position: relative;
        }
        
        .form-header h4 {
            font-weight: 600;
            margin: 0;
            font-size: 1.5rem;
        }
        
        .form-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--accent-color), var(--success-color));
        }
        
        .form-body {
            padding: 30px;
        }
        
        .section-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(76, 201, 240, 0.25);
        }
        
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger-color);
            padding-right: calc(1.5em + 1.25rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.325rem) center;
            background-size: calc(0.75em + 0.65rem) calc(0.75em + 0.65rem);
        }
        
        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
        
        .btn-outline-secondary {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid #6c757d;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        
        .alert-success {
            background-color: rgba(72, 187, 120, 0.15);
            color: #2f855a;
        }
        
        .alert-dismissible .btn-close {
            padding: 1rem 1rem;
        }
        
        .required {
            color: var(--danger-color);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .form-body {
                padding: 20px;
            }
            
            .form-header {
                padding: 20px;
            }
            
            .form-header h4 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h4><i class="fas fa-clipboard-list me-2"></i> Formulir Pendaftaran PPDB</h4>
            </div>
            <div class="form-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('ppdb.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle"></i> Informasi Pendaftaran
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Sesi PPDB <span class="required">*</span></label>
                                <select name="sesi_ppdb_id" class="form-select @error('sesi_ppdb_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Sesi --</option>
                                    @foreach($sesis as $s)
                                        <option value="{{ $s->id }}" {{ old('sesi_ppdb_id') == $s->id || ($sesi && $sesi->id == $s->id) ? 'selected' : '' }}>
                                            {{ $s->tahun_ajaran }} - {{ $s->nama_sesi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sesi_ppdb_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jalur PPDB <span class="required">*</span></label>
                                <select name="jalur_ppdb_id" class="form-select @error('jalur_ppdb_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jalur --</option>
                                    @foreach($jalurs as $j)
                                        <option value="{{ $j->id }}" {{ old('jalur_ppdb_id') == $j->id || ($jalur && $jalur->id == $j->id) ? 'selected' : '' }}>
                                            {{ $j->nama_jalur }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jalur_ppdb_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan Pilihan</label>
                                <select name="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id || ($jurusan && $jurusan->id == $j->id) ? 'selected' : '' }}>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="section-title">
                            <i class="fas fa-user"></i> Data Pribadi
                        </h5>
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       value="{{ old('tempat_lahir') }}" placeholder="Masukkan tempat lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">NISN</label>
                            <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" 
                                   value="{{ old('nisn') }}" maxlength="10" placeholder="Masukkan NISN (10 digit)">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                      rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="section-title">
                            <i class="fas fa-file-upload"></i> Upload Dokumen
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Foto <span class="required">*</span></label>
                                <input type="file" id="foto" name="foto[]" class="form-control @error('foto') is-invalid @enderror" 
                                       accept="image/*" required multiple onchange="previewMultiple(this, 'foto-preview-container')">
                                <div id="foto-preview-container" class="mt-2"></div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, Max: 2MB per file</small>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, Max: 2MB</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kartu Keluarga (KK) <span class="required">*</span></label>
                                <input type="file" id="kk" name="kk" class="form-control @error('kk') is-invalid @enderror" 
                                       accept="image/*,.pdf" required onchange="previewFile(this, 'kk-preview')">
                                <div class="mt-2">
                                    <img id="kk-preview" src="#" alt="Preview KK" class="img-thumbnail" style="max-width: 150px; display: none;">
                                    <div id="kk-preview-info" class="mt-2" style="display:none;"></div>
                                    <button type="button" id="kk-remove" class="btn btn-sm btn-outline-secondary mt-2" style="display:none;" onclick="removeFile('kk','kk-preview')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                @error('kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, PDF, Max: 2MB</small>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Akta Lahir <span class="required">*</span></label>
                                <input type="file" id="akta" name="akta" class="form-control @error('akta') is-invalid @enderror" 
                                       accept="image/*,.pdf" required onchange="previewFile(this, 'akta-preview')">
                                <div class="mt-2">
                                    <img id="akta-preview" src="#" alt="Preview Akta" class="img-thumbnail" style="max-width: 150px; display: none;">
                                    <div id="akta-preview-info" class="mt-2" style="display:none;"></div>
                                    <button type="button" id="akta-remove" class="btn btn-sm btn-outline-secondary mt-2" style="display:none;" onclick="removeFile('akta','akta-preview')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                @error('akta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, PDF, Max: 2MB</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ijazah/SKL <span class="required">*</span></label>
                                <input type="file" id="ijazah" name="ijazah" class="form-control @error('ijazah') is-invalid @enderror" 
                                       accept="image/*,.pdf" required onchange="previewFile(this, 'ijazah-preview')">
                                <div class="mt-2">
                                    <img id="ijazah-preview" src="#" alt="Preview Ijazah" class="img-thumbnail" style="max-width: 150px; display: none;">
                                    <div id="ijazah-preview-info" class="mt-2" style="display:none;"></div>
                                    <button type="button" id="ijazah-remove" class="btn btn-sm btn-outline-secondary mt-2" style="display:none;" onclick="removeFile('ijazah','ijazah-preview')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                @error('ijazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG, PDF, Max: 2MB</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Bukti Jalur</label>
                            <input type="file" id="bukti_jalur" name="bukti_jalur" class="form-control @error('bukti_jalur') is-invalid @enderror" 
                                   accept="image/*,.pdf" onchange="previewFile(this, 'bukti-jalur-preview')">
                            <div class="mt-2">
                                <img id="bukti-jalur-preview" src="#" alt="Preview Bukti Jalur" class="img-thumbnail" style="max-width: 150px; display: none;">
                                <div id="bukti-jalur-preview-info" class="mt-2" style="display:none;"></div>
                                <button type="button" id="bukti-jalur-remove" class="btn btn-sm btn-outline-secondary mt-2" style="display:none;" onclick="removeFile('bukti_jalur','bukti-jalur-preview')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                            @error('bukti_jalur')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            <small class="text-muted">Format: JPG, PNG, PDF, Max: 2MB (jika ada)</small>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('ppdb.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Preview JS -->
    <script>
        // preview for multiple files (used for `foto`)
        function previewMultiple(input, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            const files = input.files ? Array.from(input.files) : [];

            files.forEach((file, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'd-inline-block me-2 mb-2 text-center';

                const url = URL.createObjectURL(file);

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = url;
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '150px';
                    wrapper.appendChild(img);
                    img.onload = function() { URL.revokeObjectURL(url); };
                } else {
                    const link = document.createElement('a');
                    link.href = url;
                    link.target = '_blank';
                    link.textContent = file.name;
                    wrapper.appendChild(link);
                    setTimeout(() => URL.revokeObjectURL(url), 30000);
                }

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-outline-secondary mt-1 d-block';
                btn.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                btn.onclick = function() {
                    removeSingleFile(input, index);
                    previewMultiple(input, containerId);
                };
                wrapper.appendChild(btn);

                container.appendChild(wrapper);
            });
        }

        // remove a single file from a file input (uses DataTransfer)
        function removeSingleFile(input, removeIndex) {
            if (!input || !input.files) return;
            const dt = new DataTransfer();
            Array.from(input.files).forEach((file, i) => {
                if (i !== removeIndex) dt.items.add(file);
            });
            input.files = dt.files;
        }

        function previewFile(input, previewId) {
            const file = input.files && input.files[0];
            const img = document.getElementById(previewId);
            const infoId = previewId.replace('preview', 'preview-info');
            const info = document.getElementById(infoId);
            const removeId = previewId.replace('preview', 'remove');
            const removeBtn = document.getElementById(removeId);

            if (!file) {
                if (img) { img.style.display = 'none'; img.src = '#'; }
                if (info) { info.style.display = 'none'; info.innerHTML = ''; }
                if (removeBtn) removeBtn.style.display = 'none';
                return;
            }

            const url = URL.createObjectURL(file);

            if (file.type.startsWith('image/')) {
                if (img) {
                    img.src = url;
                    img.style.display = 'inline-block';
                }
                if (info) { info.style.display = 'none'; info.innerHTML = ''; }
            } else {
                if (img) { img.style.display = 'none'; img.src = '#'; }
                if (info) {
                    info.style.display = 'block';
                    const link = document.createElement('a');
                    link.href = url;
                    link.target = '_blank';
                    link.textContent = file.name;
                    info.innerHTML = '';
                    info.appendChild(link);
                }
            }

            if (removeBtn) removeBtn.style.display = 'inline-block';

            // revoke object URL after image loads to free memory
            if (file.type.startsWith('image/')) {
                img.onload = function() { URL.revokeObjectURL(url); };
            } else {
                // revoke after small timeout for non-images
                setTimeout(() => URL.revokeObjectURL(url), 30000);
            }
        }

        function removeFile(inputId, previewId) {
            const input = document.getElementById(inputId);
            const img = document.getElementById(previewId);
            const infoId = previewId.replace('preview', 'preview-info');
            const info = document.getElementById(infoId);
            const removeId = previewId.replace('preview', 'remove');
            const removeBtn = document.getElementById(removeId);

            if (input) {
                try {
                    input.value = '';
                } catch(e) {
                    // fallback for security: replace input element
                    const newInput = input.cloneNode(true);
                    newInput.value = '';
                    input.parentNode.replaceChild(newInput, input);
                }
            }
            if (img) { img.style.display = 'none'; img.src = '#'; }
            if (info) { info.style.display = 'none'; info.innerHTML = ''; }
            if (removeBtn) removeBtn.style.display = 'none';
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>