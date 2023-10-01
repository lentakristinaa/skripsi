@extends('layouts.pegawai')

@section('pegawai')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Cuti diluar Tanggungan Perusahaan</h4>
                    <?php
                    use Illuminate\Support\Facades\Auth;
                    if (Auth::user()->lama_krja <= 6) { ?>
                        <!-- Button trigger modal -->
                        <button type="button" disabled class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Ajukan Permohonan
                        </button>
                   <?php } else { ?>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Ajukan Permohonan
                        </button>
                   <?php } ?>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajukan Permohonan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/pegawai/ctdtn/simpan" method="POST">
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
                                    <label for="exampleInputPassword1">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> No </th>
                            <th> Atas Nama </th>
                            <th> Tanggal Pengajuan </th>
                            <th> Detail </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach ($srt as $s)
                            <tr>
                                <td class="py-1">
                                    {{ $no++ }}
                                </td>
                                <td>{{ Auth::user()->name }} </td>
                                <td>
                                    {{ $s->tgl_pgjn}}
                                </td>
                                <td>
                                <?php if ($s->status == "disetujui") { ?>
                                    <a href="/pegawai/printdtn/{{$s->id}}" class="btn btn-info"><img src="/img/logoprint.png" alt="Print" width="20" height="20"></a>
                                <?php  } elseif ($s->status == "selesai") { ?>
                                  <a href="/pegawai/printdtn/{{$s->id}}" class="btn btn-info"><img src="/img/logoprint.png" alt="Print" width="20" height="20"></a>
                               <?php } else { ?>
                                    <a href="/pegawai/infodtn/{{$s->id}}" class="btn btn-info"><img src="" alt="Info" width="20" height="20"></a>
                                    <?php } ?>
                                </td>
                                <td> {{ $s->status }} </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
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
