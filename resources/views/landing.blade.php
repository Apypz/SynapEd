@extends('layouts.public')

@section('title', 'NeuroAcademy – Belajar Neuroscience & EEG')

@section('content')

    {{-- Hero Section --}}
    @include('components.sections.hero')

    {{-- Stats / Metrics Section --}}
    @include('components.sections.stats')

    {{-- About Section --}}
    @include('components.sections.about')

    {{-- Value Proposition Section --}}
    @include('components.sections.value-proposition')

    {{-- Courses Section (with category filter) --}}
    @include('components.sections.courses')

    {{-- Testimonials Section --}}
    @include('components.sections.testimonials')

    {{-- Features / Keunggulan Section --}}
    @include('components.sections.features')

    {{-- Learning Path / Alur Belajar --}}
    @include('components.sections.learning-path')

    {{-- FAQ Section --}}
    @include('components.sections.faq')

    {{-- Final CTA Section --}}
    @include('components.sections.cta')

@endsection
