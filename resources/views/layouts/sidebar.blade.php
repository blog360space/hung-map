<div class="col-md-4">
    <div class="mb-box">
        <div class="widget-heading">
        <h3 class="mb-sidebar-heading">Category</h3>
        </div>
    {!! $tree !!}
    </div>

    <br class="clear">

    <div class="mb-box">
        <div class="widget-heading">
        <h3 class="mb-sidebar-heading">Recent posts</h3>
        </div>
        {{ recent_posts() }}
    </div>

    <br class="clear">

    <div class="mb-box">
        <div class="widget-heading">
        <h3 class="mb-sidebar-heading">Tags</h3>
        </div>
        {{ display_tags() }}
    </div>
    
    <br class="clear">
    
    <div class="mb-box">
        <div class="widget-heading">
        <h3 class="mb-sidebar-heading">Archives</h3>
        </div>
        <ul>
            @foreach($archives as $item)
            <li><a href="{{ url('?year=' . $item['year'] . '&month=' . $item['month'] ) }}">
                    {{  $item['month'] }} {{  $item['year'] }} </a></li>
            @endforeach
        </ul>
    </div>
</div>