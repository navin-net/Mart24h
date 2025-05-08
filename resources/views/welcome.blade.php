@extends('shop.layout.app')
@section('title', __('messages.shop'))

@section('content')

<section class="section banner relative">
    <div class="container">
      <div class="row items-center">
        <div class="lg:col-6">
          <h1 class="banner-title">
            Scale design & dev operations with Avocode Enterprise
          </h1>
          <p class="mt-6">
            A fully integrated suite of authentication & authoriz products,
            Stytch’s platform removes the headache of.
          </p>
          <a class="btn btn-white mt-8" href="#">Download The Theme</a>
        </div>
        <div class="lg:col-6">
          <img class="w-full object-contain" src="images/banner-img.png" width="603" height="396" alt="" />
        </div>
      </div>
    </div>
    <img class="banner-shape absolute -top-28 right-0 -z-[1] w-full max-w-[30%]" src="images/banner-shape.svg" alt="" />
  </section>
  <!-- ./end Banner -->

  <!-- Key features -->
  <section class="section key-feature relative">
    <img class="absolute left-0 top-0 -z-[1] -translate-y-1/2" src="images/icons/feature-shape.svg" alt="" />
    <div class="container">
      <div class="row justify-between text-center lg:text-start">
        <div class="lg:col-5">
          <h2>The Highlighting Part Of Our Solution</h2>
        </div>
        <div class="mt-6 lg:col-5 lg:mt-0">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi egestas
            Werat viverra id et aliquet. vulputate egestas sollicitudin .
          </p>
        </div>
      </div>
      <div class="key-feature-grid mt-10 grid grid-cols-2 gap-7 md:grid-cols-3 xl:grid-cols-4">
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Live Caption</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-1.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Smart Reply</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-2.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Sound Amplifier</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-3.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Gesture Navigation</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-4.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Dark Theme</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-5.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Privacy Controls</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-6.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Location Controls</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-7.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Security Updates</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-8.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Focus Mode</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-9.svg" alt="" />
          </span>
        </div>
        <div class="flex flex-col justify-between rounded-lg bg-white p-5 shadow-lg">
          <div>
            <h3 class="h4 text-xl lg:text-2xl">Family Link</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
          </div>
          <span class="icon mt-4">
            <img class="objec-contain" src="images/icons/feature-icon-10.svg" alt="" />
          </span>
        </div>
      </div>
    </div>
  </section>
  <!-- ./end Key features -->

  <!-- Services -->
  <section class="section services">
    <div class="container">
      <div class="tab row gx-5 items-center" data-tab-group="integration-tab">
        <div class="lg:col-7 lg:order-2">
          <div class="tab-content" data-tab-content>
            <div class="tab-content-panel active" data-tab-panel="0">
              <img class="w-full object-contain" src="images/sells-by-country.png" />
            </div>
            <div class="tab-content-panel" data-tab-panel="1">
              <img class="w-full object-contain" src="images/collaboration.png" />
            </div>
            <div class="tab-content-panel" data-tab-panel="2">
              <img class="w-full object-contain" src="images/sells-by-country.png" />
            </div>
          </div>
        </div>
        <div class="mt-6 lg:col-5 lg:order-1 lg:mt-0">
          <div class="text-container">
            <h2 class="lg:text-4xl">
              Prevent failure from to impacting your reputation
            </h2>
            <p class="mt-4">
              Our platform helps you build secure onboarding authentication
              experiences that retain and engage your users. We build the
              infrastructure, you can.
            </p>
            <ul class="tab-nav -ml-4 mt-8 border-b-0" data-tab-nav>
              <li class="tab-nav-item active" data-tab="0">
                <img class="mr-3" src="images/icons/drop.svg" alt="" />
                Habit building essential choose habit
              </li>
              <li class="tab-nav-item" data-tab="1">
                <img class="mr-3" src="images/icons/brain.svg" alt="" />
                Get an overview of Habit Calendars.
              </li>
              <li class="tab-nav-item" data-tab="2">
                <img class="mr-3" src="images/icons/timer.svg" alt="" />
                Start building with Habitify platform
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row gx-5 mt-12 items-center lg:mt-0">
        <div class="lg:col-7">
          <div class="relative">
            <img class="w-full object-contain" src="images/collaboration.png" />
            <img class="absolute bottom-6 left-1/2 -z-[1] -translate-x-1/2" src="images/shape.svg" alt="" />
          </div>
        </div>
        <div class="mt-6 lg:col-5 lg:mt-0">
          <div class="text-container">
            <h2 class="lg:text-4xl">
              Accept payments any country in this whole universe
            </h2>
            <p class="mt-4">
              Donec sollicitudin molestie malesda. Donec sollitudin molestie
              malesuada. Mauris pellentesque nec, egestas non nisi. Cras ultricies
              ligula sed
            </p>
            <ul class="mt-6 text-dark lg:-ml-4">
              <li class="mb-2 flex items-center rounded px-4">
                <img class="mr-3" src="images/icons/checkmark-circle.svg" alt="" />
                Supporting more than 119 country world
              </li>
              <li class="mb-2 flex items-center rounded px-4">
                <img class="mr-3" src="images/icons/checkmark-circle.svg" alt="" />
                Open transaction with more than currencies
              </li>
              <li class="flex items-center rounded px-4">
                <img class="mr-3" src="images/icons/checkmark-circle.svg" alt="" />
                Customer Service with 79 languages
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row gx-5 mt-12 items-center lg:mt-0">
        <div class="lg:col-7 lg:order-2">
          <div class="video pb-5 pr-9">
            <div class="video-thumbnail overflow-hidden rounded-2xl">
              <img class="w-full object-contain" src="images/intro-thumbnail.png" alt="" />
              <button class="video-play-btn">
                <img src="images/icons/play-icon.svg" alt="" />
              </button>
            </div>
            <div class="video-player absolute left-0 top-0 z-10 hidden h-full w-full">
              <iframe class="h-full w-full" allowfullscreen=""
                src="https://www.youtube.com/embed/g3-VxLQO7do?autoplay=1"></iframe>
            </div>
            <img class="intro-shape absolute bottom-0 right-0 -z-[1]" src="images/shape.svg" alt="" />
          </div>
        </div>
        <div class="mt-6 lg:col-5 lg:order-1 lg:mt-0">
          <div class="text-container">
            <h2 class="lg:text-4xl">Accountability that works for you</h2>
            <p class="mt-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi
              egestas Werat viverra id et aliquet. vulputate egestas sollicitudin
              .
            </p>
            <button class="btn btn-white mt-6">know about us</button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ./end Services -->

  <!-- Reviews -->
  <section class="reviews">
    <div class="container">
      <div class="row justify-between">
        <div class="lg:col-6">
          <h2>Our customers have nice things to say about us</h2>
        </div>
        <div class="lg:col-4">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi egestas
            Werat viverra id et aliquet. vulputate egestas sollicitudin .
          </p>
        </div>
      </div>
      <div class="row mt-10">
        <div class="col-12">
          <div class="swiper reviews-carousel">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="review">
                  <div class="review-author-avatar bg-gradient">
                    <img src="images/users/user-5.png" alt="" />
                  </div>
                  <h4 class="mb-2">Courtney Henry</h4>
                  <p class="mb-4 text-[#666]">microsoft corp</p>
                  <p>
                    Our platform helps build secure onboarding authentica
                    experiences & engage your users. We build .
                  </p>
                  <div class="review-rating mt-6 flex items-center justify-center space-x-2.5">
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star-white.svg" alt="" />
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="review">
                  <div class="review-author-avatar bg-gradient">
                    <img src="images/users/user-2.png" alt="" />
                  </div>
                  <h4 class="mb-2">Ronald Richards</h4>
                  <p class="mb-4 text-[#666]">meta limited</p>
                  <p>
                    Our platform helps build secure onboarding authentica
                    experiences & engage your users. We build .
                  </p>
                  <div class="review-rating mt-6 flex items-center justify-center space-x-2.5">
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star-white.svg" alt="" />
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="review">
                  <div class="review-author-avatar bg-gradient">
                    <img src="images/users/user-6.png" alt="" />
                  </div>
                  <h4 class="mb-2">Bessie Cooper</h4>
                  <p class="mb-4 text-[#666]">apple inc ltd</p>
                  <p>
                    Our platform helps build secure onboarding authentica
                    experiences & engage your users. We build .
                  </p>
                  <div class="review-rating mt-6 flex items-center justify-center space-x-2.5">
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star.svg" alt="" />
                    <img src="images/icons/star-white.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination reviews-carousel-pagination !bottom-0"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Reviews -->

  <!-- Call To action -->
  <section class="px-5 py-20 xl:py-[120px]">
    <div class="container">
      <div class="bg-gradient row justify-center rounded-b-[80px] rounded-t-[20px] px-[30px] pb-[75px] pt-16">
        <div class="lg:col-11">
          <div class="row">
            <div class="lg:col-7">
              <h2 class="h1 text-white">Helping teams in the world with focus</h2>
              <a class="btn btn-white mt-8" href="#">Download The Theme</a>
            </div>
            <div class="mt-8 lg:col-5 lg:mt-0">
              <p class="text-white">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi
                egestas Werat viverra id et aliquet. vulputate egestas
                sollicitudin .
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div
    class="fixed left-0 top-0 z-50 flex w-[30px] items-center justify-center bg-gray-200 py-[2.5px] text-[12px] uppercase text-black sm:bg-red-200 md:bg-yellow-200 lg:bg-green-200 xl:bg-blue-200 2xl:bg-pink-200">
    <span class="block sm:hidden">all</span>
    <span class="hidden sm:block md:hidden">sm</span>
    <span class="hidden md:block lg:hidden">md</span>
    <span class="hidden lg:block xl:hidden">lg</span>
    <span class="hidden xl:block 2xl:hidden">xl</span>
    <span class="hidden 2xl:block">2xl</span>
  </div>

  <footer class="footer bg-theme-light/50">
    <div class="container">
      <div class="row gx-5 pb-10 pt-[52px]">
        <div class="col-12 mt-12 md:col-6 lg:col-3">
          <a href="index.html">
            <img src="images/logo.svg" alt="" />
          </a>
          <p class="mt-6">
            Lorem ipsum dolor sit sed dmi amet, consectetur adipiscing. Cdo
            tellus, sed condimentum volutpat.
          </p>
        </div>
        <div class="col-12 mt-12 md:col-6 lg:col-3">
          <h6>Socials</h6>
          <p>themefisher@gmail.com</p>
          <ul class="social-icons mt-4 lg:mt-6">
            <li>
              <a href="#">
                <svg width="19" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M19.1056 10.4495C19.1056 5.09642 15 0.759277 9.9327 0.759277C4.86539 0.759277 0.759766 5.09642 0.759766 10.4495C0.759766 15.2946 4.08865 19.3191 8.49018 20.0224V13.2627H6.15996V10.4495H8.49018V8.33951C8.49018 5.91696 9.85872 4.54939 11.93 4.54939C12.9657 4.54939 14.0013 4.74476 14.0013 4.74476V7.12823H12.8547C11.7081 7.12823 11.3382 7.87063 11.3382 8.65209V10.4495H13.8904L13.4835 13.2627H11.3382V20.0224C15.7398 19.3191 19.1056 15.2946 19.1056 10.4495Z"
                    fill="#222222" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M16.3308 3.92621C17.0129 3.42889 17.6269 2.83209 18.1044 2.13583C17.4904 2.40108 16.7742 2.60001 16.0579 2.66632C16.8083 2.2353 17.354 1.5722 17.6269 0.743317C16.9447 1.14118 16.1603 1.43958 15.3758 1.60535C14.6937 0.909093 13.7728 0.51123 12.7496 0.51123C10.7714 0.51123 9.16837 2.06952 9.16837 3.99252C9.16837 4.25777 9.20248 4.52301 9.27069 4.78825C6.3034 4.62247 3.64307 3.22995 1.86952 1.14118C1.56256 1.63851 1.39202 2.2353 1.39202 2.8984C1.39202 4.09199 2.00595 5.15296 2.99504 5.7829C2.41523 5.74975 1.83541 5.61713 1.35792 5.35189V5.38504C1.35792 7.07596 2.58576 8.46847 4.22289 8.80002C3.95003 8.86633 3.60897 8.93265 3.302 8.93265C3.06326 8.93265 2.85862 8.89949 2.61987 8.86633C3.06326 10.2589 4.39342 11.2535 5.96233 11.2867C4.73449 12.215 3.19968 12.7786 1.52845 12.7786C1.22149 12.7786 0.948636 12.7455 0.675781 12.7123C2.24469 13.707 4.12057 14.2706 6.16698 14.2706C12.7496 14.2706 16.3308 8.99896 16.3308 4.39039C16.3308 4.22461 16.3308 4.09199 16.3308 3.92621Z"
                    fill="#222222" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M4.56609 15.2704V5.45315H0.948103V15.2704H4.56609ZM2.73764 4.1398C3.90474 4.1398 4.83841 3.31895 4.83841 2.33394C4.83841 1.38176 3.90474 0.59375 2.73764 0.59375C1.60945 0.59375 0.675781 1.38176 0.675781 2.33394C0.675781 3.31895 1.60945 4.1398 2.73764 4.1398ZM18.0654 15.2704H18.1044V9.8857C18.1044 7.259 17.4041 5.22331 13.7472 5.22331C11.9966 5.22331 10.8295 6.04415 10.3237 6.79933H10.2848V5.45315H6.82246V15.2704H10.4404V10.411C10.4404 9.13053 10.7128 7.91568 12.5801 7.91568C14.4475 7.91568 14.4864 9.36036 14.4864 10.5095V15.2704H18.0654Z"
                    fill="#222222" />
                </svg>
              </a>
            </li>
            <li>
              <a href="#">
                <svg width="19" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M15.3829 10.554C15.4875 10.0381 15.5573 9.48523 15.5573 8.9324C15.5573 4.76772 12.3483 1.37701 8.40687 1.37701C7.88367 1.37701 7.36047 1.45072 6.87215 1.56129C6.20943 1.00846 5.37231 0.676758 4.50031 0.676758C2.33775 0.676758 0.59375 2.55639 0.59375 4.80458C0.59375 5.76282 0.87279 6.64735 1.39599 7.34761C1.29135 7.86359 1.22159 8.41642 1.22159 8.9324C1.22159 13.1339 4.43055 16.5246 8.37199 16.5246C8.89518 16.5246 9.41838 16.4509 9.9067 16.3404C10.5694 16.8932 11.4065 17.188 12.2785 17.188C14.4411 17.188 16.1851 15.3453 16.1851 13.0602C16.22 12.1388 15.9061 11.2543 15.3829 10.554ZM8.61615 13.9447C6.31407 13.9447 4.39567 12.8759 4.39567 11.5491C4.39567 10.9595 4.70959 10.4066 5.44207 10.4066C6.52335 10.4066 6.62799 12.0651 8.51151 12.0651C9.3835 12.0651 9.97646 11.6597 9.97646 11.1069C9.97646 10.4066 9.41838 10.2961 8.51151 10.0749C6.34895 9.48523 4.39567 9.2641 4.39567 6.86849C4.39567 4.65716 6.45359 3.84633 8.19759 3.84633C10.116 3.84633 12.0693 4.65716 12.0693 5.91024C12.0693 6.53679 11.6856 7.08962 11.0229 7.08962C10.0462 7.08962 10.0113 5.83653 8.40687 5.83653C7.49999 5.83653 6.94191 6.09452 6.94191 6.68421C6.94191 7.38446 7.67439 7.45818 9.34862 7.90044C10.7787 8.23214 12.5227 8.85869 12.5227 10.7383C12.5227 12.9128 10.5345 13.9447 8.61615 13.9447Z"
                    fill="#222222" />
                </svg>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-12 mt-12 md:col-6 lg:col-3">
          <h6>Quick Links</h6>
          <ul>
            <li>
              <a href="about.html">About</a>
            </li>
            <li>
              <a href="#">Category</a>
            </li>
            <li>
              <a href="#">Testimonial</a>
            </li>
            <li>
              <a href="contact.html">Contact</a>
            </li>
          </ul>
        </div>
        <div class="col-12 mt-12 md:col-6 lg:col-3">
          <h6>Location & Contact</h6>
          <p>2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
          <p>(704) 555-0127</p>
        </div>
      </div>
    </div>
    <div class="container max-w-[1440px]">
      <div class="footer-copyright mx-auto border-t border-border pb-10 pt-7 text-center">
        <p>Designed And Developed by <a href="https://themefisher.com" target="_blank">Themefisher</a></p>
      </div>
    </div>
  </footer>



@endsection