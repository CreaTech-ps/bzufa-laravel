@extends('cp.layout')

@section('title', 'مشتركو النشرة الإخبارية')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-800 dark:text-white">مشتركو النشرة الإخبارية</h2>
        <a href="{{ route('cp.newsletter.broadcast') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium text-sm">
            <span class="material-symbols-outlined text-lg">campaign</span>
            إرسال رسالة جماعية
        </a>
    </div>

    <form action="{{ route('cp.newsletter.index') }}" method="get" class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-[200px] flex-1">
                <label for="q" class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">بحث بالبريد</label>
                <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="البريد الإلكتروني..." class="cp-input w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/30">
            </div>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-500 transition-colors">تصفية</button>
        </div>
    </form>

    <div class="rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        @if($subscribers->isEmpty())
            <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-4xl mb-2 block">mail</span>
                لا يوجد مشتركون حتى الآن.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">البريد</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">اللغة</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300">التاريخ</th>
                            <th class="px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 w-24">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($subscribers as $sub)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-300">{{ $sub->email }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $sub->locale === 'en' ? 'English' : 'العربية' }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $sub->subscribed_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('cp.newsletter.destroy', $sub) }}" method="post" class="inline" onsubmit="return confirm('إلغاء اشتراك هذا البريد؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400" title="إلغاء الاشتراك">
                                            <span class="material-symbols-outlined text-lg">person_remove</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($subscribers->hasPages())
                <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">{{ $subscribers->links() }}</div>
            @endif
        @endif
    </div>
</div>
@endsection
