require('./bootstrap');
import Alpine from 'alpinejs';
import BlazeSlider from 'blaze-slider'
import 'blaze-slider/dist/blaze.css'
import Rellax from 'rellax';
import { uid } from 'uid';
import { scrollIntoView } from 'scroll-js';
window.Alpine = Alpine;
var rellax = new Rellax('.rellax', {
    center:true
  });

Alpine.data('scrollTo', (className) => ({
    focusTo() {
        scrollIntoView(document.body.getElementsByClassName(className)[0], document.body, { behavior: 'smooth' });
    }
}))

Alpine.data('heroMain', (className) => ({
    swiper: null,
    init() {
        new BlazeSlider(document.querySelector(className), {
            all: {
                slidesToScroll: 1,
                slidesToShow: 1,
                enableAutoplay: true
            },
            // "(max-width: 700px)": {
            //     slidesToScroll: 2
            // },
            // "(max-width: 500px)": {
            //     slidesToScroll: 1
            // }
        });
    }
}))


Alpine.data('registrarPasajeros', ({ $wire }) => ({
    tab: '',
    init() {
        this.$store.adquisicionPasaje.tarifas = $wire.tarifas_ida.map(el => ({
            id          : el.tarifa.id,
            descripcion : el.descripcion,
            model       : el.tarifa,
            nro         : el.nro,
            pasajeros   : []
        }))

        this.tab = this.$store.adquisicionPasaje.tarifas[0].descripcion
    }
}))

Alpine.data('formAddPasajero', () => ({
    tipo_documento_id: null,
    nro_documento    : null,
    nombre: '',
    apellido_paterno: null,
    apellido_materno: null,
    fecha_nacimiento: null,
    nro_documento_type: 'number',
    init(){
        this.$watch('tipo_documento_id', (value) => {
            this.nro_documento_type = value == 'DNI' ? 'number' : 'text'
        })
    },
    save(tarifa, $wire) {
        // let fecha_nacimiento = dayjs(this.fecha_nacimiento, 'YYYY-MM-DD')
        let fecha_actual = dayjs()
        let edad = fecha_actual.diff(this.fecha_nacimiento, 'year')
        console.log('TARIFA', tarifa, tarifa.model);
        if (edad > tarifa.model.edad_maxima) {
            $wire.emit('notify', 'error', 'La fecha es mayor al límite máximo de la tarifa')
            return
        }

        let pasajero = {
            uid                 : uid(),
            tipo_documento_id   : this.tipo_documento_id,
            nro_documento       : this.nro_documento,
            nombre              : this.nombre,
            apellido_paterno    : this.apellido_paterno,
            apellido_materno    : this.apellido_materno,
            fecha_nacimiento    : this.fecha_nacimiento,
            edad
        }
        this.$store.adquisicionPasaje.setPasajero(tarifa, pasajero)
    }
}))

Alpine.store('general', {
    sideBar: false,
    toggleSideBar() {
        this.sideBar = !this.sideBar
    },
    closeSideBar() {
        this.sideBar = false
    },
    openSideBar() {
        this.sideBar = true
    }
})

Alpine.store('adquisicionPasaje', {
    tab: 'search-vuelo',
    vuelosIda: [],
    vuelosVuelta: [],
    // pasajeros: [],
    tarifas: [],
    setPasajero(tarifa, $pasajero) {
        this.tarifas.map(tar => (tar.id == tarifa.id )&&  tar.pasajeros.push($pasajero))
        console.log(this.tarifas);
        // this.pasajeros.push($pasajero)
    },
    isTarifaCompleted(tarifa) {
        return tarifa.pasajeros.length >= tarifa.nro
    },
    getNroPasajerosRegistered(tarifa) {
        return this.pasajeros.reduce()
    },
    deletePasajero (tarifa, pasajeroUid) {
        this.tarifas.map(tar => {
            if (tar.id == tarifa.id) {
                return tar.pasajeros = tar.pasajeros.filter(pas => pas.uid !== pasajeroUid)
            }
            return tar
        })
    },
    get hasPasajerosCompleted() {
        let completed = true;
        this.tarifas.map($tar => {
            // console.log('TAR', $tar);
            if (Number($tar.nro) !== Number($tar.pasajeros.length)) {
                // console.log('SIN COMPLETAR',$tar.nro, $tar.pasajeros.length, $tar);
                completed = false
            }
        });
        return completed
    },
    // hasPasajerosCompleted() {
    // },
    save($wire) {
        $wire.save(this.tarifas)
    }
})

Alpine.start();
