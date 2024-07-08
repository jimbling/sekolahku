<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <div class="py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="p-4 p-lg-8 bg-white shadow-lg rounded-lg mb-4">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <div class="p-4 p-lg-12 bg-white shadow-lg rounded-lg mb-4">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div class="p-4 p-lg-12 bg-white shadow-lg rounded-lg mb-4">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </section>

</div>
<x-footer></x-footer>
