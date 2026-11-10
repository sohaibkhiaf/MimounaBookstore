<nav class="bottom-navigation">
    @foreach ($links as $data)
        <a href="{{$data['link']}}" class="{{$data['class']}}"></a>
    @endforeach
</nav>