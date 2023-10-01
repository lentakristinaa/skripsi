@extends('layouts.pegawai')

@section('pegawai')

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Detil {{$srt->jns_ct}}</h4>
                    <form action="" method="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">NIP Pemohon</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->user->nip}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nama Pemohon</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->user->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Alamat Pemohon</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->user->alamat}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Jabatan Pemohon</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->user->jabatan}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Golongan Pemohon</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->user->golongan}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal Mulai Cuti</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->tgl_mulai}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tanggal Selesai Cuti</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->tgl_sls}}" readonly>
                                </div>
                                <?php if ($srt->status == "pending") {

                                } else { ?>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Durasi Cuti</label>
                                        <input type="text" class="form-control jgnputih" value="{{$srt->durasi}}" readonly>
                                    </div>
                                <?php  } ?>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Keterangan Sakit</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->keterangan}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Foto</label>
                                    <input type="text" class="form-control jgnputih" value="{{$srt->foto}}" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <a href="/pegawai/ctskt" class="btn btn-primary">Ok</a>
                            </div>
                            </form>
                            </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <!-- partial -->
        </div>

@endsection
