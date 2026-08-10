<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb breadcrumb-app mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profil</li>
            </ol>
        </nav>
        <h2 style="color:#fff; font-size:1.6rem; font-weight:700; margin:0; text-shadow:0 2px 8px rgba(0,0,0,.15);">
            <i class="bi bi-person-circle me-2"></i>{{ __('Profile') }}
        </h2>
        <p class="mb-0" style="color:rgba(255,255,255,.85); font-size:.92rem;">
            Kelola informasi akun dan keamanan Anda.
        </p>
    </x-slot>

    <style>
        .profil-card{background:#fff;border-radius:18px;box-shadow:0 15px 40px rgba(13,59,122,.08);padding:2rem 2.25rem;}
        .profil-card-title{color:#0d3b7a;font-size:1.15rem;font-weight:700;margin-bottom:.25rem;}
        .profil-card-desc{color:#617286;font-size:.88rem;margin-bottom:1.5rem;}

        .profil-label{color:#0d3b7a;font-weight:600;font-size:.85rem;margin-bottom:.4rem;display:inline-block;}
        .profil-input{border:1.5px solid #e2e8f0;border-radius:10px;padding:.6rem .9rem;font-size:.92rem;width:100%;}
        .profil-input:focus{border-color:#4a90c2;box-shadow:0 0 0 .2rem rgba(74,144,194,.15);outline:none;}
        .profil-error-list{list-style:none;padding:0;margin:.4rem 0 0;color:#dc2626;font-size:.8rem;}

        .btn-profil-primary{background:linear-gradient(135deg,#0d3b7a,#4a90c2);border:none;color:#fff;font-weight:600;padding:.6rem 1.7rem;border-radius:10px;font-size:.88rem;transition:.2s;}
        .btn-profil-primary:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(13,59,122,.25);color:#fff;}
        .btn-profil-outline{border:1.5px solid #e2e8f0;color:#617286;font-weight:600;border-radius:10px;padding:.6rem 1.5rem;background:#fff;}
        .btn-profil-outline:hover{background:#f8fafc;}
        .btn-profil-danger-outline{border:1.5px solid #fca5a5;color:#dc2626;font-weight:600;border-radius:10px;padding:.6rem 1.5rem;background:#fff;}
        .btn-profil-danger-outline:hover{background:#dc2626;color:#fff;border-color:#dc2626;}
        .btn-profil-danger{background:#dc2626;color:#fff;font-weight:600;border:none;border-radius:10px;padding:.6rem 1.5rem;}
        .btn-profil-danger:hover{background:#b91c1c;color:#fff;}

        .profil-alert{border-radius:10px;font-size:.85rem;}

        /* Modal hapus akun (senada tema modal hapus user di halaman admin) */
        .modal-hapus-tasik{border:none;border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.3);}
        .modal-hapus-icon{width:70px;height:70px;background:linear-gradient(135deg,#fecaca,#fca5a5);color:#dc2626;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.75rem;margin:0 auto;}
        .modal-hapus-title{font-weight:700;color:#1e293b;}
        .modal-hapus-text{color:#64748b;font-size:.9rem;}
    </style>

    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="profil-card mb-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="profil-card mb-4">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="profil-card">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
