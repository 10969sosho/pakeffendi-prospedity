<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvisorGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvisorGuideController extends Controller
{
    /**
     * Display a listing of the advisor guides.
     */
    public function index()
    {
        $guides = AdvisorGuide::orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.advisor-guides.index', compact('guides'));
    }

    /**
     * Show the form for creating a new advisor guide.
     */
    public function create()
    {
        return view('admin.advisor-guides.create');
    }

    /**
     * Store a newly created advisor guide in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'reference_url' => ['nullable', 'url', 'max:2048'],
            'reference_urls' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $referenceUrls = [];
        $referenceUrlsRaw = $request->input('reference_urls');
        if (is_string($referenceUrlsRaw) && trim($referenceUrlsRaw) !== '') {
            $referenceUrls = collect(preg_split("/\r\n|\r|\n|,/", $referenceUrlsRaw))
                ->map(fn ($url) => trim((string) $url))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        if (empty($referenceUrls) && $request->filled('reference_url')) {
            $referenceUrls = [$request->input('reference_url')];
        }

        Validator::make(
            ['reference_urls' => $referenceUrls],
            ['reference_urls.*' => ['url', 'max:2048']]
        )->validate();

        $data['reference_urls'] = $referenceUrls ?: null;
        $data['reference_url'] = $referenceUrls[0] ?? ($data['reference_url'] ?? null);

        AdvisorGuide::create($data);

        return redirect()
            ->route('admin.advisor-guides.index')
            ->with('success', 'Advisor guide post created successfully.');
    }

    /**
     * Show the form for editing the specified advisor guide.
     */
    public function edit(AdvisorGuide $advisorGuide)
    {
        return view('admin.advisor-guides.edit', compact('advisorGuide'));
    }

    /**
     * Update the specified advisor guide in storage.
     */
    public function update(Request $request, AdvisorGuide $advisorGuide)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'reference_url' => ['nullable', 'url', 'max:2048'],
            'reference_urls' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $referenceUrls = [];
        $referenceUrlsRaw = $request->input('reference_urls');
        if (is_string($referenceUrlsRaw) && trim($referenceUrlsRaw) !== '') {
            $referenceUrls = collect(preg_split("/\r\n|\r|\n|,/", $referenceUrlsRaw))
                ->map(fn ($url) => trim((string) $url))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        if (empty($referenceUrls) && $request->filled('reference_url')) {
            $referenceUrls = [$request->input('reference_url')];
        }

        Validator::make(
            ['reference_urls' => $referenceUrls],
            ['reference_urls.*' => ['url', 'max:2048']]
        )->validate();

        $data['reference_urls'] = $referenceUrls ?: null;
        $data['reference_url'] = $referenceUrls[0] ?? ($data['reference_url'] ?? null);

        $advisorGuide->update($data);

        return redirect()
            ->route('admin.advisor-guides.index')
            ->with('success', 'Advisor guide post updated successfully.');
    }

    /**
     * Remove the specified advisor guide from storage.
     */
    public function destroy(AdvisorGuide $advisorGuide)
    {
        $advisorGuide->delete();

        return redirect()
            ->route('admin.advisor-guides.index')
            ->with('success', 'Advisor guide post deleted successfully.');
    }
}
