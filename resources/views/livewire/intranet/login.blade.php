<div class="h-full bg-indigo-900"
style="background: url('{{ asset('img/default/bg4.jpg') }}'); background-size: cover;">
<style>
    body{
        zoom: 100%;
    }
</style>
<div style="
        background: rgba(0, 0, 0, 0.514);
    ">
        <div class="h-full">
            <div class="flex items-center justify-center min-h-screen">

                <div class="w-full mx-4 shadow-2xl md:w-4/6 card-white">
                    <div class="grid gap-4 md:grid-cols-1 lg:grid-cols-2">
                        <img class="object-cover w-full h-16 shadow-2xl md:h-32 lg:h-full"
                            src="{{ asset('img/repo/avion-bg-2.jpg') }}" alt="">
                        <div class="card-body">
                            <div class="flex justify-center mb-6">
                                <a href="{{route('landing_page.index')}}">
                                    <img src="{{asset('img/logo-color.png')}}" alt="">
                                </a>
                            </div>
                            <h3 class="text-2xl font-bold text-center">Iniciar sesión</h3>
                            <form wire:submit.prevent="login">
                                <div class="mt-4">
                                    <div>
                                        <label class="block" for="email">Usuario<label>
                                                <input name="email" wire:model.defer="email" type="email" placeholder="Email"
                                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                                @if ($errors->has('email'))
                                                <span class="text-xs tracking-wide text-red-600">
                                                    {{ $errors->first('email') }}
                                                </span>
                                                @endif
                                    </div>
                                    <div class="mt-4">
                                        <label class="block">Contraseña<label>
                                                <input wire:model.defer="password" type="password"
                                                    name="password"
                                                    placeholder="Password"
                                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                                    </div>
                                    <div class="flex items-baseline justify-between mt-4">
                                        <button type="submit" wire:loading.attr="disabled"
                                            class="w-full btn btn-primary">
                                            Ingresar <i class="la la-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
