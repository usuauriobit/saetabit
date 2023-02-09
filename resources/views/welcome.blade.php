@extends('layouts.app')

<div class="bg-gray-50">
    @include('components.hero_section')
    <div style="margin-top: -100px" class="mx-16 mb-5">
        <livewire:landing-page.components.form-filter :redirect="true" />
    </div>
    @include('components.section_services')
</div>
