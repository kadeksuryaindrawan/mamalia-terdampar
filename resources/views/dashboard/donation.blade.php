@extends('layouts.app')

@section('content')

            <div class="page-content">
              <div class="main-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                            @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{session('error')}}
                            </div>
                            @endif
                        </div>

                </div>
                <div class="row">
                  <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <img style="width: 50%;" src="{{ asset('assets/images/qriswesterlaken.jpg') }}" alt="">
                        </div>
                    </div>
                  </div>
                </div>
             </div>
            </div>

@endsection
