@extends('website.layout')
@section('title', 'بوابة التقديم: ' . $scholarship->title_ar)

@section('content')
<main class="max-w-6xl mx-auto px-6 lg:px-8 py-12">
    <section class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-4">
                <a class="hover:underline" href="{{ route('home') }}">الرئيسية</a>
                <span class="material-symbols-outlined text-xs">chevron_left</span>
                <a class="hover:underline" href="{{ route('grants.index') }}">المنح الدراسية</a>
                <span class="material-symbols-outlined text-xs">chevron_left</span>
                <a class="hover:underline" href="{{ route('grants.show', $scholarship->slug_ar ?: $scholarship->id) }}">{{ $scholarship->title_ar }}</a>
                <span class="material-symbols-outlined text-xs">chevron_left</span>
                <span class="text-primary">بوابة التقديم</span>
            </nav>
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">طلب تقديم نشط</span>
            </div>
            <h1 class="text-4xl font-bold dark:text-white">بوابة التقديم: {{ $scholarship->title_ar }}</h1>
            <p class="mt-4 text-gray-600 dark:text-gray-400 max-w-2xl leading-relaxed">
                يرجى اتباع الخطوات الأربع التالية لضمان اكتمال طلبك. نظامنا الرقمي يسهل عليك عملية رفع الوثائق وتتبع حالة طلبك في أي وقت.
            </p>
        </div>
        @if($scholarship->application_end_date)
        <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 p-5 rounded-xl flex items-center gap-4 min-w-[240px]">
            <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                <span class="material-symbols-outlined">history_toggle_off</span>
            </div>
            <div>
                <p class="text-xs text-red-600/80 font-medium">الموعد النهائي</p>
                <p class="text-xl font-bold text-red-600">{{ $scholarship->application_end_date->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        @endif
    </section>
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-4 flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-600 text-2xl">check_circle</span>
        <p class="text-emerald-800 dark:text-emerald-200 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex items-center gap-3">
        <span class="material-symbols-outlined text-red-600 text-2xl">error</span>
        <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
    </div>
    @endif
    <form action="{{ route('grants.apply.store', $scholarship->slug_ar ?: $scholarship->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        <div class="lg:col-span-8 space-y-8">
            <section class="bg-white dark:bg-card-dark border border-gray-200 dark:border-white/10 rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-1 h-full bg-primary"></div>
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-primary/10 text-primary px-3 py-1 rounded-md text-xs font-bold whitespace-nowrap">خطوة 1</div>
                        <div>
                            <h3 class="text-xl font-bold mb-1">نموذج الطلب الرسمي</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">تحميل المستند الأساسي للمنحة (PDF) للبدء في الإجراءات.</p>
                        </div>
                    </div>
                    @if($scholarship->application_form_pdf_path)
                    <a href="{{ asset('storage/' . $scholarship->application_form_pdf_path) }}" target="_blank" rel="noopener"
                        class="w-full md:w-auto flex items-center justify-center gap-2 border-2 border-primary text-primary hover:bg-primary hover:text-white transition-all px-8 py-3 rounded-lg font-bold">
                        <span class="material-symbols-outlined">download</span>
                        تحميل نموذج المنحة PDF
                    </a>
                    @endif
                </div>
            </section>
            <section class="bg-white dark:bg-card-dark border border-gray-200 dark:border-white/10 rounded-2xl p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-md text-xs font-bold">خطوة 2</span>
                    <h3 class="text-xl font-bold">رفع النموذج المعبأ</h3>
                </div>
                <input type="file" name="filled_form" id="filled_form" required accept=".pdf,.jpg,.jpeg,.png"
                    class="hidden" />
                <label for="filled_form" class="block border-2 border-dashed border-gray-200 dark:border-white/10 rounded-xl p-12 flex flex-col items-center justify-center text-center group hover:border-primary transition-colors cursor-pointer" id="drop-zone">
                    <div class="w-16 h-16 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-primary">cloud_upload</span>
                    </div>
                    <p class="text-lg font-medium mb-1">اسحب نموذج المنحة الموقع هنا</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">أو <span class="text-primary font-bold">تصفح ملفاتك</span> (الحد الأقصى 10MB - PDF, JPG, PNG)</p>
                    <p id="file-name" class="text-sm text-primary font-bold mt-2 hidden"></p>
                </label>
                @error('filled_form')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </section>
            <section class="bg-white dark:bg-card-dark border border-gray-200 dark:border-white/10 rounded-2xl p-8">
                <div class="flex items-center gap-3 mb-8">
                    <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-md text-xs font-bold">خطوة 3</span>
                    <h3 class="text-xl font-bold">البيانات والوثائق الإضافية</h3>
                </div>
                <div class="space-y-8">
                    <div class="space-y-2 max-w-md">
                        <label for="applicant_name" class="text-sm font-medium text-gray-600 dark:text-gray-400 block">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input name="applicant_name" id="applicant_name" value="{{ old('applicant_name') }}" required
                            class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none @error('applicant_name') border-red-500 @enderror" placeholder="أدخل اسمك الكامل" type="text" />
                        @error('applicant_name')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="space-y-2 max-w-md">
                        <label for="applicant_id_number" class="text-sm font-medium text-gray-600 dark:text-gray-400 block">رقم الهوية الوطنية / الإقامة <span class="text-red-500">*</span></label>
                        <input name="applicant_id_number" id="applicant_id_number" value="{{ old('applicant_id_number') }}" required
                            class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/10 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent outline-none @error('applicant_id_number') border-red-500 @enderror" placeholder="000000000" type="text" />
                        @error('applicant_id_number')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>
            <section class="bg-white dark:bg-card-dark border border-gray-200 dark:border-white/10 rounded-2xl p-8">
                <div class="flex items-center gap-3 mb-8">
                    <span class="bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 px-3 py-1 rounded-md text-xs font-bold">خطوة 4</span>
                    <h3 class="text-xl font-bold">تأكيد وإرسال الطلب</h3>
                </div>
                <div class="bg-gray-50 dark:bg-background-dark border border-gray-100 dark:border-white/10 p-6 rounded-xl mb-8">
                    <label class="flex items-start gap-4 cursor-pointer">
                        <input name="consent" id="consent" value="1" {{ old('consent') ? 'checked' : '' }} required
                            class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary @error('consent') border-red-500 @enderror" type="checkbox" />
                        <span class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            أقر بأن جميع المعلومات والبيانات الواردة أعلاه وفي المرفقات صحيحة تماماً، وأتحمل المسؤولية القانونية عن أي بيانات غير دقيقة، كما أوافق على شروط سياسة الخصوصية الخاصة بمؤسسة الجمعية.
                        </span>
                    </label>
                    @error('consent')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-3 hover:shadow-lg hover:shadow-primary/20 transition-all">
                    إرسال الطلب النهائي
                    <span class="material-symbols-outlined">send</span>
                </button>
                <div class="mt-8 flex items-center justify-center gap-6 text-gray-400">
                    <div class="flex items-center gap-2 text-xs">
                        <span class="material-symbols-outlined text-sm text-primary">verified_user</span>
                        تشفير SSL آمن
                    </div>
                    <div class="w-px h-4 bg-gray-200 dark:bg-white/10"></div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="material-symbols-outlined text-sm text-primary">verified</span>
                        معتمد رسمياً
                    </div>
                </div>
            </section>
        </div>
        <aside class="lg:col-span-4 space-y-8">
            <div class="bg-white dark:bg-card-dark border border-gray-200 dark:border-white/10 rounded-2xl p-8 sticky top-24">
                <div class="flex items-center gap-2 mb-8">
                    <span class="material-symbols-outlined text-primary">fact_check</span>
                    <h3 class="font-bold text-lg">دليل خطوات التقديم</h3>
                </div>
                <div class="relative timeline-line space-y-10">
                    <div class="flex gap-4 step-node">
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div>
                            <h4 class="font-bold text-primary">تحميل وتعبئة النموذج</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">ابدأ بتحميل ملف الـ PDF الرسمي للمنحة وقم بتعبئة كافة الحقول المطلوبة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 step-node opacity-60">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-white/10 text-gray-600 dark:text-gray-400 flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div>
                            <h4 class="font-bold">رفع النموذج المعبأ</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">بعد التوقيع والتأكد من البيانات، أعد رفع النموذج بصيغة رقمية واضحة.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 step-node opacity-60">
                        <div class="w-10 h-10 rounded-full bg-primary/20 text-primary flex items-center justify-center font-bold flex-shrink-0 border border-primary/30">3</div>
                        <div>
                            <h4 class="font-bold">إرفاق الوثائق والهوية</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">أدخل رقم هويتك الوطنية وارفع الوثائق الداعمة والمرفقات المطلوبة في قسم واحد.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 step-node opacity-60">
                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-white/10 text-gray-600 dark:text-gray-400 flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div>
                            <h4 class="font-bold">إرسال الطلب</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">المراجعة النهائية والضغط على زر الإرسال للحصول على رقم طلبك.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-12 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 p-5 rounded-xl flex gap-3">
                    <span class="material-symbols-outlined text-amber-600">info</span>
                    <div>
                        <h5 class="text-sm font-bold text-amber-800 dark:text-amber-400 mb-1">ملاحظة هامة</h5>
                        <p class="text-xs text-amber-700/80 dark:text-amber-400/80 leading-relaxed">يرجى التأكد من أن جميع الوثائق المرفوعة واضحة وبصيغة PDF أو JPG لضمان سرعة معالجة طلبك قبل لجنة الفرز.</p>
                    </div>
                </div>
            </div>
        </aside>
    </form>
    </section>
</main>
@endsection

@section('scripts')
<script>
document.getElementById('filled_form')?.addEventListener('change', function() {
    const fileName = document.getElementById('file-name');
    if (this.files?.length) {
        fileName.textContent = 'تم اختيار: ' + this.files[0].name;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
});
var dropZone = document.getElementById('drop-zone');
if (dropZone) {
    ['dragenter', 'dragover'].forEach(function(e) { dropZone.addEventListener(e, function(ev) { ev.preventDefault(); dropZone.classList.add('border-primary', 'bg-primary/5'); }); });
    ['dragleave', 'drop'].forEach(function(e) { dropZone.addEventListener(e, function(ev) { ev.preventDefault(); dropZone.classList.remove('border-primary', 'bg-primary/5'); }); });
    dropZone.addEventListener('drop', function(e) {
        var input = document.getElementById('filled_form');
        if (input && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; input.dispatchEvent(new Event('change')); }
    });
}
</script>
@endsection
