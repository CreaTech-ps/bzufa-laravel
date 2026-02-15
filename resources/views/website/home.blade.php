@extends('website.layout')

@section('content')
<section class="relative h-[650px] pt-6">
            <div class="absolute top-0 right-0 -z-10 opacity-10 dark:opacity-20 pointer-events-none">
                <svg fill="none" height="600" viewBox="0 0 600 600" width="600" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="300" cy="300" fill="url(#paint0_radial)" r="300"></circle>
                    <defs>
                        <radialGradient cx="0" cy="0" gradientTransform="translate(300 300) rotate(90) scale(300)"
                            gradientUnits="userSpaceOnUse" id="paint0_radial" r="1">
                            <stop stop-color="#0BA66D"></stop>
                            <stop offset="1" stop-color="#0BA66D" stop-opacity="0"></stop>
                        </radialGradient>
                    </defs>
                </svg>
            </div>

            <div class="container mx-auto px-6 lg:px-12">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    <div
                        class="order-2 lg:order-2 relative flex justify-center items-center py-10 md:py-0 scale-90 md:scale-100 float-animation">

                        <div class="parallel-cyrcle cyrcle-1">
                            <img alt="Student" class="rotated-img"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUPXODDN0v4kZRHFbTZmKaHw3iMD1kBS1QCI9FQqCTASiLUm9InU61rKi8Q-r3eIc0AwfzPP6ALeGWWyKQpa6W0Ah_bJlI_XqF0YWlOV5JSta7QRyYGtMFjvBfwkyE8mD94y2ZXYJ0-Jmk6zpOiYygCH2xYPO4Pl2OvCpQhXhD9ldBmEZwKDD_oT3V-2-zcMLyHtQfFLqywbB6EXQrS87kZBz5xW6_zBzYI4ttU2scrOq0k3jXqEDI11UpfnGsx4AqKqq9NpEb5-4" />
                        </div>

                        <div class="parallel-cyrcle cyrcle-2">
                            <img alt="Student" class="rotated-img"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUPXODDN0v4kZRHFbTZmKaHw3iMD1kBS1QCI9FQqCTASiLUm9InU61rKi8Q-r3eIc0AwfzPP6ALeGWWyKQpa6W0Ah_bJlI_XqF0YWlOV5JSta7QRyYGtMFjvBfwkyE8mD94y2ZXYJ0-Jmk6zpOiYygCH2xYPO4Pl2OvCpQhXhD9ldBmEZwKDD_oT3V-2-zcMLyHtQfFLqywbB6EXQrS87kZBz5xW6_zBzYI4ttU2scrOq0k3jXqEDI11UpfnGsx4AqKqq9NpEb5-4" />
                        </div>

                        <div class="flex gap-4 md:gap-6 items-center justify-center relative z-10">
                            <div class="parallel-bar">
                                <img alt="Student" class="rotated-img"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUPXODDN0v4kZRHFbTZmKaHw3iMD1kBS1QCI9FQqCTASiLUm9InU61rKi8Q-r3eIc0AwfzPP6ALeGWWyKQpa6W0Ah_bJlI_XqF0YWlOV5JSta7QRyYGtMFjvBfwkyE8mD94y2ZXYJ0-Jmk6zpOiYygCH2xYPO4Pl2OvCpQhXhD9ldBmEZwKDD_oT3V-2-zcMLyHtQfFLqywbB6EXQrS87kZBz5xW6_zBzYI4ttU2scrOq0k3jXqEDI11UpfnGsx4AqKqq9NpEb5-4" />
                            </div>
                            <div class="parallel-bar mt-16 md:mt-24">
                                <img alt="Campus" class="rotated-img"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUPXODDN0v4kZRHFbTZmKaHw3iMD1kBS1QCI9FQqCTASiLUm9InU61rKi8Q-r3eIc0AwfzPP6ALeGWWyKQpa6W0Ah_bJlI_XqF0YWlOV5JSta7QRyYGtMFjvBfwkyE8mD94y2ZXYJ0-Jmk6zpOiYygCH2xYPO4Pl2OvCpQhXhD9ldBmEZwKDD_oT3V-2-zcMLyHtQfFLqywbB6EXQrS87kZBz5xW6_zBzYI4ttU2scrOq0k3jXqEDI11UpfnGsx4AqKqq9NpEb5-4" />
                            </div>
                        </div>

                        <div class="absolute inset-0 flex items-center justify-center -z-10 pointer-events-none">
                            <div
                                class="w-[300px] h-[300px] md:w-[450px] md:h-[450px] lg:w-[550px] lg:h-[550px] border border-dashed border-primary/30 rounded-full">
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-1 text-center lg:text-right">
                        <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold leading-tight mb-6">
                            @php
                                $heroTitle = $homeSetting->hero_title_ar ?? 'ندعم طموحهم، ليبنوا المستقبل';
                                $titleParts = str_contains($heroTitle, '،') ? explode('،', $heroTitle, 2) : [$heroTitle, ''];
                            @endphp
                            <span class="block text-slate-900 dark:text-white">{{ trim($titleParts[0]) }}@if(!empty(trim($titleParts[1] ?? '')))،@endif</span>
                            <span class="block text-primary">{{ trim($titleParts[1] ?? 'ليبنوا المستقبل') ?: 'ليبنوا المستقبل' }}</span>
                        </h1>
                        <p
                            class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-10 max-w-2xl lg:ml-0 lg:mr-auto leading-relaxed">
                            {{ $homeSetting->hero_subtitle_ar ?? 'نحن ملتزمون بتمكين طلبة جامعة بيرزيت من خلال توفير المنح الدراسية وفرص التدريب المهني لتذليل العقبات المالية أمام تميزهم الأكاديمي.' }}
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                            <a href="{{ $homeSetting->cta_url ?? '#' }}"
                                class="bg-primary hover:bg-secondary text-white px-8 lg:px-12 py-4 rounded-full text-lg lg:text-xl font-bold transition-all hover:scale-105 shadow-lg shadow-primary/20 text-center">
                                {{ $homeSetting->cta_text_ar ?? 'تبرع الآن' }}
                            </a>
                            <button
                                class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-primary px-8 lg:px-12 py-4 rounded-full text-lg lg:text-xl font-bold transition-all">
                                التقرير السنوي
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="py-12 -mt-16 relative z-20">
            <div class="main-container">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($statistics as $stat)
                    <div
                        class="group bg-white dark:bg-card-dark p-8 rounded-3xl shadow-xl hover:shadow-2xl dark:card-shadow border border-slate-100 dark:border-white/5 text-center flex flex-col items-center transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-700">
                        </div>

                        <div
                            class="w-14 h-14 bg-green-100 dark:bg-primary/20 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-[10deg] transition-transform duration-300 shadow-inner">
                            <span class="material-symbols-outlined text-3xl">{{ $stat->icon ?? 'analytics' }}</span>
                        </div>
                        <h3 class="text-4xl font-black mb-2 dark:text-white flex items-center gap-1">
                            <span>+</span>
                            <span class="counter" data-target="{{ $stat->value }}">0</span>
                        </h3>
                        <p class="text-slate-500 dark:text-text-secondary-dark font-bold tracking-wide">{{ $stat->label_ar }}</p>
                    </div>
                    @empty
                    {{-- إحصائيات افتراضية عند عدم وجود بيانات --}}
                    @foreach([
                        ['value' => 1200, 'icon' => 'history_edu', 'label' => 'منحة دراسية'],
                        ['value' => 850, 'icon' => 'model_training', 'label' => 'طالب مستفيد'],
                        ['value' => 45, 'icon' => 'handshake', 'label' => 'شركة شريكة'],
                        ['value' => 300, 'icon' => 'workspace_premium', 'label' => 'قصة نجاح'],
                    ] as $stat)
                    <div
                        class="group bg-white dark:bg-card-dark p-8 rounded-3xl shadow-xl hover:shadow-2xl dark:card-shadow border border-slate-100 dark:border-white/5 text-center flex flex-col items-center transition-all duration-500 hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="w-14 h-14 bg-green-100 dark:bg-primary/20 text-primary rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-[10deg] transition-transform duration-300 shadow-inner">
                            <span class="material-symbols-outlined text-3xl">{{ $stat['icon'] }}</span>
                        </div>
                        <h3 class="text-4xl font-black mb-2 dark:text-white flex items-center gap-1">
                            <span>+</span>
                            <span class="counter" data-target="{{ $stat['value'] }}">0</span>
                        </h3>
                        <p class="text-slate-500 dark:text-text-secondary-dark font-bold tracking-wide">{{ $stat['label'] }}</p>
                    </div>
                    @endforeach
                    @endforelse
                </div>
            </div>
        </section>
        <section class="py-20 bg-slate-50 dark:bg-[#151515]">
            <div class="main-container">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-2 dark:text-white">مشاريعنا</h2>
                        <div class="h-1 w-20 bg-primary rounded-full"></div>
                    </div>

                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white dark:bg-card-dark rounded-2xl overflow-hidden shadow-lg dark:card-shadow border border-slate-200 dark:border-white/5 group">
                        <div class="relative h-56 overflow-hidden">
                            <img alt="Academic Excellence"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUPXODDN0v4kZRHFbTZmKaHw3iMD1kBS1QCI9FQqCTASiLUm9InU61rKi8Q-r3eIc0AwfzPP6ALeGWWyKQpa6W0Ah_bJlI_XqF0YWlOV5JSta7QRyYGtMFjvBfwkyE8mD94y2ZXYJ0-Jmk6zpOiYygCH2xYPO4Pl2OvCpQhXhD9ldBmEZwKDD_oT3V-2-zcMLyHtQfFLqywbB6EXQrS87kZBz5xW6_zBzYI4ttU2scrOq0k3jXqEDI11UpfnGsx4AqKqq9NpEb5-4" />

                            <span
                                class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full">تدريب</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 dark:text-white">مشروع تمكين الطلبة</h3>
                            <p class="text-slate-500 dark:text-text-secondary-dark text-sm leading-relaxed mb-6">توفير
                                ورش عمل ودورات متخصصة بالتعاون مع كبرى الشركات لتهيئة الطلبة لسوق العمل واكتساب مهارات
                                عملية.</p>
                            <div class="mb-6">
                                <div class="flex justify-between text-sm font-bold mb-2">
                                    <span class="dark:text-text-primary-dark">تم تدريب: <span class="text-primary">150
                                            طالب</span></span>
                                    <span class="text-primary">85%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-white/10 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: 85%"></div>
                                </div>
                                <div class="text-xs text-slate-400 dark:text-text-secondary-dark mt-2">الهدف السنوي: 180
                                    متدرب</div>
                            </div>
                            <button onclick="window.location.href='{{ route('tamkeen.index') }}'"
                                class="w-full bg-primary/10 text-primary dark:bg-primary/20 hover:bg-primary hover:text-white font-bold py-3 rounded-xl transition-all border border-primary/20">
                                تفاصيل التدريب
                            </button>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-card-dark rounded-2xl overflow-hidden shadow-lg dark:card-shadow border border-slate-200 dark:border-white/5 group">
                        <div class="relative h-56 overflow-hidden">
                            <img alt="Vocational Training"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQY8R4Twui0hp8dUIuUzD7L84f-wRhijJUFEa6zaCY5trVngdMHRT48eILB4Hkux_96PIY7SLsIu1ZxTX0mneM2OgUp4c2OxAmEocmrh8iDC5YG5YF7oPPDxrQtg5GTAzgWXpcKCmhNX5QKVAT64PhLVXQXaVks3eA2NEoR475Nfc1NmxfkD1vrWWSaQAdaVER9xCQSlFBubc6wgKnMfCBGgfT2cavonrcSNBP1MK8SyePyG4U61HvpaiyhWpXuINjlEkwZeTneEw" />
                            <span
                                class="absolute top-4 right-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full uppercase">متجرنا</span>
                            <span
                                class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full">يد-بيد</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 dark:text-white">متجر كنعاني</h3>
                            <p class="text-slate-500 dark:text-text-secondary-dark text-sm leading-relaxed mb-6">
                                تغطية
                                الرسوم الدراسية للطلبة المتفوقين الذين يواجهون صعوبات اقتصادية لمواصلة رحلتهم
                                التعليمية.
                            </p>
                            <div class="mb-6">
                                <div class="flex justify-between text-sm font-bold mb-2">
                                    <span class="dark:text-text-primary-dark">تم تقديم: <span class="text-primary">420
                                            منحة</span></span>
                                    <span class="text-primary">70%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-white/10 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: 70%"></div>
                                </div>
                                <div class="text-xs text-slate-400 dark:text-text-secondary-dark mt-2">الهدف السنوي:
                                    600
                                    منحة</div>
                            </div>
                            <button onclick="window.location.href='{{ route('kanani.index') }}'"
                                class="w-full bg-primary text-white hover:bg-opacity-90 font-bold py-3 rounded-xl transition-all shadow-md">زيارة
                                متجرنا</button>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-card-dark rounded-2xl overflow-hidden shadow-lg dark:card-shadow border border-slate-200 dark:border-white/5 group">
                        <div class="relative h-56 overflow-hidden">
                            <img alt="Financial Aid"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjhSMsb_wCIv9rqETWGjnkWrFDfjmQV4YUiK4WowuP8SR5z81I-kzL6KIxOjY_iOmYwrRKdFoeOcnnqH8waRG9oYyg1w7L9MBBO5Bw6ayf98MAxtX0ZqyMKjWjlmJaBZS_a6WTY8tUWCyUkq80PH2lYK_7-PEu0bxAVbjB12J24CtxUAxQ8iOKBxI1HVbVWC67ttLNw4tfXwDJiAVLy5-ITyBKBu9eV99hU7AZFj650a4bmSRUKAJDdH9m6RSkc6C1nAtW_A6FYDE" />
                            <span
                                class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">إستدامة</span>
                            <span
                                class="absolute top-4 left-4 bg-black/50 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full">صندوق
                                للطلبة</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 dark:text-white">مشروع المظلات</h3>
                            <p class="text-slate-500 dark:text-text-secondary-dark text-sm leading-relaxed mb-6">هو
                                مشروع خيري يعمل على تأجير المساحات الإعلانية في أماكن مميزة وتغطية دراسة الطلاب
                                المستحقين للمنح.</p>
                            <div class="mb-6">
                                <div class="flex justify-between text-sm font-bold mb-2">
                                    <span class="dark:text-text-primary-dark">تم جمع: <span
                                            class="text-primary">40%</span></span>
                                    <span class="text-primary">62%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-white/10 h-2 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full rounded-full" style="width: 62%"></div>
                                </div>
                                <div class="text-xs text-slate-400 dark:text-text-secondary-dark mt-2">الهدف: الوصول ل
                                    130% من الهدف السنوي السابق
                                </div>
                            </div>
                            <a href="{{ route('parasols.index') }}"
                                class="block w-full bg-primary/10 text-primary dark:bg-primary/20 hover:bg-primary hover:text-white font-bold py-3 rounded-xl transition-all border border-primary/20 text-center">عرض
                                الشواغر</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-primary text-white relative overflow-hidden">
            <div class="main-container">

                <div class="swiper successStoriesSwiper pb-12">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="main-container text-center relative z-10">
                                <div class="inline-block bg-white/20 px-4 py-1 rounded-full text-sm font-bold mb-8">
                                    dsdsdsd إشادة من طلبتنا
                                </div>
                                <blockquote
                                    class="text-3xl md:text-4xl font-extrabold leading-snug mb-10 italic max-w-4xl mx-auto drop-shadow-sm">
                                    "بفضل منحة جمعية أصدقاء جامعة بيرزيت، استطعت إكمال دراستي في الهندسة دون القلق من
                                    الرسوم المرتفعة.
                                    اليوم أعمل كمهندس في كبرى شركات التكنولوجيا."
                                </blockquote>
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-20 h-20 rounded-full border-4 border-white/30 overflow-hidden mb-4 shadow-xl">
                                        <img alt="Graduate Portrait" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDDkzatml77qca_VfxhewphZL3fjRhGSlQb54nyYRw59exbtzScoLKwBNj38muJv_EgYGzBDfLmgKsXlihhpUai2z5gbLXrGz_SUDe3X7mfNWca5aOy9aVZp11APEyzdVFQZdBGiGDjs6ZD1BlypgNPCBwgkMQdiPlu38q6yx3pidn25VTy1NC_-bo2pYhv02lHmunNOPv00uC2M9RMXiNar4lkS70L9mlLQIltwv4aQYNPf9-G8zGbhK9CIKJb8LfCso5q61pdE-Y" />
                                    </div>
                                    <h4 class="text-xl font-bold">أحمد محمود</h4>
                                    <p class="text-white/90">خريج هندسة حاسوب - دفعة 2023</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="main-container text-center relative z-10">
                                <div class="inline-block bg-white/20 px-4 py-1 rounded-full text-sm font-bold mb-8">
                                    إشادة من طلبتنا
                                </div>
                                <blockquote
                                    class="text-3xl md:text-4xl font-extrabold leading-snug mb-10 italic max-w-4xl mx-auto drop-shadow-sm">
                                    "بفضل منحة جمعية أصدقاء جامعة بيرزيت، استطعت إكمال دراستي في الهندسة دون القلق من
                                    الرسوم المرتفعة.
                                    اليوم أعمل كمهندس في كبرى شركات التكنولوجيا."
                                </blockquote>
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-20 h-20 rounded-full border-4 border-white/30 overflow-hidden mb-4 shadow-xl">
                                        <img alt="Graduate Portrait" class="w-full h-full object-cover"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDDkzatml77qca_VfxhewphZL3fjRhGSlQb54nyYRw59exbtzScoLKwBNj38muJv_EgYGzBDfLmgKsXlihhpUai2z5gbLXrGz_SUDe3X7mfNWca5aOy9aVZp11APEyzdVFQZdBGiGDjs6ZD1BlypgNPCBwgkMQdiPlu38q6yx3pidn25VTy1NC_-bo2pYhv02lHmunNOPv00uC2M9RMXiNar4lkS70L9mlLQIltwv4aQYNPf9-G8zGbhK9CIKJb8LfCso5q61pdE-Y" />
                                    </div>
                                    <h4 class="text-xl font-bold">أحمد محمود</h4>
                                    <p class="text-white/90">خريج هندسة حاسوب - دفعة 2023</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="flex justify-center gap-4 mt-8">
                        <div
                            class="swiper-button-prev-custom cursor-pointer w-10 h-10 rounded-full  flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </div>
                        <div
                            class="swiper-button-next-custom cursor-pointer w-10 h-10 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section
            class="py-24 bg-white dark:bg-background-dark overflow-hidden border-y border-slate-50 dark:border-white/5">
            <div class="main-container text-center">

                <div class="flex flex-col items-center mb-16">
                    <span
                        class="text-primary font-bold text-sm bg-primary/10 px-4 py-1 rounded-full mb-4 tracking-wider">
                        شبكة النجاح
                    </span>
                    <h2 class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white relative inline-block">
                        شركاؤنا في دعم التعليم

                    </h2>
                    <p class="mt-6 text-slate-500 dark:text-slate-400 max-w-xl mx-auto">
                        نفتخر بالتعاون مع كبرى المؤسسات والشركات التي تساهم في بناء مستقبل طلبتنا
                    </p>
                </div>

                <div class="relative flex overflow-hidden group mb-16">
                    <div
                        class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-white dark:from-background-dark to-transparent z-10">
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-white dark:from-background-dark to-transparent z-10">
                    </div>

                    <div class="flex animate-infinite-scroll gap-24 items-center whitespace-nowrap">
                        @php $partnerLogoClass = 'max-h-12 w-auto min-w-[120px] object-contain opacity-60 hover:opacity-100 dark:hover:invert-0 transition-all duration-500'; @endphp
                        <div class="flex gap-24 items-center flex-shrink-0">
                            @forelse($partners as $partner)
                            <a href="{{ $partner->link ?? '#' }}" {{ $partner->link ? 'target="_blank" rel="noopener"' : '' }}
                                class="block focus:outline-none">
                                <img alt="{{ $partner->name_ar }}"
                                    class="{{ $partnerLogoClass }}"
                                    src="{{ $partner->logo_path ? asset('storage/' . $partner->logo_path) : asset('assets/img/logo-l.svg') }}" />
                            </a>
                            @empty
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            @endforelse
                        </div>
                        <div class="flex gap-24 items-center flex-shrink-0">
                            @forelse($partners as $partner)
                            <a href="{{ $partner->link ?? '#' }}" {{ $partner->link ? 'target="_blank" rel="noopener"' : '' }}
                                class="block focus:outline-none">
                                <img alt="{{ $partner->name_ar }}"
                                    class="{{ $partnerLogoClass }}"
                                    src="{{ $partner->logo_path ? asset('storage/' . $partner->logo_path) : asset('assets/img/logo-l.svg') }}" />
                            </a>
                            @empty
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            <img alt="Partner" class="{{ $partnerLogoClass }}" src="{{ asset('assets/img/logo-l.svg') }}" />
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('partners.index') }}"
                        class="inline-flex items-center gap-3 bg-white dark:bg-card-dark text-slate-700 dark:text-white border border-slate-200 dark:border-white/10 px-8 py-3.5 rounded-full font-bold hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 shadow-sm hover:shadow-lg group">
                        <span>استعرض جميع الشركاء</span>
                        <span
                            class="material-symbols-outlined group-hover:translate-x-[-4px] transition-transform">arrow_back</span>
                    </a>
                </div>

            </div>
        </section>

        <section class="py-20 bg-slate-50 dark:bg-[#151515]">
            <div class="main-container">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-2 dark:text-white">أخبار الجمعية والجامعة</h2>
                        <div class="h-1 w-20 bg-primary rounded-full"></div>
                    </div>
                    <a href="{{ route('news.index') }}"
                        class="bg-white dark:bg-card-dark border border-slate-200 dark:border-white/5 px-6 py-2 rounded-full font-bold shadow-sm hover:shadow-md transition-all dark:text-text-primary-dark">تصفح
                        المدونة</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($newsItems as $item)
                    <a href="{{ route('news.show', $item->slug_ar ?: $item->id) }}"
                        class="bg-white dark:bg-card-dark rounded-2xl overflow-hidden shadow-md dark:card-shadow border border-slate-100 dark:border-white/5 group block">
                        <div class="relative h-48 overflow-hidden">
                            <img alt="{{ $item->title_ar }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform"
                                src="{{ $item->image_path ? asset('storage/' . $item->image_path) : 'https://via.placeholder.com/400x200?text=خبر' }}" />
                        </div>
                        <div class="p-5">
                            <div
                                class="flex items-center text-xs text-slate-400 dark:text-text-secondary-dark mb-3 gap-2">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $item->published_at?->locale('ar')->translatedFormat('d F Y') ?? '—' }}
                            </div>
                            <h3
                                class="font-bold mb-3 line-clamp-2 hover:text-primary transition-colors leading-relaxed dark:text-white">
                                {{ $item->title_ar }}
                            </h3>
                            <span class="text-primary text-xs font-bold flex items-center gap-1">
                                إقرأ المزيد <span class="material-symbols-outlined text-sm">arrow_left</span>
                            </span>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-12 text-slate-500 dark:text-slate-400">
                        لا توجد أخبار منشورة حالياً
                    </div>
                    @endforelse
                </div>
            </div>
        </section>
@endsection
