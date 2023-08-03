@extends('template')

@section('name_page')
<?php $page="buku"; ?>
@endsection

@section('konten')
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Pilih Kategori
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                        <a class="dropdown-item" href="#" data-filter="">Semua Kategori</a>
                                        @foreach ($kategori as $value)
                                            <a class="dropdown-item" href="#" data-filter="{{$value->nama_kategori}}">{{$value->nama_kategori}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <span class="mr-2">
                                    <a href="#" data-target="#modalTambahBuku" data-toggle="modal" class="btn btn-primary">Tambah Buku</a>
                                </span>
                                <span>
                                    <a href="{{route('buku.export')}}" class="btn btn-success">Export Data</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- tabel buku -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 5px">No.</th>
                                <th>Cover</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th style="width: 153px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($dataBuku->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data buku</td>
                                </tr>
                            @else
                            @foreach($dataBuku as $key=>$value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><img src="{{asset('storage/'.$value->cover_buku)}}" alt="{{$value->cover_buku}}" width="200px"></td>
                                <td>{{ $value->judul_buku}}</td>
                                <td>{{ $value->kategoriBuku->nama_kategori}}</td>
                                <td>{{ $value->jumlah}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="#" data-target="#modalDetailBuku{{$key}}" data-toggle="modal" class="btn btn-success" title="Detail Buku"><i class='fas fa-eye fa-sm'></i></a>
                                            <a href="#" data-target="#modalEditBuku{{$key}}" data-toggle="modal" class="btn btn-warning" title="Edit Buku"><i class='fas fa-pen fa-sm'></i></a>
                                            <a href="#" onclick="return showConfirm('{{ route('buku.hapus', ['id' => $value->id]) }}')" class="btn btn-danger" title="Hapus Buku"><i class='fas fa-trash fa-sm'></i></a>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <a href="#" data-target="#modalUploadBuku{{$key}}" data-toggle="modal" class="btn btn-secondary" title="Upload Buku">Upload Buku<i class='fas fa-upload fa-sm'></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Detail -->
                            <div class="modal fade" id="modalDetailBuku{{$key}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail Buku</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-center">
                                                <img src="{{asset('storage/'.$value->cover_buku)}}" alt="{{$value->cover_buku}}" width="200px">
                                            </div>
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" class="form-control" value="{{ $value->judul_buku }}" readonly>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kategori</label>
                                                        <input type="text" class="form-control" value="{{ $value->kategoriBuku->nama_kategori }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jumlah</label>
                                                        <input type="text" class="form-control" value="{{ $value->jumlah }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea class="form-control">{{ $value->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /. Modal Detail -->
                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditBuku{{$key}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Buku</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('buku.edit', ['id' => $value->id])}}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Judul <small style="color: red;">* Wajib diisi</small></label>
                                                <input type="text" value="{{$value->judul_buku}}" class="form-control" name="judul_buku" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kategori <small style="color: red;">* Wajib diisi</small></label>
                                                        <select class="custom-select" name="kategori" required>
                                                            @foreach ($kategori as $item)
                                                            <option value="{{$item->id}}" @if($value->id_kategori == $item->id) selected @endif>
                                                                {{$item->nama_kategori}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jumlah <small style="color: red;">* Wajib diisi</small></label>
                                                        <input type="number" value="{{$value->jumlah}}" class="form-control" name="jumlah" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi <small style="color: red;">* Wajib diisi</small></label>
                                                <textarea class="form-control" name="deskripsi" required>{{$value->deskripsi}}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="saveButton" class="btn btn-primary">Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /. Modal Edit -->
                            <!-- Modal Upload -->
                            <div class="modal fade" id="modalUploadBuku{{$key}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Upload Buku</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('buku.upload', ['id' => $value->id])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>File Buku <small style="color: red;">* Wajib diisi</small></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileTambah" name='fileBuku' accept="application/pdf" required>
                                                    <label class="custom-file-label" for="fileTambah">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="uploadButton" class="btn btn-primary">Upload</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /. Modal Upload -->
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Cover</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div><!--/. container-fluid -->
    </section>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahBuku">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Buku</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('buku.tambah')}}" method="post" id="tambahForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" name="judul_buku" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <small style="color: red;">* Wajib diisi</small></label>
                                <select class="custom-select" name="kategori" required>
                                    @foreach ($kategori as $value)
                                    <option value="{{$value->id}}">{{$value->nama_kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah <small style="color: red;">* Wajib diisi</small></label>
                                <input type="number" class="form-control" name="jumlah" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi <small style="color: red;">* Wajib diisi</small></label>
                        <textarea class="form-control" name="deskripsi" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cover Buku <small style="color: red;">* Wajib diisi</small></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="coverTambah" name='cover' accept="image/*" required>
                                    <label class="custom-file-label" for="coverTambah">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>File Buku <small style="color: red;">* Wajib diisi</small></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileTambah" name='fileBuku' accept="application/pdf" required>
                                    <label class="custom-file-label" for="fileTambah">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /. Modal Tambah -->

    {{-- Filter data --}}
    <script>
        // Fungsi untuk melakukan filter pada tabel berdasarkan kategori
        function filterTableByCategory(category) {
            var table, tr, td, i, txtValue;
            table = document.getElementById("example1");
            tr = table.getElementsByTagName("tr");

        // Loop melalui semua baris tabel dan menyembunyikan/menampilkan berdasarkan kategori
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (category === "" || txtValue.indexOf(category) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
            }
        }

        // Tangkap peristiwa saat dropdown dipilih
        document.querySelectorAll(".dropdown-item").forEach(function (item) {
            item.addEventListener("click", function () {
                var category = this.dataset.filter;
                filterTableByCategory(category);
            });
        });
    </script>
    
    {{-- disable tambah button --}}
    <script>
        // Fungsi untuk memeriksa apakah semua input required telah terisi
        function checkFormValidity() {
            const form = document.getElementById('tambahForm');
            const submitButton = document.getElementById('submitButton');

            if (form.checkValidity()) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Tangkap peristiwa saat perubahan terjadi pada setiap input
        const inputs = document.querySelectorAll('#tambahForm input, #tambahForm select, #tambahForm textarea');
        inputs.forEach(function(input) {
            input.addEventListener('change', checkFormValidity);
        });

        // Panggil fungsi checkFormValidity untuk pertama kali saat halaman dimuat
        checkFormValidity();
    </script>

    {{-- Konfirmasi hapus data --}}
    <script>
        function showConfirm(deleteUrl) {
        // Menampilkan confirm dialog
            const result = confirm("Apakah Anda yakin ingin menghapus buku?");
        
        // Jika pengguna mengklik OK (setuju)
            if (result) {
                // Buat elemen form menggunakan JavaScript
                const form = document.createElement('form');
                form.action = deleteUrl;
                form.method = 'POST';
                form.style.display = 'none';

                // Tambahkan input "_method" dengan nilai "DELETE" untuk metode spoofing
                const methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'DELETE');
                form.appendChild(methodInput);

                // Tambahkan CSRF token untuk keamanan
                const csrfTokenInput = document.createElement('input');
                csrfTokenInput.setAttribute('type', 'hidden');
                csrfTokenInput.setAttribute('name', '_token');
                csrfTokenInput.setAttribute('value', '{{ csrf_token() }}'); // Jangan lupa ganti dengan sintaks blade yang sesuai
                form.appendChild(csrfTokenInput);

                // Tambahkan formulir ke dalam body dokumen dan submit formulir
                document.body.appendChild(form);
                form.submit();
            }
        
        // Selalu return false agar tautan tidak mengarahkan ke URL sebenarnya
            return false;
        }
    </script>
@endsection
