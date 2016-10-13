<table class="table table-responsive table-striped" id="categories-table">
    <thead>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th colspan="3" class="text-right">Action</th>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr>
            <td>{!! $customer->firstName !!}</td>
            <td>{!! $customer->lastName !!}</td>
            <td>{!! $customer->email !!}</td>
            <td class="text-right">
                {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('customers.show', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('customers.edit', [$customer->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
