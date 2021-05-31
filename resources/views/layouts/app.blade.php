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

   <section class="footer">
     <footer class="page-footer font-small blue">
  <!-- Copyright -->
  <div class="footer-copyright text-center py-3 ft-p">© 2021 Copyright:
    <a href="http://localhost:8000/"> Profresh.com</a>
  </div>
  <!-- Copyright -->
</footer>
   </section>
