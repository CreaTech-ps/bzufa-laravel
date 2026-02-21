@extends('cp.layout')

@section('title', 'تعديل مشروع')

@section('content')
<div class="w-full max-w-4xl space-y-6">
    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('cp.home-projects.index') }}" class="hover:text-primary">بطاقات المشاريع</a>
        <span class="material-symbols-outlined text-lg">chevron_left</span>
        <span>تعديل: {{ $home_project->title_ar }}</span>
    </div>

    <form action="{{ route('cp.home-projects.update', $home_project) }}" method="post" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('cp.home-projects._form', ['project' => $home_project])
        <div class="flex justify-end gap-2">
            <a href="{{ route('cp.home-projects.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">إلغاء</a>
            <button type="submit" class="cp-btn px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-dark text-white font-medium shadow-sm transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">save</span>
                حفظ التعديلات
            </button>
        </div>
    </form>
</div>
@endsection
