<form action="" method="post"> @csrf
    <input type="hidden" name="address" value="{{ @$user_address->id }}">
    <input type="hidden" name="cart" value="{{ @$cart->id }}">
    <input type="hidden" name="deliver" value="{{ @$deliver->id  }}">

    <div class="container mb-5" style="margin-top: 90px;">
        @php
            $days = getDaysTwoWeeks($region);
            $week1 = array_slice($days, 0, 7);
            $week2 = array_slice($days, 7);
        @endphp

        <div class="row">
            <div class="col-1 p-0">
                <div class="hour-column">
                    @for ($hour = 8; $hour <= 18; $hour++)
                        <div class="hour-row">
                            {{ $hour }}:00
                        </div>
                    @endfor
                </div>
            </div>
            <div class="col-11 p-0">
                <div class="week-grid">
                    @foreach ($week1 as $key => $day)
                        <div class="day-column {{ $day['is_target_day'] ? '' : 'target-day' }}">
                            <div class="day-header">{{ ucfirst($day['formatted_date']) }}</div>
                            <div class="day-content">
                                @if($day['is_target_day'])
                                    @if(getDateDayPlusOne() < $day['date'])
                                        <div class="morning-session">&nbsp;</div>
                                        <button class="btn btn-primary rounded-0 hvr-grow-shadow" style="height: 175px;"
                                                hx-post="{{ route('cart.chosed_delivery_date', [$deliver, $day['date'], 'matin']) }}"
                                                hx-swap="outerHTML"
                                                hx-target="#divdelivery"
                                                hx-indicator=".htmx-indicator, .htmx-style">
                                            Entre 9h et 13h
                                        </button>
                                        <div class="morning-session">&nbsp;</div>
                                        <button class="btn btn-warning rounded-0 hvr-grow-shadow" style="height: 140px;"
                                                hx-post="{{ route('cart.chosed_delivery_date', [$deliver, $day['date'], 'aprem']) }}"
                                                hx-swap="outerHTML"
                                                hx-target="#divdelivery"
                                                hx-indicator=".htmx-indicator, .htmx-style">
                                            Entre 14h et 18h
                                        </button>
                                    @else
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <h4 class="mt-3" style="margin-bottom: 80px;">Semaine suivante</h4>
        <div class="row">
            <div class="col-1 p-0">
                <div class="hour-column">
                    @for ($hour = 8; $hour <= 18; $hour++)
                        <div class="hour-row">
                            {{ $hour }}:00
                        </div>
                    @endfor
                </div>
            </div>
            <div class="col-11 p-0">
                <div class="week-grid">
                    @foreach ($week2 as $key => $day)
                        <div class="day-column {{ $day['is_target_day'] ? '' : 'target-day' }}">
                            <div class="day-header">{{ ucfirst($day['formatted_date']) }}</div>
                            <div class="day-content">
                                @if($day['is_target_day'])
                                    @if(getDateDayPlusOne() < $day['date'])
                                        <div class="morning-session">&nbsp;</div>
                                        <button class="btn btn-primary rounded-0 hvr-grow-shadow" style="height: 175px;"
                                                hx-post="{{ route('cart.chosed_delivery_date', [$deliver, $day['date'], 'matin']) }}"
                                                hx-swap="outerHTML"
                                                hx-target="#divdelivery"
                                                hx-indicator=".htmx-indicator, .htmx-style">
                                            Entre 9h et 13h
                                        </button>
                                        <div class="morning-session">&nbsp;</div>
                                        <button class="btn btn-warning rounded-0 hvr-grow-shadow" style="height: 140px;"
                                                hx-post="{{ route('cart.chosed_delivery_date', [$deliver, $day['date'], 'aprem']) }}"
                                                hx-swap="outerHTML"
                                                hx-target="#divdelivery"
                                                hx-indicator=".htmx-indicator, .htmx-style">
                                            Entre 14h et 18h
                                        </button>
                                    @else
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                        <div class="morning-session">&nbsp;</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

    </div>
</form>
