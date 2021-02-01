@include('nav')

                @if(Auth::user())
                        <router-view>

                        </router-view>
                    @yield('panel')
                    @else
                        @yield('content')
                    @endif
                </div>
            </div>
        </div>

    </main>

    <slideout-panel></slideout-panel>

</div>
</body>
</html>
