
<div class=""
x-data="{
    is_origen:@js($is_origen),
    open:false,
    search: '',
    except_destino: '',
    except_origen: '',
    items: @js($ciudades),
    get filteredItems(){
        return this.items.filter(
            i => {
                if(this.is_origen && i.value == this.except_origen)
                    return false;
                if(!this.is_origen && i.value == this.except_destino)
                    return false;

                return i.ciudad.toLowerCase().startsWith(this.search.toLowerCase())
                || i.codigo.toLowerCase().startsWith(this.search.toLowerCase())
                || i.aeropueto.toLowerCase().startsWith(this.search.toLowerCase())
                || i.value.toLowerCase() == this.search.toLowerCase()
            }
        )
    }
}"
@update-except-destino.window="except_destino = $event.detail.except_destino"
@update-except-origen.window="except_origen = $event.detail.except_origen"
>
    <label class="block mb-2 text-sm font-bold text-gray-700" for="username">
        {{$label}}
    </label>
    <input x-on:click="open = true" x-model="search" onClick="this.select();" class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="{{$placeholder}}" autocomplete="off" >

    <div
    x-show="open"
    x-transition.opacity x-on:click.away="open = false"
    class="absolute py-2 mt-2 bg-white border rounded shadow-xl">
        <div x-show="filteredItems.length > 0">
            <template x-for="item in filteredItems" >
                @include('components.form_filter.ciudad_item')
            </template>
        </div>
        <div x-show="filteredItems.length == 0" class="p-3">
            No se hallaron resultados
        </div>
    </div>

</div>

<script>
</script>
