<div class="custom-widget">
    <div class="box">
        <div class="header">
            <h2>Velkommen til Vizuall CMS</h2>
            <p>Kom godt i gang ved at udfylde de vigtigste områder.</p>
        </div>
        <ul class="list">
            @foreach ($items as $index => $item)
                <li>
                    <a
                        href="{{ $item['url'] }}"
                        class="link"
                    >
                        <div class="icon">
                            {!! $item['icon'] !!}
                        </div>
                        <div class="text">
                            <h3>
                                {{ $item['title'] }}
                            </h3>
                            <p class="">{{ $item['description'] }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none"><path fill="currentColor" d="m19.166 8-6.875-6.667M19.166 8l-6.875 6.666M19.166 8H7.136M.832 8h2.865" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="box">
        <div class="header">
            <h2>CMS video guide</h2>
            <p>Her kan du finde en guide til at hjælpe dig med at rette tekst og indhold på din side samt meget mere.</p>
        </div>
        <ul class="list list-video">
            @foreach ($videos as $index => $video)
                <li>
                    <a href="{{ $video['url'] }}" target="_blank">
                        <div>
                            <h3>{{ $video['title'] }}</h3>
                            <p>{{ $video['description'] }}</p>
                        </div>
    
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none"><path fill="currentColor" d="m19.166 8-6.875-6.667M19.166 8l-6.875 6.666M19.166 8H7.136M.832 8h2.865" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
