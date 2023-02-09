<div class="min-h-screen">

    <div class="bg-primary text-white p-4 flex items-center gap-4">
        <div class="container mx-auto">
            <div class="avatar">
                <div class="w-20 h-20 m-1 rounded-full">
                    @auth
                        <img src="{{ Auth::user()->profile_photo_url }}">
                    @endauth
                </div>
            </div>
            <div>
                <h4 class="text-h4 font-bold">{{ Auth::user()->name }}</h4>
                <span>{{ Auth::user()->email }}</span>
            </div>
        </div>
    </div>
    <div x-data="{ tab: 'pagos' }">

        <div class="tabs tabs-boxed">
            <div class="container mx-auto">
                <a class="tab" :class="{ 'tab-active': tab == 'pagos' }" @click="tab = 'pagos'">Pagos</a>
                <a class="tab" :class="{ 'tab-active': tab == 'vuelos' }" @click="tab = 'vuelos'">Pasajes</a>
                <a class="tab" :class="{ 'tab-active': tab == 'encomiendas' }"
                    @click="tab = 'encomiendas'">Encomiendas</a>
            </div>
        </div>
    </div>
</div>
