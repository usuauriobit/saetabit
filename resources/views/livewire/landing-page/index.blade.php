<div class="bg-gray-50">
    @include('components.landing-page.hero_section')
    <div x-data="scrollTo('filterSection')" class="filterSection" x-cloak @click="focusTo">
        <livewire:landing-page.components.form-filter :redirectable="true" />
    </div>

    @include('components.landing-page.section-services')
    @include('components.landing-page.section-nuestras-rutas')
    @include('components.landing-page.section-descuentos')
    @include('components.landing-page.section-clientes')
    @include('components.landing-page.section-contactanos')
    {{-- @include('components.landing-page.section_services') --}}
</div>
