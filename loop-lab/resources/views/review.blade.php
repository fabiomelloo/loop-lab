@extends('layouts.app')
@section('title', 'Revisar — Loop Lab')
@section('content')
<span class="eyebrow">Aprendizado adaptativo</span><h1>Revisar seus erros</h1><p class="lead">Aqui aparecem exercícios que você tentou e ainda não concluiu. Resolva os mais recentes primeiro.</p>
<div class="stack" style="margin-top:28px">
@forelse($exercises as $exercise)
<article class="card course-card" style="margin:0"><div><span class="badge">{{ $exercise->lesson->module->title }} · {{ $exercise->difficulty }}</span><h2>{{ $exercise->title }}</h2><p>{{ $exercise->description }}</p></div><a class="btn btn-primary" href="{{ route('lessons.show', [$exercise->lesson, $exercise]) }}#praticar">Tentar novamente</a></article>
@empty
<section class="card empty-ranking"><h2>Nenhuma revisão pendente</h2><p>Os exercícios errados aparecerão aqui até serem concluídos.</p></section>
@endforelse
</div>
@endsection
