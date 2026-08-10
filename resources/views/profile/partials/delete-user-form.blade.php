<section>
    <header class="mb-3">
        <h2 class="profil-card-title" style="color:#dc2626;">
            <i class="bi bi-exclamation-octagon-fill me-2"></i>{{ __('Delete Account') }}
        </h2>
        <p class="profil-card-desc mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-profil-danger-outline" data-bs-toggle="modal" data-bs-target="#modalHapusAkun">
        <i class="bi bi-trash-fill me-1"></i>{{ __('Delete Account') }}
    </button>

    {{-- ===== MODAL KONFIRMASI HAPUS AKUN (Bootstrap native, menggantikan x-modal Alpine) ===== --}}
    <div class="modal fade" id="modalHapusAkun" tabindex="-1" aria-labelledby="modalHapusAkunLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-hapus-tasik">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-body text-center pt-4 pb-3 px-4">
                        <div class="modal-hapus-icon mb-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <h5 class="modal-hapus-title mb-2" id="modalHapusAkunLabel">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h5>
                        <p class="modal-hapus-text mb-3">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>

                        <div class="text-start">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" placeholder="{{ __('Password') }}" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" />
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-profil-outline px-4" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <x-danger-button class="px-4">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Jika request sebelumnya gagal validasi (password salah/kosong), modal otomatis
         terbuka lagi — menggantikan :show="$errors->userDeletion->isNotEmpty()" versi Alpine. --}}
    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modalHapusAkunEl = document.getElementById('modalHapusAkun');
                var modalHapusAkun = bootstrap.Modal.getOrCreateInstance(modalHapusAkunEl);
                modalHapusAkun.show();
            });
        </script>
    @endif
</section>
