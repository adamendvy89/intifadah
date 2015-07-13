<div class="box">
    <div class="box-title">Event Categories <a href="{{URL::route('admincp-events-create-category')}}">Add New Category</a> </div>


    <div class="box-content">
        <div class="alert alert-info">Below contains the list of event categories your member can create different events</div>

        <form action="" method="get">
            <input name="term" type="text" class="form-control" placeholder="Search event by its name or slug"/>
            <br/>
            <button class="btn btn-primary btm-sm">Search</button><br/><br/>
        </form>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 40%">Title</th>
                <th style="width: 30%">Description</th>
                <th style="">By</th>
                <th>Likes</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{$event->title}}</td>
                <td>{{$event->description}}</td>
                <td><a href="{{$event->user->present()->url()}}">{{$event->user->fullname}}</a> </td>
                <td>{{$event->countLikes()}}</td>
                <td>
                    <a href="{{URL::route('admincp-events-edit', ['id' => $event->id])}}">Edit</a> |
                    <a href="{{URL::route('delete-event', ['id' => $event->id])}}">Delete</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{$events->links()}}
    </div>
</div>