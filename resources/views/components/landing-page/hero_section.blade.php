<div class="blaze-slider" x-data="heroMain('.blaze-slider')">
    <div class="blaze-container">
        <div class="blaze-track-container">
            <div class="blaze-track">
                @forelse ($heroes as $hero)
                    <div>
                        @include('components.landing-page.hero-item', ['hero' => $hero])
                    </div>
                @empty
                    <div>
                        @include('components.landing-page.hero-item', ['hero' => null])
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
