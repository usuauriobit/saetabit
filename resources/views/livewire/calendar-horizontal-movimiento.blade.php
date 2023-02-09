<div>
    <div class='flex justify-start items-center px-2 -mx-4 -mt-3 py-4  overflow-x-scroll border-0 shadow-md md:justify-center '
        style="z-index: -1;
            background: url('{{ asset('img/default/colorful17.jpg') }}');
            background-size: cover;
        "

    >
        <div class="text-center w-full">
            <h4 class="text-3xl font-bold">
                {{$caja->descripcion}}
            </h4>
            <div class="badge badge-primary">
                {{$caja->oficina->descripcion}}
            </div>
        </div>

        <div class="flex justify-center w-16 mx-1 transition-all duration-300 rounded-lg cursor-pointer group hover:bg-primary hover:shadow-lg hover-dark-shadow" wire:click="setDaysBefore">
            <i class="my-auto text-2xl las la-angle-double-left"></i>
        </div>
        @foreach ($days as $day)
            <button class="flex justify-center w-24 mx-1 transition-all duration-300 rounded-lg cursor-pointer group hover:bg-primary hover:shadow-lg hover-dark-shadow
                    {{ $day['date'] == $selected_day ? 'bg-primary shadow-lg' : '' }}"
                    wire:click="setDay('{{$day['date']}}')">
                <div class='flex items-center px-4 py-4'>
                    <div class='text-center'>
                        <p class="text-2xs transition-all mb-2 duration-300 group-hover:text-gray-100
                            {{ $day['date'] == $selected_day ? 'text-gray-100' : 'text-white' }}" >
                            {{$day['mes']}}
                        </p>
                        <p class="text-sm font-bold transition-all duration-300 group-hover:text-gray-100
                            {{ $day['date'] == $selected_day ? 'text-gray-100' : 'text-gray-900' }}" >
                            {{$day['dia']}}
                        </p>
                        <p class="my-2  transition-all duration-300 group-hover:text-gray-100 group-hover:font-bold
                            {{ $day['date'] == $selected_day ? 'text-gray-100' : 'text-gray-900' }}" >
                            {{$day['d']}}
                        </p>
                    </div>
                </div>
            </button>
        @endforeach
        <div class="flex justify-center w-16 mx-1 transition-all duration-300 rounded-lg cursor-pointer group hover:bg-primary hover:shadow-lg hover-dark-shadow" wire:click="setDaysAfter">
            <i class="my-auto text-2xl las la-angle-double-right"></i>
        </div>
    </div>

</div>
