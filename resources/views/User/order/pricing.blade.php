@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Pricing</div>

        <div class="card-body">
            <a href="{{url('checkout/1')}}">
              <button class="btn select-price" data-package="1">
                Select 1
              </button>
            </a>
            <a href="{{url('checkout/2')}}">
              <button class="btn select-price" data-package="2">
                Select 2
              </button>
            </a>
            <a href="{{url('checkout/3')}}">
              <button class="btn select-price" data-package="3">
                Select 3
              </button>
            </a>
            <a href="{{url('checkout/4')}}">
              <button class="btn select-price" data-package="4">
                Select 4
              </button>
            </a>
            <a href="{{url('checkout/5')}}">
              <button class="btn select-price" data-package="5">
                Select 5
              </button>
            </a>
            <a href="{{url('checkout/6')}}">
              <button class="btn select-price" data-package="6">
                Select 6
              </button>
            </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
