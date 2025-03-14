<footer class="mt-auto bg-primary-light py-8">
    <!-- Desktop version (hidden on small screens) -->
    <div class="hidden md:block max-w-screen-xl mx-auto px-4">
        <div class="flex flex-row items-center justify-between">
            <!-- Left side with logo -->
            <div class="flex items-center">
                <img src="{{ asset('assets/images/fitm-logo-2.png') }}" alt="FITM Logo" class="h-16 w-auto">
            </div>

            <!-- Middle with faculty information -->
            <div class="text-center text-white">
                <p class="font-medium">{{ __('messages.faculty_name') }}</p>
                <p class="font-medium">{{ __('messages.faculty_name_short') }}</p>
                <p class="font-medium">{{ __('messages.address') }}</p>
                <!-- เพิ่มส่วนแสดงผู้เข้าชม -->
            </div>

            <!-- Right side with social media -->
            <div class="flex flex-col items-end">
                <p class="text-white font-medium mb-2">{{ __('messages.follow_us') }}</p>
                <div class="flex space-x-4 mb-4">
                    <a href="https://www.facebook.com/FITM.KMUTNB" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/channel/UCkiWBq0aVRQe50C42IOx1Xw" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                            </path>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                        </svg>
                    </a>
                    <a href="https://twitter.com/FITM_Official" target="_blank" class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="6" ry="6" fill="none"
                                stroke="currentColor" stroke-width="1.5" />
                            <path
                                d="M16.5 5h2.25l-5 5.75 5.5 7.25h-4.75l-3.25-4.5-3.75 4.5h-2.25l5.25-6-5-7h4.75l2.75 4z"
                                fill="white" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/fitm_official/" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                </div>
                {{-- view count --}}
                <div class="flex items-center text-white">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span>{{ __('messages.today_visitors') }}: <span id="today-visitors"
                            class="font-bold">{{ $todayVisitors ?? 0 }}</span></span>
                </div>
                <div class="flex items-center text-white">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <span>{{ __('messages.total_visitors') }}: <span id="total-visitors"
                            class="font-bold">{{ $totalVisitors ?? 0 }}</span></span>
                </div>
            </div>
        </div>

        <!-- Copyright section at bottom -->
        <div class="mt-6 text-center">
            <p class="text-sm text-white">{{ __('messages.copyright') }}</p>
        </div>
    </div>

    <!-- Mobile version (only visible on small screens) -->
    <div class="md:hidden max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col items-center justify-center space-y-6 text-white">
            <!-- Logo -->
            <div class="mb-4">
                <img src="{{ asset('assets/images/fitm-logo-2.png') }}" alt="FITM Logo" class="h-20 w-auto">
            </div>

            <!-- Faculty Information -->
            <div class="text-center">
                <p class="font-medium">{{ __('messages.faculty_name') }}</p>
                <p class="font-medium">{{ __('messages.faculty_name_short') }}</p>
                <p class="font-medium">{{ __('messages.address') }}</p>
            </div>

            <!-- Social Media Section -->
            <div class="flex flex-col items-center space-y-2">
                <p class="font-medium">{{ __('messages.follow_us') }}</p>
                <div class="flex space-x-6">
                    <a href="https://www.facebook.com/FITM.KMUTNB" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/channel/UCkiWBq0aVRQe50C42IOx1Xw" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                            </path>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                        </svg>
                    </a>
                    <a href="https://twitter.com/FITM_Official" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="6" ry="6"
                                fill="none" stroke="currentColor" stroke-width="1.5" />
                            <path
                                d="M16.5 5h2.25l-5 5.75 5.5 7.25h-4.75l-3.25-4.5-3.75 4.5h-2.25l5.25-6-5-7h4.75l2.75 4z"
                                fill="white" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/fitm_official/" target="_blank"
                        class="text-white hover:text-gray-200">
                        <svg class="w-8 h-8" stroke="currentColor" fill="none" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                </div>
                {{-- view count --}}
                <div class="flex items-center text-white">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span>{{ __('messages.today_visitors') }}: <span id="today-visitors"
                            class="font-bold">{{ $todayVisitors ?? 0 }}</span></span>
                </div>
                <div class="flex items-center text-white">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <span>{{ __('messages.total_visitors') }}: <span id="total-visitors"
                            class="font-bold">{{ $totalVisitors ?? 0 }}</span></span>
                </div>
            </div>

            <!-- Copyright -->
            <p class="text-sm">{{ __('messages.copyright') }}</p>
        </div>
    </div>
</footer>

<!-- เพิ่ม Script สำหรับดึงข้อมูลจำนวนผู้เข้าชมแบบ Ajax -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ดึงข้อมูลจำนวนผู้เข้าชม
        fetch('/admin/api/visitors/stats')
            .then(response => response.json())
            .then(data => {
                // อัปเดตข้อมูลในหน้าเว็บ
                const todayVisitorsElements = document.querySelectorAll(
                    '#today-visitors, #today-visitors-mobile');
                const totalVisitorsElements = document.querySelectorAll(
                    '#total-visitors, #total-visitors-mobile');

                todayVisitorsElements.forEach(element => {
                    if (element) element.textContent = data.todayVisitors;
                });

                totalVisitorsElements.forEach(element => {
                    if (element) element.textContent = data.totalVisitors;
                });
            })
            .catch(error => {
                console.error('ไม่สามารถดึงข้อมูลจำนวนผู้เข้าชมได้:', error);
            });
    });
</script>
