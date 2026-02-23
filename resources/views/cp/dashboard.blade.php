@extends('cp.layout')

@section('title', 'لوحة التحكم')

@section('content')
<div class="space-y-8">
    {{-- تنبيه الطلبات المعلقة --}}
    @if($stats['pending_total'] > 0)
    <section class="rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800/50 p-4 flex items-center gap-4">
        <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400">
            <span class="material-symbols-outlined text-2xl">pending_actions</span>
        </span>
        <div>
            <p class="font-bold text-slate-800 dark:text-white">{{ $stats['pending_total'] }} طلب يحتاج إلى متابعة</p>
            <p class="text-sm text-slate-600 dark:text-slate-400">راجع الطلبات والنماذج من القائمة الجانبية</p>
        </div>
        <a href="{{ route('cp.scholarship-applications.index') }}" class="ms-auto px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            طلبات المنح
        </a>
    </section>
    @endif

    {{-- إحصائيات المحتوى --}}
    <section>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">analytics</span>
            إحصائيات المحتوى
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('cp.news.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">newspaper</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['news'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">خبر منشور</p>
                @if($stats['news_total'] != $stats['news'])
                <p class="text-xs text-slate-400 mt-1">{{ $stats['news_total'] }} إجمالاً</p>
                @endif
            </a>
            <a href="{{ route('cp.scholarships.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">school</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['scholarships'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">منحة نشطة</p>
                @if($stats['scholarships_total'] != $stats['scholarships'])
                <p class="text-xs text-slate-400 mt-1">{{ $stats['scholarships_total'] }} إجمالاً</p>
                @endif
            </a>
            <a href="{{ route('cp.partners.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">handshake</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['partners'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">شريك نجاح</p>
            </a>
            <a href="{{ route('cp.success-stories.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">auto_stories</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['success_stories'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">قصة نجاح</p>
            </a>
            <a href="{{ route('cp.team-members.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary/10 text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">groups</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['team_members'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">عضو فريق</p>
            </a>
        </div>
    </section>

    {{-- الطلبات المعلقة --}}
    <section>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">inbox</span>
            الطلبات والنماذج
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('cp.scholarship-applications.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-amber-500/40 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl {{ $stats['scholarship_applications'] > 0 ? 'bg-amber-500/20 text-amber-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">description</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['scholarship_applications'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">طلب منح معلق</p>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['scholarship_applications_total'] }} إجمالاً</p>
            </a>
            <a href="{{ route('cp.volunteer-applications.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-amber-500/40 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl {{ $stats['volunteer_applications'] > 0 ? 'bg-amber-500/20 text-amber-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">volunteer_activism</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['volunteer_applications'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">طلب تطوع معلق</p>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['volunteer_applications_total'] }} إجمالاً</p>
            </a>
            <a href="{{ route('cp.tamkeen.partnership-requests.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-amber-500/40 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl {{ $stats['tamkeen_requests'] > 0 ? 'bg-amber-500/20 text-amber-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">handshake</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['tamkeen_requests'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">طلب شراكة تمكين</p>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['tamkeen_requests_total'] }} إجمالاً</p>
            </a>
            <a href="{{ route('cp.partnership-requests.index') }}" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-5 shadow-sm hover:shadow-md hover:border-amber-500/40 transition-all group">
                <div class="flex items-center gap-3 mb-2">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl {{ $stats['partnership_requests'] > 0 ? 'bg-amber-500/20 text-amber-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-400' }} group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-xl">group_add</span>
                    </span>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $stats['partnership_requests'] }}</span>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">طلب شراكة نجاح</p>
                <p class="text-xs text-slate-400 mt-1">{{ $stats['partnership_requests_total'] }} إجمالاً</p>
            </a>
        </div>
    </section>

    {{-- روابط سريعة وتقارير --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- آخر الأخبار --}}
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">newspaper</span>
                آخر الأخبار
            </h3>
            @if($recentNews->isEmpty())
            <p class="text-slate-500 dark:text-slate-400 text-sm">لا توجد أخبار.</p>
            @else
            <ul class="space-y-3">
                @foreach($recentNews as $item)
                <li>
                    <a href="{{ route('cp.news.edit', $item) }}" class="flex items-start gap-3 group hover:bg-slate-50 dark:hover:bg-slate-700/50 -mx-2 px-2 py-2 rounded-xl transition-colors">
                        <span class="text-slate-400 text-xs mt-0.5">{{ $item->published_at?->format('d/m/Y') ?? '—' }}</span>
                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-primary line-clamp-1">{{ localized($item, 'title') ?: $item->title_ar }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('cp.news.index') }}" class="mt-4 inline-flex items-center gap-1 text-primary font-medium text-sm hover:underline">
                عرض الكل
                <span class="material-symbols-outlined text-lg rtl:rotate-180">arrow_back</span>
            </a>
            @endif
        </div>
        {{-- آخر طلبات المنح --}}
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">description</span>
                آخر طلبات المنح
            </h3>
            @if($recentApplications->isEmpty())
            <p class="text-slate-500 dark:text-slate-400 text-sm">لا توجد طلبات.</p>
            @else
            <ul class="space-y-3">
                @foreach($recentApplications as $app)
                <li>
                    <a href="{{ route('cp.scholarship-applications.edit', $app) }}" class="flex items-start gap-3 group hover:bg-slate-50 dark:hover:bg-slate-700/50 -mx-2 px-2 py-2 rounded-xl transition-colors">
                        @php
                            $statusConfig = match($app->status) {
                                'approved' => ['class' => 'bg-emerald-500/20 text-emerald-700 dark:text-emerald-400', 'label' => 'مقبول'],
                                'rejected' => ['class' => 'bg-red-500/20 text-red-600 dark:text-red-400', 'label' => 'مرفوض'],
                                'under_review' => ['class' => 'bg-blue-500/20 text-blue-600 dark:text-blue-400', 'label' => 'قيد المراجعة'],
                                default => ['class' => 'bg-amber-500/20 text-amber-600 dark:text-amber-400', 'label' => 'معلق'],
                            };
                        @endphp
                        <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusConfig['class'] }}">{{ $statusConfig['label'] }}</span>
                        <div class="min-w-0">
                            <span class="text-slate-700 dark:text-slate-300 group-hover:text-primary block truncate">{{ $app->applicant_name }}</span>
                            <span class="text-xs text-slate-400">{{ $app->scholarship ? localized($app->scholarship, 'title') : '—' }} · {{ $app->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('cp.scholarship-applications.index') }}" class="mt-4 inline-flex items-center gap-1 text-primary font-medium text-sm hover:underline">
                عرض الكل
                <span class="material-symbols-outlined text-lg rtl:rotate-180">arrow_back</span>
            </a>
            @endif
        </div>
    </section>

    {{-- روابط سريعة للأقسام --}}
    <section>
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">link</span>
            روابط سريعة
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <a href="{{ route('cp.site-settings.edit') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">settings</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">إعدادات الموقع</span>
            </a>
            <a href="{{ route('cp.home.edit') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">home</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">الصفحة الرئيسية</span>
            </a>
            <a href="{{ route('cp.about.edit') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">info</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">من نحن</span>
            </a>
            <a href="{{ route('cp.kanani.edit') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">storefront</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">كنعاني</span>
            </a>
            <a href="{{ route('cp.tamkeen.partnerships.index') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">handshake</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">شراكات تمكين</span>
            </a>
            <a href="{{ route('cp.parasols.edit') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">filter_drama</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">المظلات</span>
            </a>
            <a href="{{ route('cp.scholarships.index') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">school</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">المنح الجامعية</span>
            </a>
            <a href="{{ route('cp.news.index') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">newspaper</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">الأخبار</span>
            </a>
            <a href="{{ route('cp.financial.index') }}" class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 hover:border-primary/30 hover:shadow-md transition-all flex items-center gap-3 group">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">account_balance</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">المالية والتبرعات</span>
            </a>
        </div>
    </section>
</div>
@endsection
