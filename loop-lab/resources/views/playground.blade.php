@extends('layouts.app')
@section('title','PHP Playground')
@section('content')
<span class="eyebrow">Laboratório</span><h1>PHP Playground</h1><p class="lead">Teste pequenos trechos dos fundamentos. Recursos de arquivos, rede, processos, classes e includes ficam bloqueados neste ambiente local.</p>
<form class="card" method="POST" action="{{ route('playground.run', absolute: false) }}" data-async-form data-starter-code="{{ base64_encode("<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome;") }}">
    @csrf
    <textarea class="editor" name="code" aria-label="Editor do playground" spellcheck="false">{{ old('code', "<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome;") }}</textarea>
    @error('code')<p class="feedback bad">{{ $message }}</p>@enderror
    <div class="actions" style="margin-top:16px;justify-content:space-between">
        <button class="btn btn-primary" type="submit">Executar código</button>
        <button class="btn btn-secondary btn-quiet" type="button" data-reset-editor>Restaurar código padrão</button>
    </div>
</form>
<div id="exercise-result">@if(is_array(session('execution')))@include('partials.exercise-result', ['execution' => session('execution')])@endif</div>
@endsection
