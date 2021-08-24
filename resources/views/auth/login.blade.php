@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item active">Login</li>
@endsection

@section('content')
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-conten padding-y" style="min-height:84vh">

    <!-- ============================ COMPONENT LOGIN   ================================= -->

    <div class="shadow-lg bg-white mx-auto" style="max-width: 380px; margin-top:100px; padding:20px;">
        <h4 class="card-title mb-4">Login</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if(session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Something it's wrong:
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            <br>
            <div class="form-group">
               <input name="username" class="form-control" placeholder="Username" type="text">
            </div> <!-- form-group// -->
            <div class="form-group">
              <input name="password" class="form-control" placeholder="Password" type="password">
            </div> <!-- form-group// -->

            <div class="form-group ">
                <a href="{{ route('lupapassword') }}" class="float-right mb-2">Lupa Password?</a>
            </div> <!-- form-group form-check .// -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Login  </button>
            </div> <!-- form-group// -->
        </form>
        </div> <!-- card .// -->

         <p class="text-center mt-4">Tidak punya akun? <a href="{{ route('daftar') }}">Daftar</a></p>
         <br><br>
    <!-- ============================ COMPONENT LOGIN  END.// ================================= -->


    </section>

@endsection

@section('javascript')
<script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
      });
    }, 2000);
</script>
@endsection
