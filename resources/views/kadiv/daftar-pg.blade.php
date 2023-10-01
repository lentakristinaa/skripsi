@extends('layouts.kadiv')

@section('kadiv')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Pegawai</h4>
                    <a class="btn-primary" href="/kadiv/buatakun">Buat Akun</a>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> No </th>
                            <th> Nama Pegawai </th>
                            <th> NIP </th>
                            <th> Jenis Kelamin </th>
                            <th> Detil </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach ($user as $u)
                            <tr>
                                <td class="py-1">
                                    {{ $no++ }}
                                </td>
                                <td> {{ $u->name }} </td>
                                <td>
                                    {{ $u->nip }}
                                </td>
                                <td>
                                    {{ $u->jns_kelamin }}
                                </td>
                                <td>
                                <a href="/kadiv/detilpg/{{$u->id}}" class="btn btn-info">Detil</a>
                                </td>
                                <td>
                                    Aktif
                                </td>
                                <td>

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
