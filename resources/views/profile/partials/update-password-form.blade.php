<section x-data="{
    current: '',
    password: '',
    confirm: '',
    ready() {
        return this.current.length > 0 && this.password.length > 0 && this.confirm.length > 0;
    }
}">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Actualizar contraseña
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Usa una contraseña larga y aleatoria para mantener tu cuenta segura. Los cambios se aplicarán solo si confirmas.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" @submit.prevent="if(ready()) $el.submit()">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="'Contraseña actual'" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full"
                x-model="current"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="'Nueva contraseña'" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                x-model="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="'Confirmar contraseña'" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                x-model="confirm"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                x-bind:disabled="!ready()"
                x-bind:class="!ready() ? 'opacity-50 cursor-not-allowed' : ''"
            >Guardar nueva contraseña</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600"
                >¡Contraseña actualizada!</p>
            @endif
        </div>
    </form>
</section>
