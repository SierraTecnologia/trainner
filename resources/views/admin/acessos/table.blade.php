@if (method_exists($acessos,'onEachSide'))
    {{ $acessos->onEachSide(10)->links() }}
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <td>Dispositivo</td>
            <td>Grupo</td>
            <td>Playlist</td>
            
            <?php /*<td>Data</td><td>Acessos</td> 
            <td>Created at</td>
            <td colspan="2">Action</td>*/ ?>
        </tr>
    </thead>
    <tbody>
        @foreach($acessos as $acesso)
        <tr>
            <td>{{(!empty($acesso->computer)?(!empty($acesso->computer->name)?$acesso->computer->name:$acesso->computer->token):'Dispositivo Deletado')}}</td>
            <td>{{($acesso->group?$acesso->group->name:'Sem grupo')}}</td>
            <td>{{($acesso->playlist?$acesso->playlist->name:'Nenhuma playlist foi carregada!')}}</td>
            
            <?php /*<td>{{$acesso->created_at->diffForHumans()}}</td><td>{{$acesso->acessos()->count()}}</td>
            <td>{{$acesso->created_at->format('d/m/Y h:i:s')}}</td>
            <td>
                <a href="{{ route('admin.acessos.show',$acesso->id)}}" class="btn btn-primary">Visualizar</a>
                <!--
                <a href="{{ route('admin.acessos.edit',$acesso->id)}}" class="btn btn-primary">Editar</a>
                <form action="{{ route('admin.acessos.destroy', $acesso->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Deletar</button>
                </form>-->
            </td> */ ?>
        </tr>
        @endforeach
    </tbody>
</table>
@if (method_exists($acessos,'onEachSide'))
    {{ $acessos->onEachSide(10)->links() }}
@endif