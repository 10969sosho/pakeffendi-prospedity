<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Tag;
use App\Models\PicProfile;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get all admin users for filter dropdown
        $adminUsers = \App\Models\User::whereIn('role', ['admin', 'superadmin'])->orderBy('name')->get();
        
        // Query properties - remove default AVAILABLE filter to allow all statuses when filtering
        $query = Property::with('admin');
        
        // Filter by property number
        if ($request->filled('property_number')) {
            $query->where('property_number', 'like', '%' . $request->property_number . '%');
        }

        // Filter by transaction number
        if ($request->filled('transaction_number')) {
            $query->where('transaction_number', 'like', '%' . $request->transaction_number . '%');
        }
        
        // Filter by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        
        // Filter by property status
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        }
        
        // Filter by location
        if ($request->filled('location')) {
            $query->where('location_text', 'like', '%' . $request->location . '%');
        }
        
        // Filter by admin user
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }
        
        // Filter by views (minimum)
        if ($request->filled('views_min')) {
            $query->where('views', '>=', $request->views_min);
        }
        
        // Filter by views (maximum)
        if ($request->filled('views_max')) {
            $query->where('views', '<=', $request->views_max);
        }
        
        // Filter by created date
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }
        
        // Get all property types for filter
        $propertyTypes = PropertyType::orderBy('name')->get();

        $properties = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.properties.index', compact('properties', 'adminUsers', 'propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        $picProfiles = PicProfile::all();
        $propertyTypes = PropertyType::all();
        return view('admin.properties.create', compact('tags', 'picProfiles', 'propertyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Starting property creation', [
                'user_id' => Auth::id(),
                'input' => $request->except(['photos', 'password', 'password_confirmation'])
            ]);

            $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'property_type_id' => 'required|exists:property_types,id',
            'property_status' => 'nullable|string|max:255|in:DRAFT,AVAILABLE,SOLD,RENTED,EXPIRED',
            'transaction_number' => 'required|string|max:255',
            'validity_days' => 'required|integer|min:1',
            'pic_ref_number' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_email' => 'nullable|email|max:255',
            'pic_whatsapp_number' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'price_freehold' => 'nullable|numeric|min:0',
            'price_leasehold' => 'nullable|numeric|min:0',
            'leasehold_period' => 'nullable|integer|min:0',
            'location_text' => 'required|string|max:500',
            'area' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'land_size' => 'nullable|numeric|min:0',
            'building_size' => 'nullable|numeric|min:0',
            'dimension' => 'nullable|string|max:255',
            'direction' => 'nullable|string|max:255',
            'year_of_build' => 'nullable|integer|min:1800|max:' . date('Y'),
            'floor_level' => 'nullable|integer|min:0',
            'view' => 'nullable|string|max:255',
            'style_design' => 'nullable|string|max:255',
            'surrounding' => 'nullable|string',
            'imb' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255|in:GREEN,YELLOW,PINK,RED',
            'living_room_type' => 'nullable|string|max:255|in:Open,Closed,Open-Closed',
            'dining_room_type' => 'nullable|string|max:255|in:Open,Closed,Open-Closed',
            'kitchen_type' => 'nullable|string|max:255|in:Open,Closed,Open-Closed',
            'bedroom' => 'nullable|integer|min:0',
            'bathroom' => 'nullable|integer|min:0',
            'ensuite_bathroom' => 'nullable|integer|min:0',
            'extra_room' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'swimming_pool' => 'boolean',
            'terrace' => 'boolean',
            'balcony' => 'boolean',
            'shower' => 'boolean',
            'furniture' => 'nullable|string|max:255|in:Fully Furnished,Semi Furnished,Non Furnished',
            'electricity_power' => 'nullable|string|max:255',
            'ac_count' => 'nullable|integer|min:0',
            'water_source' => 'nullable|string|max:255',
            'internet' => 'nullable|string|max:255',
            'parking_type' => 'nullable|string|max:255',
            'parking_size' => 'nullable|string|max:255',
            'monthly_cost_included' => 'nullable|string',
            'show_monthly_cost' => 'boolean',
            'banjar_security' => 'boolean',
            'cleaning_service' => 'boolean',
            'pool_maintenance' => 'boolean',
            'garden_maintenance' => 'boolean',
            'bin_collection' => 'boolean',
            'electricity_included' => 'boolean',
            'internet_included' => 'boolean',
            'is_featured' => 'boolean',
            'advisor_notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cover_photo_index' => 'nullable|integer|min:0',
        ]);

        // Calculate expired_date from validity_days
        if (isset($validated['validity_days'])) {
            $validated['expired_date'] = now()->addDays((int)$validated['validity_days']);
            unset($validated['validity_days']); // Not a DB column
        }

        // Calculate expired_date from validity_days
        if (isset($validated['validity_days'])) {
            $validated['expired_date'] = now()->addDays((int)$validated['validity_days']);
            unset($validated['validity_days']); // Not a DB column
        }

        // Populate legacy property_type from relation
        if (isset($validated['property_type_id'])) {
            $type = PropertyType::find($validated['property_type_id']);
            $validated['property_type'] = $type->slug;
        }

        // Auto-set has_monthly and has_yearly based on prices
        if (!isset($validated['has_monthly'])) {
            $validated['has_monthly'] = !empty($validated['price_monthly']) && $validated['price_monthly'] > 0;
        }
        if (!isset($validated['has_yearly'])) {
            $validated['has_yearly'] = !empty($validated['price_yearly']) && $validated['price_yearly'] > 0;
        }

        // Set price field - use price_freehold, price_leasehold, price_monthly, or price_yearly as fallback
        // Priority: price_freehold > price_leasehold > price_monthly > price_yearly > 0
        if (!isset($validated['price']) || empty($validated['price'])) {
            if (!empty($validated['price_freehold']) && $validated['price_freehold'] > 0) {
                $validated['price'] = $validated['price_freehold'];
            } elseif (!empty($validated['price_leasehold']) && $validated['price_leasehold'] > 0) {
                $validated['price'] = $validated['price_leasehold'];
            } elseif (!empty($validated['price_monthly']) && $validated['price_monthly'] > 0) {
                $validated['price'] = $validated['price_monthly'];
            } elseif (!empty($validated['price_yearly']) && $validated['price_yearly'] > 0) {
                $validated['price'] = $validated['price_yearly'];
            } else {
                $validated['price'] = 0;
            }
        }

        // Ensure boolean fields are set (checkboxes don't send false values)
        $booleanFields = [
            'swimming_pool', 'terrace', 'balcony', 'shower',
            'show_monthly_cost',
            'banjar_security', 'cleaning_service', 'pool_maintenance',
            'garden_maintenance', 'bin_collection', 'electricity_included', 'internet_included', 'is_featured'
        ];
        foreach ($booleanFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = false;
            }
        }

        // Set admin_id
        $validated['admin_id'] = Auth::id();

        $property = Property::create($validated);

        if (isset($validated['tags'])) {
            $property->tags()->sync($validated['tags']);
        }

        // Log activity
        ActivityLog::log('create', 'Property', $property->id, "Created property: {$property->title}");

        if ($request->hasFile('photos')) {
            $coverIndex = $request->filled('cover_photo_index') ? (int) $request->input('cover_photo_index') : 0;
            $currentIndex = 0;

            foreach ($request->file('photos') as $photo) {
                $media = $property->addMedia($photo)
                    ->usingName($property->title)
                    ->toMediaCollection('photos', 'public');

                if ($currentIndex === $coverIndex) {
                    $media->setCustomProperty('is_cover', true);
                    $media->save();
                }

                $currentIndex++;
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Property validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['photos'])
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error creating property', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['photos'])
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create property: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::findOrFail($id);
        return view('admin.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::findOrFail($id);
        $tags = Tag::all();
        $picProfiles = PicProfile::all();
        $propertyTypes = PropertyType::all();

        // Ensure existing properties always have a property_number
        if (empty($property->property_number)) {
            $property->property_number = Property::generatePropertyNumber();
            $property->save();
        }

        return view('admin.properties.edit', compact('property', 'tags', 'picProfiles', 'propertyTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'property_type_id' => 'required|exists:property_types,id',
            'property_status' => 'nullable|string|max:255|in:DRAFT,AVAILABLE,SOLD,RENTED,EXPIRED',
            'transaction_number' => 'nullable|string|max:255',
            'validity_days' => 'nullable|integer|min:1',
            'pic_ref_number' => 'nullable|string|max:255',
            'pic_name' => 'nullable|string|max:255',
            'pic_email' => 'nullable|email|max:255',
            'pic_whatsapp_number' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'price_freehold' => 'nullable|numeric|min:0',
            'price_leasehold' => 'nullable|numeric|min:0',
            'leasehold_period' => 'nullable|integer|min:0',
            'location_text' => 'required|string|max:500',
            'area' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'land_size' => 'nullable|numeric|min:0',
            'building_size' => 'nullable|numeric|min:0',
            'dimension' => 'nullable|string|max:255',
            'direction' => 'nullable|string|max:255',
            'year_of_build' => 'nullable|integer|min:1800|max:' . date('Y'),
            'floor_level' => 'nullable|integer|min:0',
            'view' => 'nullable|string|max:255',
            'style_design' => 'nullable|string|max:255',
            'surrounding' => 'nullable|string',
            'imb' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255|in:GREEN,YELLOW,PINK,RED',
            'living_room_type' => 'nullable|string|max:255',
            'dining_room_type' => 'nullable|string|max:255',
            'kitchen_type' => 'nullable|string|max:255',
            'bedroom' => 'nullable|integer|min:0',
            'bathroom' => 'nullable|integer|min:0',
            'ensuite_bathroom' => 'nullable|integer|min:0',
            'extra_room' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'swimming_pool' => 'boolean',
            'terrace' => 'boolean',
            'balcony' => 'boolean',
            'shower' => 'boolean',
            'furniture' => 'nullable|string|max:255',
            'electricity_power' => 'nullable|string|max:255',
            'ac_count' => 'nullable|integer|min:0',
            'water_source' => 'nullable|string|max:255',
            'internet' => 'nullable|string|max:255',
            'parking_type' => 'nullable|string|max:255',
            'parking_size' => 'nullable|string|max:255',
            'monthly_cost_included' => 'nullable|string',
            'show_monthly_cost' => 'boolean',
            'banjar_security' => 'boolean',
            'cleaning_service' => 'boolean',
            'pool_maintenance' => 'boolean',
            'garden_maintenance' => 'boolean',
            'bin_collection' => 'boolean',
            'electricity_included' => 'boolean',
            'internet_included' => 'boolean',
            'advisor_notes' => 'nullable|string',
            'is_featured' => 'boolean',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'cover_photo_index' => 'nullable|integer|min:0',
        ]);

        // Calculate expired_date from validity_days
        if (isset($validated['validity_days'])) {
            $validated['expired_date'] = now()->addDays((int)$validated['validity_days']);
            unset($validated['validity_days']); // Not a DB column
        }

        // Populate legacy property_type from relation
        if (isset($validated['property_type_id'])) {
            $type = PropertyType::find($validated['property_type_id']);
            $validated['property_type'] = $type->slug;
        }

        // Auto-set has_monthly and has_yearly based on prices
        if (!isset($validated['has_monthly'])) {
            $validated['has_monthly'] = !empty($validated['price_monthly']) && $validated['price_monthly'] > 0;
        }
        if (!isset($validated['has_yearly'])) {
            $validated['has_yearly'] = !empty($validated['price_yearly']) && $validated['price_yearly'] > 0;
        }

        // Set price field - use price_freehold, price_leasehold, price_monthly, or price_yearly as fallback
        // Priority: price_freehold > price_leasehold > price_monthly > price_yearly > existing price > 0
        if (!isset($validated['price']) || empty($validated['price'])) {
            if (!empty($validated['price_freehold']) && $validated['price_freehold'] > 0) {
                $validated['price'] = $validated['price_freehold'];
            } elseif (!empty($validated['price_leasehold']) && $validated['price_leasehold'] > 0) {
                $validated['price'] = $validated['price_leasehold'];
            } elseif (!empty($validated['price_monthly']) && $validated['price_monthly'] > 0) {
                $validated['price'] = $validated['price_monthly'];
            } elseif (!empty($validated['price_yearly']) && $validated['price_yearly'] > 0) {
                $validated['price'] = $validated['price_yearly'];
            } elseif (!empty($property->price)) {
                $validated['price'] = $property->price;
            } else {
                $validated['price'] = 0;
            }
        }

        // Ensure boolean fields are set (checkboxes don't send false values)
        $booleanFields = [
            'swimming_pool', 'terrace', 'balcony', 'shower',
            'show_monthly_cost',
            'banjar_security', 'cleaning_service', 'pool_maintenance',
            'garden_maintenance', 'bin_collection', 'electricity_included', 'internet_included', 'is_featured'
        ];
        foreach ($booleanFields as $field) {
            if (!isset($validated[$field])) {
                $validated[$field] = false;
            }
        }

        // Store old values for logging
        $oldValues = $property->getOriginal();
        $newValues = $validated;

        $property->update($validated);

        // Sync tags
        $property->tags()->sync($request->input('tags', []));

        // Log activity
        ActivityLog::log('update', 'Property', $property->id, "Updated property: {$property->title}", [
            'old' => $oldValues,
            'new' => $newValues
        ]);

        if ($request->hasFile('photos')) {
            $coverIndex = $request->filled('cover_photo_index') ? (int) $request->input('cover_photo_index') : null;
            $currentIndex = 0;
            $newCoverMedia = null;

            foreach ($request->file('photos') as $photo) {
                $media = $property->addMedia($photo)
                    ->usingName($property->title)
                    ->toMediaCollection('photos', 'public');

                if ($coverIndex !== null && $currentIndex === $coverIndex) {
                    $newCoverMedia = $media;
                }

                $currentIndex++;
            }

            if ($newCoverMedia) {
                foreach ($property->getMedia('photos') as $photo) {
                    $photo->setCustomProperty('is_cover', $photo->id === $newCoverMedia->id);
                    $photo->save();
                }
            }
        }

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);
        $propertyTitle = $property->title;
        
        $property->clearMediaCollection('photos');
        $property->delete();

        // Log activity
        ActivityLog::log('delete', 'Property', $id, "Deleted property: {$propertyTitle}");

        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    public function deletePhoto(Request $request, string $id)
    {
        $property = Property::findOrFail($id);
        $media = $property->getMedia('photos')->where('id', $request->photo_id)->first();
        
        if ($media) {
            $media->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function setCoverPhoto(Request $request, string $id)
    {
        $property = Property::findOrFail($id);
        $media = $property->getMedia('photos')->where('id', $request->photo_id)->first();

        if (!$media) {
            return response()->json(['success' => false], 404);
        }

        foreach ($property->getMedia('photos') as $photo) {
            $photo->setCustomProperty('is_cover', $photo->id === $media->id);
            $photo->save();
        }

        return response()->json(['success' => true, 'photo_id' => $media->id]);
    }

    /**
     * Display successful properties (SOLD and RENTED)
     */
    public function successfulProperties(Request $request)
    {
        // Get all admin users for filter dropdown
        $adminUsers = \App\Models\User::whereIn('role', ['admin', 'superadmin'])->orderBy('name')->get();
        
        $query = Property::with('admin');

        // Filter by property status - show SOLD or RENTED, or both if not specified
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        } else {
            // Only show SOLD or RENTED properties if no specific status filter
            $query->whereIn('property_status', ['SOLD', 'RENTED']);
        }

        // Filter by property number
        if ($request->filled('property_number')) {
            $query->where('property_number', 'like', '%' . $request->property_number . '%');
        }

        // Filter by PIC REF NUMBER
        if ($request->filled('pic_ref_number')) {
            $query->where('pic_ref_number', 'like', '%' . $request->pic_ref_number . '%');
        }

        // Filter by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location_text', 'like', '%' . $request->location . '%');
        }

        // Filter by admin user
        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        // Filter by views (minimum)
        if ($request->filled('views_min')) {
            $query->where('views', '>=', $request->views_min);
        }

        // Filter by views (maximum)
        if ($request->filled('views_max')) {
            $query->where('views', '<=', $request->views_max);
        }

        // Filter by created date
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        $properties = $query->latest()->paginate(15)->withQueryString();
        return view('admin.properties.successful', compact('properties', 'adminUsers'));
    }

    /**
     * Display a listing of transactions.
     */
    public function transactionIndex(Request $request)
    {
        $query = Property::selectRaw('transaction_number, MAX(expired_date) as expired_date, COUNT(*) as property_count')
             ->whereNotNull('transaction_number')
             ->groupBy('transaction_number');
             
        if ($request->filled('search')) {
            $query->where('transaction_number', 'like', '%' . $request->search . '%');
        }
        
        $transactions = $query->orderBy('expired_date', 'asc')->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Extend validity for a transaction.
     */
    public function extendTransactionValidity(Request $request)
    {
        $request->validate([
            'transaction_number' => 'required|string',
            'validity_days' => 'required|integer|min:1',
        ]);

        $newExpiry = now()->addDays((int) $request->validity_days);

        Property::where('transaction_number', $request->transaction_number)
            ->update(['expired_date' => $newExpiry]);

        return redirect()->back()->with('success', "Validity extended for transaction {$request->transaction_number}");
    }
}
