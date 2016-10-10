<table class="table table-responsive table-striped" id="packages-table">
    <thead>
        <th style="width: 15%;"></th>
        <th>Name</th>
        <th>Category</th>
        <th colspan="3" class="text-right">Action</th>
    </thead>
    <tbody>
    @foreach($packages as $package)
        <tr>
            <td class="text-center">{!! Html::image(URL::to('/uploads/packages/'.$package->mainImage), $package->name, ["style"=>"max-width:85%;max-height:85%"]) !!}</td>
            <td>{!! $package->name !!}</td>
            <td>{!! $package->categories[0]->name !!}</td>
            <td class="text-right">
                {!! Form::open(['route' => ['packages.destroy', $package->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('packages.edit', [$package->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
