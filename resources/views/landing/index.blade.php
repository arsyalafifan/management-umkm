@extends('layouts.landing', ['p_is_index' => true])

@section('content')

    <!-- Masthead-->
    <header class="masthead" id="home">
        <div class="container" >
            @yield('content1')
        </div>
    </header>

    <script type="text/javascript">
        $(document).ready(function() {
            @if (session()->has('success'))
            swal({
                title: "",
                text: "{{ session('success') }}",
                icon: "success",
                button: "Ok!",
                type: "success",
            });
            @endif
        });
    </script>
    
@endsection