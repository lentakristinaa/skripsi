@extends('layouts.pimpinan')

@section('pimpinan')

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="text-primary ml-2 mb-0 font-weight-medium">0</h3>
                        </div>
                      </div>
                    </div>
                    <br>
                    <h6 class="text-muted font-weight-normal">Permohonan diproses</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="text-success ml-2 mb-0 font-weight-medium">0</h3>
                        </div>
                      </div>
                    </div>
                    <br>
                    <h6 class="text-muted font-weight-normal">Permohonan disetujui</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="text-danger ml-2 mb-0 font-weight-medium">0</h3>
                        </div>
                      </div>
                    </div>
                    <br>
                    <h6 class="text-muted font-weight-normal">Permohonan ditolak</h6>
                  </div>
                </div>
              </div>
            </div>
        </div>

@endsection
