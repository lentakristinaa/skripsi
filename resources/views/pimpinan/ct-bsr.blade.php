@extends('layouts.pimpinan')

@section('pimpinan')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Cuti Besar</h4>
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
                                <td> {{ $s->user->name }} </td>
                                <td>
                                {{ $s->tgl_pgjn }}
                                </td>
                                <td>
                                <a href="/pimpinan/infobsr/{{$s->id}}" class="btn btn-info"><img src="" alt="Info" width="20" height="20"></a>
                                </td>
                                <td>
                                <?php
                                    if ($s->status == "disetujui") {
                                        echo "Disetujui";
                                    } elseif ($s->status == "ditolak") {
                                        echo "Ditolak";
                                    } elseif ($s->status == "diteruskan") { ?>
                                        <form action="{{ route('pimpinan.updatebsr',$s->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <input type="submit" name="status" value="ditolak" class="btn-danger">
                                            <input type="submit" name="status" value="disetujui" class="btn-primary">
                                        </form>
                                <?php } else {
                                    echo "Menunggu Konfirmasi";
                                }
                                ?>
                                </td>
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
