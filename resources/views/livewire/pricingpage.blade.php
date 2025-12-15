<div>
    <div id="subscription" class="relative isolate bg-white px-6 py-24 sm:py-32 lg:px-8" data-aos="fade-up" data-aos-duration="2000">
        <div aria-hidden="true" class="absolute inset-x-0 -top-3 -z-10 transform-gpu overflow-hidden px-36 blur-3xl">
          <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="mx-auto aspect-1155/678 w-288.75 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"></div>
        </div>
        <div class="mx-auto max-w-4xl text-center" >
          <h2 class="text-base/7 font-semibold text-gray-900">Pricing</h2>
          <p class="mt-2 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-6xl">Job Portal Access Plans</p>
        </div>
        <p class="mx-auto mt-6 max-w-2xl text-center text-lg font-medium text-pretty text-gray-600 sm:text-xl/8"> Subscribe to gain full access to job listings, company profiles, and exclusive opportunities.</p>
        <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 items-center gap-y-6 sm:mt-20 sm:gap-y-0 lg:max-w-4xl lg:grid-cols-2">
          <div class="rounded-3xl rounded-t-3xl bg-white/60 p-8 ring-1 ring-gray-900/10 sm:mx-8 sm:rounded-b-none sm:p-10 lg:mx-0 lg:rounded-tr-none lg:rounded-bl-3xl">
            <h3 id="tier-hobby" class="text-base/7 font-semibold text-gray-900">Monthly Access</h3>
            <p class="mt-4 flex items-baseline gap-x-2">
              <span class="text-5xl font-semibold tracking-tight text-gray-900">₱500</span>
              <span class="text-base text-gray-500">/month</span>
            </p>
            <p class="mt-6 text-base/7 text-gray-600">Perfect for short-term access to job opportunities and company listings.</p>
            <ul role="list" class="mt-8 space-y-3 text-sm/6 text-gray-600 sm:mt-10">
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-gray-900">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Access to all job postings
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-gray-900">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                View company profiles and details
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-gray-900">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Apply to available job opportunities
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-gray-900">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                1-month unlimited access
              </li>
            </ul>
            <button
            type="button"
            onclick="Swal.fire({
                icon: 'question',
                title: 'Confirm Subscription',
                text: 'Do you want to access the Monthly Plan for ₱500?',
                confirmButtonText: 'Yes, Continue',
                confirmButtonColor: '#000000',
                showCancelButton: true,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save selection in localStorage
                    localStorage.setItem('selectedPlan', JSON.stringify({
                        plan: 'Monthly Access',
                        price: 500
                    }));
                    Livewire.navigate('{{ route('register') }}');
                }
            })"
            aria-describedby="tier-hobby"
            class="mt-8 block w-full rounded-md px-3.5 py-2.5 text-center text-sm font-semibold text-gray-900 inset-ring inset-ring-indigo-200 hover:inset-ring-indigo-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:mt-10"
        >
        Get started today
            </button>
          </div>
          <div class="relative rounded-3xl bg-gray-900 p-8 shadow-2xl ring-1 ring-gray-900/10 sm:p-10">
            <h3 id="tier-enterprise" class="text-base/7 font-semibold text-white">1-Year Promo Access</h3>
            <p class="mt-4 flex items-baseline gap-x-2">
              <span class="text-5xl font-semibold tracking-tight text-white">₱2,500</span>
              <span class="text-base text-gray-400">/year</span>
            </p>
            <p class="mt-6 text-base/7 text-gray-300"> Best value plan with long-term access to all job portal features.</p>
            <ul role="list" class="mt-8 space-y-3 text-sm/6 text-gray-300 sm:mt-10">
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Unlimited access to job postings
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Full company profile visibility
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Unlimited job applications
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Priority access to new job listings
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Priority access to new job listings
              </li>
              <li class="flex gap-x-3">
                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="h-6 w-5 flex-none text-white">
                  <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
                </svg>
                Save more with annual promo
              </li>
            </ul>
            <button
                type="button"
                onclick="Swal.fire({
                    icon: 'question',
                    title: 'Confirm Subscription',
                    text: 'Do you want to access the 1-Year Promo Plan for ₱2,500?',
                    confirmButtonText: 'Yes, Continue',
                    confirmButtonColor: '#000000',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Save selection in localStorage
                        localStorage.setItem('selectedPlan', JSON.stringify({
                            plan: '1-Year Promo Access',
                            price: 2500
                        }));
                        Livewire.navigate('{{ route('register') }}');
                    }
                })"
                aria-describedby="tier-enterprise"
                class="mt-8 block w-full rounded-md bg-gray-100 px-3.5 py-2.5 text-center text-sm font-semibold text-gray-900 shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 sm:mt-10"
            >
                Get started today
            </button>
        
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>
