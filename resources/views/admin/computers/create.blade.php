@extends('layouts.page')

@section('title', 'Dispositivos - Criar')

@section('css')
  <style>
    .uper {
      margin-top: 40px;
    }
  </style>
@stop

@section('js')

@stop

@section('content')
<div class="card uper">
  <div class="card-header">
    Adicionar Dispositivo
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('computer.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Nome:</label>
              <input type="text" class="form-control" name="name"/>
          </div>
        @if (Auth::user()->isAdmin())
          <div class="form-group">
            <label for="name">Cliente:</label>
            <input type="text" class="form-control" name="team_id" value="{{ Template::clean($computer->team_id) }}" />
          </div>
        @endif
          <button type="submit" class="btn btn-primary">Adicionar</button>
      </form>
  </div>
</div>
@endsection