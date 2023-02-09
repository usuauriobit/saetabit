<div

    @click="function(){
        search = item.value
    }"
    x-init="
        $watch('search', value => {
            console.log(value)
            if(is_origen)
                $dispatch('update-except-destino', {except_destino: value})
            else
                $dispatch('update-except-origen', {except_origen: value})
        })
    "
    class="w-full border-b border-gray-100 rounded-t cursor-pointer hover:bg-teal-100">
    <div class="relative flex items-center w-full p-2 pl-2 border-l-2 border-transparent hover:border-teal-100">
        <div class="flex flex-col items-center w-6">
            <div class="relative flex items-center justify-center w-5 h-5 m-1 mt-1 mr-2 bg-orange-500 rounded-full ">
                <i class="las la-plane-departure"></i>
            </div>
        </div>
        <div class="flex items-center w-full">
            <div class="mx-2 -mt-1 ">
                <strong x-text="item.ciudad"></strong>, <span x-text="item.codigo"></span>
                <div class="w-full -mt-1 text-xs font-normal text-gray-500 normal-case truncate" x-text="item.aeropueto"></div>
            </div>
        </div>
    </div>
</div>
