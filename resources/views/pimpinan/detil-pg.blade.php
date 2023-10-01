@extends('layouts.pimpinan')

@section('pimpinan')
<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Detil Pegawai</h4>
                    <form action="" method="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">NIP</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->nip}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->alamat}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Jabatan</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->jabatan}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Golongan</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->golongan}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Jenis Kelamin</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->jns_kelamin}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Lahir</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->tgl_lahir}}" readonly>
                                </div>
                                    <div class="form-group">
                                            <label for="tgl_msk">Tanggal Masuk</label>
                                            <input type="text" class="form-control jgnputih" id="tgl_msk" readonly name="tgl_msk" value="{{ $user->tgl_msk }}" />
                                    </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Lama Kerja</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->lama_krja}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Sisa Cuti</label>
                                    <input type="text" class="form-control jgnputih" value="{{$user->sisa_ct}}" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <a href="/pimpinan/daftarpg" class="btn btn-primary">Ok</a>
                            </div>
                            </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection
