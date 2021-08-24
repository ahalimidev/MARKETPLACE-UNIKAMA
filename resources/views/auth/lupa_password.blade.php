@extends('layouts.index')

@section('css')

@endsection


@section('list')
<li class="breadcrumb-item ">Home</li>
<li class="breadcrumb-item active">Lupa Password</li>
@endsection

@section('content')
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-conten padding-y" style="min-height:84vh">

    <!-- ============================ COMPONENT LOGIN   ================================= -->

    <div class="shadow-lg bg-white mx-auto" style="max-width: 380px; margin-top:100px; padding:20px;">
        <h4 class="card-title mb-4">Lupa Password</h4>
        <form>

            <div class="form-group">
                <label>Email sudah terdaftar</label>
               <input name="" class="form-control" placeholder="Email" type="text">
            </div> <!-- form-group// -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Verifikasi  </button>
            </div> <!-- form-group// -->
        </form>
        </div> <!-- card .// -->

         <p class="text-center mt-4">Tidak punya akun? <a href="{{ route('daftar') }}">Daftar</a></p>
         <br><br>
    <!-- ============================ COMPONENT LOGIN  END.// ================================= -->


    </section>
@endsection

@section('javascript')

@endsection
