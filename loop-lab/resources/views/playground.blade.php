@extends('layouts.app')
@section('title','PHP Playground')
@section('content')
<span class="eyebrow">Laboratório</span><h1>PHP Playground</h1><p class="lead">Teste pequenos trechos dos fundamentos. Recursos de arquivos, rede, processos, classes e includes ficam bloqueados neste ambiente local.</p>
<form class="card" method="POST" action="{{ route('playground.run', absolute: false) }}" data-async-form>@csrf<textarea class="editor" name="code" aria-label="Editor do playground" spellcheck="false">{{ old('code',"<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome;") }}</textarea>@error('code')<p class="feedback bad">{{ $message }}</p>@enderror<button class="btn btn-primary" type="submit">Executar código</button></form>
<div id="exercise-result">@if(session('execution'))@include('partials.exercise-result', ['execution' => session('execution')])@endif</div>
@endsection
