      <!--  Header Start -->
      <header class="app-header">
          <nav class="navbar navbar-expand-lg navbar-light">
              <ul class="navbar-nav">
                  <li class="nav-item d-block d-xl-none">
                      <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                          <i class="ti ti-menu-2"></i>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-home"></i>
                {{-- <div class="notification bg-primary rounded-circle"></div> --}}
              </a>
                  </li>
              </ul>
              <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                  <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                      <div x-data="{ open: false }" class="relative ">
                          {{-- <button @click="open = !open" class="px-4 py-2 text-gray-800 bg-white border rounded">
                              Select Language
                          </button> --}}
                          <div x-show="open" @click.away="open = false"
                              class="absolute mt-2 w-48">
                              @foreach (['en' => __('messages.english'), 'km' => __('messages.khmer')] as $lang => $language)
                                  @if (app()->getLocale() !== $lang)
                                      <a href="{{ route('language.switch', ['language' => $lang]) }}"
                                          class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100">
                                          <img src="{{ asset('picture/images/flags/' . $lang . '.png') }}"
                                              alt="{{ $lang }} flag" class="w-5 h-5 mr-2">
                                          {{-- {{ $language }} --}}
                                      </a>
                                  @endif
                              @endforeach
                          </div>
                      </div>



                      {{-- <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                  </a> --}}
                      {{-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a> --}}
                      <li class="nav-item dropdown">
                          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                              data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="../assets/images/profile/user-1.jpg" alt="" width="35"
                                  height="35" class="rounded-circle">
                          </a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                              <div class="message-body">

                                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                      <i class="ti ti-user fs-6"></i>
                                      <p class="mb-0 fs-3">My Profile</p>
                                  </a>
                                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                      <i class="ti ti-mail fs-6"></i>
                                      <p class="mb-0 fs-3">My Account</p>
                                  </a>
                                  <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                      <i class="ti ti-list-check fs-6"></i>
                                      <p class="mb-0 fs-3">My Task</p>
                                  </a>
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                      @csrf
                                  </form>
                                  <a href="#" class="btn btn-outline-primary mx-3 mt-2 d-block"
                                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('messages.logout') }}</a>
                              </div>
                          </div>
                      </li>
                  </ul>
              </div>
          </nav>
      </header>
      <!--  Header End -->
