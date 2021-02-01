@include('nav')


                    @if(Auth::user())
                        @yield('crm')
                    @else
                        @yield('content')
                    @endif
                </div>
            </div>
        </div>

    </main>

    <slideout-panel></slideout-panel>

</div>
