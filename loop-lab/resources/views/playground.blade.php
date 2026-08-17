@extends('layouts.app')
@section('title','PHP Playground')
@section('content')
<span class="eyebrow">Laboratório</span><h1>PHP Playground</h1><p class="lead">Teste pequenos trechos dos fundamentos. Recursos de arquivos, rede, processos, classes e includes ficam bloqueados neste ambiente local.</p>
<form class="card" method="POST" action="{{ route('playground.run', absolute: false) }}">@csrf<textarea class="editor" name="code" aria-label="Editor do playground" spellcheck="false">{{ old('code',"<?php\n\n\$nome = 'João';\necho 'Olá, ' . \$nome;") }}</textarea>@error('code')<p class="feedback bad">{{ $message }}</p>@enderror<button class="btn btn-primary" type="submit">Executar código</button></form>
@if(session('execution'))<section class="card" style="margin-top:20px"><h2>Saída</h2>@if(session('execution.successful'))<pre class="output">{{ session('execution.output') ?: '(nenhuma saída)' }}</pre>@else<div class="feedback bad">{{ session('execution.error') }}</div>@endif</section>@endif
@endsection
