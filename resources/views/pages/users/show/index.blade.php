<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <form action="{{ route('users.update', $user->uuid) }}" method="POST">

        @if(Session::has('message'))
            <div class="alert alert-success mt-4">
                {{ Session::get('message') }}
            </div>
        @endif

        <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
            @csrf
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="widget" style="margin-bottom: 20px;">
                    <div class="widget-content widget-content-area p-0">
                        <div style="padding: 20px;">
                            <h4 class="fw-bold truncate">Edit User</h4>
                            <hr>
                            <form action="">
                                <div class="form-group mb-4">
                                    <label for="name">Nama<sup class="text-danger">*</sup></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $user->name }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="email">Email<sup class="text-danger">*</sup></label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm" value="{{ $user->email }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="username">Username<sup class="text-danger">*</sup></label>
                                    <input type="text" name="username" id="username" class="form-control form-control-sm" value="{{ $user->username }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control form-control-sm">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="confirm-password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm-password" class="form-control form-control-sm">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-sm-12">
                <div class="widget" style="margin-bottom: 20px;">
                    <div class="widget-content widget-content-area p-0">
                        <div style="padding: 20px;">
                            <h4 class="fw-bold truncate">Perizinan</h4>
                            <hr>
                            <div>
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-primary">
                                        <input class="form-check-input me-3" type="checkbox" id="{{ $permission->name }}" name="permissions[]" value="{{ $permission->name }}"  @if ($user->permissions->pluck('id')->contains($permission->id)) checked @endif>
                                        <label class="form-check-label" for="{{ $permission->name }}">
                                            {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end" style="gap: 12px;">
                    <a href="{{ route('users.index') }}" class="d-block btn btn-outline-primary">Kembali</a>
                    <button type="submit" class="d-block btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script>
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
