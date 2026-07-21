<section>
    <header class="mb-4">
        <h2 class="h5 mb-1" style="color: var(--color-coral);">{{ __('Delete Account') }}</h2>
        <p class="small mb-0" style="color: var(--text-muted);">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: var(--panel); border: 1px solid var(--color-line); border-radius: 14px;">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <h2 class="h5 mb-2">{{ __('Are you sure you want to delete your account?') }}</h2>

                    <p class="small mb-3" style="color: var(--text-muted);">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mb-3">
                        <x-input-label for="delete_password" value="{{ __('Password') }}" class="visually-hidden" />
                        <x-text-input
                            id="delete_password"
                            name="password"
                            type="password"
                            placeholder="{{ __('Password') }}"
                        />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('confirm-user-deletion')).show();
            });
        </script>
    @endif
</section>

