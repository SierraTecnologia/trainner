@if (method_exists($groups,'onEachSide'))
    {{ $groups->onEachSide(10)->links() }}
@endif
<table class="table table-striped">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nome</td>
            <td>Playlist</td>
            @if (auth()->user() && auth()->user()->isAdmin())
                <td>Cliente</td>
            @endif
            <td>Computadores</td>
            <!-- <td colspan="2">Action</td> -->
        </tr>
    </thead>
    <tbody>
        @foreach($groups as $group)
        <tr>
            <td>{{$group->id}}</td>
            <td><a href='{{ route('admin.groups.show',$group->id)}}'>{{$group->name}}</a></td>
            <td>{{$group->playlist?$group->playlist->name:'Sem playlist'}}</td>
            @if (auth()->user() && auth()->user()->isAdmin())
                <td>{{($group->team?$group->team->name:'Sem Cliente')}}</td>
            @endif
            <td>{{$group->computers()->count()}}</td>
            <!-- <td>
                <a href="{{ route('admin.groups.show',$group->id)}}" class="btn btn-primary">Visualizar</a>
                <a href="{{ route('admin.groups.edit',$group->id)}}" class="btn btn-primary">Editar</a>
                <form action="{{ route('admin.groups.destroy', $group->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Deletar</button>
                </form>
            </td> -->
        </tr>
        @endforeach
    </tbody>
</table>
<script type='text/javascript'>
</script>
@if (method_exists($groups,'onEachSide'))
    {{ $groups->onEachSide(10)->links() }}
@endif