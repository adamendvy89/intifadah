<div class="container page-content clearfix">

        <div class="left-column">
            
            <div class="box" >
                <div class="box-title">Daftar Rapat Online</div>
                <div class="photo-albums box-content clearfix">
                    {{$data}}
                </div>
            </div>
        </div>

        <div class="right-column">
            {{Theme::section('user.side-info')}}
			{{Theme::widget()->get('user-home')}}
            
        </div>
    </div>