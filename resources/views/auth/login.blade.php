<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{-- {{$title}}  --}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/authentication/auth-boxed.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-boxed.scss'])

        <style>
            #load_screen {
                display: none;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>

                    @endforeach
                    @endif
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <form action="/login" method="POST">
                                @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Login</h2>
                                    <p>Masukkan username dan password untuk masuk admin dashboard</p>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="mb-3">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                            <label class="form-check-label" for="form-check-default">
                                                Ingat Saya
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-secondary w-100">Masuk</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
