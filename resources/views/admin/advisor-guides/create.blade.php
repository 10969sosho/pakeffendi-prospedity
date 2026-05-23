@extends('admin.layouts.app')

@section('title', 'Create Advisor Guide Post')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-900">New Advisor Guide Post</h1>
        <a href="{{ route('admin.advisor-guides.index') }}" class="text-sm text-[#96A480] hover:underline">
            &larr; Back to list
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <form action="{{ route('admin.advisor-guides.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Judul Berita / Artikel
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring-[#96A480]"
                    placeholder="Contoh: Update Regulasi Investasi Properti di Bali"
                >
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                    Konten / Ringkasan
                </label>
                <textarea
                    id="content"
                    name="content"
                    rows="6"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring-[#96A480]"
                    placeholder="Tulis penjelasan singkat atau ringkasan berita di sini..."
                >{{ old('content') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">
                    Opsional, bisa diisi ringkasan berita atau catatan advisor.
                </p>
            </div>

            <div>
                <label for="reference_urls" class="block text-sm font-medium text-gray-700 mb-1">
                    Link URL Referensi Berita (Multiple)
                </label>
                <textarea
                    id="reference_urls"
                    name="reference_urls"
                    rows="4"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring-[#96A480]"
                    placeholder="https://contoh-media.com/artikel-berita-1&#10;https://contoh-media.com/artikel-berita-2"
                >{{ old('reference_urls', old('reference_url')) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">
                    Opsional, satu link per baris (atau pisahkan pakai koma).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Publish
                    </label>
                    <input
                        type="datetime-local"
                        id="published_at"
                        name="published_at"
                        value="{{ old('published_at') }}"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring-[#96A480]"
                    >
                    <p class="mt-1 text-xs text-gray-500">
                        Jika dikosongkan, bisa diisi nanti saat edit.
                    </p>
                </div>

                <div class="flex items-center md:items-end">
                    <label class="inline-flex items-center mt-6">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="rounded text-[#96A480] border-gray-300 focus:ring-[#96A480]"
                            {{ old('is_active', '1') ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">Active (tampil di halaman publik)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-md shadow-sm transition-colors"
                >
                    Simpan Postingan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

