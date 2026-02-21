@extends('cp.layout')

@section('title', 'بطاقات المشاريع - الصفحة الرئيسية')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">بطاقات المشاريع في الصفحة الرئيسية</h2>
        <a href="{{ route('cp.home-projects.create') }}" class="cp-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors">
            <span class="material-symbols-outlined text-xl">add</span>
            إضافة مشروع
        </a>
    </div>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        @if($projects->isEmpty())
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block">work</span>
                لا توجد مشاريع. <a href="{{ route('cp.home-projects.create') }}" class="text-primary hover:underline">إضافة مشروع</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الصورة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">العنوان</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الرابط</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الترتيب</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">الحالة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 w-32">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($projects as $p)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    @if($p->image_path)
                                        <img src="{{ asset('storage/' . $p->image_path) }}" alt="" class="w-16 h-12 object-cover rounded-lg">
                                    @else
                                        <span class="text-slate-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white">{{ $p->title_ar }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $p->link_type === 'route' ? $p->link_value : Str::limit($p->link_value, 30) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ $p->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $p->is_active ? 'bg-primary/20 text-primary' : 'bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-400' }}">
                                        {{ $p->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('cp.home-projects.edit', $p) }}" class="p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300" title="تعديل">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        <form action="{{ route('cp.home-projects.destroy', $p) }}" method="post" class="inline" onsubmit="return confirm('حذف هذا المشروع؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400" title="حذف">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <p class="text-sm text-slate-500 dark:text-slate-400">هذه البطاقات تظهر في قسم «مشاريعنا» بالصفحة الرئيسية. الترتيب يُحدد حسب حقل «الترتيب» ثم المعرف.</p>
</div>
@endsection
