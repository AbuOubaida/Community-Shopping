<section id="page-title" class="page-title bg-overlay bg-parallax bg-overlay-gradient">
    <div class="bg-section">
        <img src="{{url("client-site/images/page-title/6.jpg")}}" alt="Background" />
    </div>
    <div class="container">
        <div class="row">
            @if(isset($pageInfo))
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="title title-4 text-center">
                        <div class="title--content">
                            <div class="title--subtitle">{{$pageInfo['parent']}}</div>
                            <div class="title--heading">
                                <h1>{{$pageInfo['this']}}</h1>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <ol class="breadcrumb">
                            @if(isset($pageInfo['root']) && isset($pageInfo['rootRoute']))
                                <li><a href="{{route($pageInfo['rootRoute'])}}">{{$pageInfo['root']}}</a></li>
                            @endif
                            @if(isset($pageInfo['parent']) && isset($pageInfo['parentRoute']))
                                <li><a href="{{route($pageInfo['parentRoute'])}}">{{$pageInfo['parent']}}</a></li>
                            @endif
                            @if(isset($pageInfo['this']))
                                <li class="active">{{$pageInfo['this']}}</li>
                            @endif



                        </ol>
                        <div class="divider--shape-1down divider--shape-gray"></div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
