@extends('template')

@section('name_page')
<?php $page="kategori"; ?>
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
                                <h1 class="card-title">Tabel Data Kategori</h1>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <a href="#" data-target="#modalTambahKategori" data-toggle="modal" class="btn btn-primary">Tambah Kategori</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 5px">No.</th>
                                <th>Nama Kategori</th>
                                <th style="width: 125px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($dataKategori->count() == 0)
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data kategori</td>
                                </tr>
                            @else
                            @foreach($dataKategori as $key=>$value)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $value->nama_kategori}}</td>
                                <td>
                                    <a href="#" data-target="#modalDetailKategori{{$key}}" data-toggle="modal" class="btn btn-success btn-sm" title="Detail Kategori"><i class='fas fa-eye fa-sm'></i></a>
                                    <a href="#" data-target="#modalEditKategori{{$key}}" data-toggle="modal" class="btn btn-warning btn-sm" title="Edit Kategori"><i class='fas fa-pen fa-sm'></i></a>
                                    <a href="#" onclick="return showConfirm('{{ route('kategori.hapus', ['id' => $value->id]) }}')" class="btn btn-danger btn-sm" title="Hapus Kategori"><i class='fas fa-trash fa-sm'></i></a>
                                </td>
                            </tr>
                            <!-- Modal Detail -->
                            <div class="modal fade" id="modalDetailKategori{{$key}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail Kategori</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <input type="text" class="form-control" value="{{ $value->nama_kategori }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /. Modal Detail -->
                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEditKategori{{$key}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Kategori</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('kategori.edit', ['id' => $value->id])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <input type="text" class="form-control" name="nama_kategori" value="{{ $value->nama_kategori }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-default">Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /. Modal Edit -->
                            @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
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
    <div class="modal fade" id="modalTambahKategori">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('kategori.tambah')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /. Modal Edit -->

    <!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

{{-- Konfirmasi hapus data --}}
<script>
    function showConfirm(deleteUrl) {
      // Menampilkan confirm dialog
        const result = confirm("Apakah Anda yakin ingin menghapus kategori?");
    
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
