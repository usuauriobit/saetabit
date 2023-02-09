<?php

namespace App\Http\Livewire\Intranet\Mantenimiento\LandingPage\SeccionHero;

use App\Models\LPSeccionHero;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component {
    use WithFileUploads;

    public $photoBg;
    public $photoImg;
    public $form = [
        'title',
        'subtitle',
        'nro_orden',
    ];
    public function mount(){
        $this->form['title'] = 'Título';
        $this->form['subtitle'] = 'Subtítulo';
    }

    public function rules(){
        return [
            'form.title'     => 'nullable',
            'form.subtitle'  => 'nullable',
        ];
    }

    public function updatedPhotoBg() {
        $this->validate([
            'photoBg' => 'image|max:1024',
        ]);
    }
    public function updatedPhotoImg() {
        $this->validate([
            'photoImg' => 'image|max:1024',
        ]);
    }

    public function render() {
        return view('livewire.intranet.mantenimiento.landing-page.seccion-hero.create');
    }

    public function getPreviewDataProperty(){
        return [
            'url_bg'   => optional($this->photoBg)->temporaryUrl() ?? null,
            'url_img'  => optional($this->photoImg)->temporaryUrl() ?? null,
            'title'     => $this->form['title'],
            'subtitle'  => $this->form['subtitle'],
        ];
    }

    public function save(){
        $this->store();
    }
    public function store(){
        $data = $this->validate()['form'];

        if ($this->photoBg) {
            $path_bg = Storage::putFile('public/landing_page/hero/bg', $this->photoBg);
        }
        if ($this->photoImg) {
            $path_img = Storage::putFile('public/landing_page/hero/img', $this->photoImg);
        }

        // dd($path_bg);

        LPSeccionHero::create([
            'title'     => $data['title'],
            'subtitle'  => $data['subtitle'],
            'path_bg'   => $path_bg ?? null,
            'path_img'  => $path_img ?? null,
            // 'nro_orden' => ,
        ]);
        return redirect()->route('intranet.mantenimiento.landing-page.seccion-hero.index')->with('success', 'Se registró correctamente');
    }
}
