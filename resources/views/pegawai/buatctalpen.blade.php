@extends('layouts.pegawai')

@section('pegawai')

<form action="/pegawai/ctalpen/simpan" method="POST">
                                @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tgl_mulai">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tgl_sls">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat</label>
                                    <input type="text" class="form-control" name="alamat">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alasan Cuti</label>
                                    <input type="text" class="form-control" name="keterangan">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </form>

@endsection
