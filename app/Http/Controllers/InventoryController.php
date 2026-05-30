<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'variants'])->get();
        $categories = Category::all();
        return view('inventory', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'details' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.variant_name' => 'required|string|max:50',
            'variants.*.variant_unit' => 'required|string|max:20',
            'variants.*.sku' => 'required|string|max:100|unique:product_variants,sku',
            'variants.*.initial_stock' => 'required|integer|min:0',
            'variants.*.expired_date' => 'nullable|date',
            'variants.*.barcode' => 'required|string|max:100',
            'variants.*.cost_price' => 'required|numeric|min:0',
            'variants.*.selling_price' => 'required|numeric|min:0|gte:variants.*.cost_price',
            'variants.*.margin' => 'required|numeric|min:0',
            'variants.*.min_stock' => 'required|integer|min:0',
            'variants.*.enable_stock_alert' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $targetDir = public_path('uploads/products');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            // Bypass Symfony's is_writable() check which fails on Windows OneDrive folders
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
            if (copy($file->getRealPath(), $targetPath)) {
                $imagePath = url('uploads/products/' . $fileName);
            } else {
                throw new \Exception("Unable to write file to " . $targetPath);
            }
        }

        \DB::beginTransaction();
        try {
            // Create product parent
            $product = Product::create([
                'name' => $validatedData['name'],
                'details' => $validatedData['details'] ?? null,
                'category_id' => $validatedData['category_id'],
                'image_path' => $imagePath,
                'grade' => 'A',
                'status' => 'Healthy',
                'daily_sales' => 0,
                'monthly_revenue' => 0,
            ]);

            // Track flags to update parent status or grade
            $anyOut = false;
            $anyLow = false;

            // Create variants child entries
            foreach ($validatedData['variants'] as $variantData) {
                $actualStock = $variantData['initial_stock'];
                
                // Determine alert triggers
                $variantStatus = 'Healthy';
                if ($actualStock === 0) {
                    $variantStatus = 'Out Of Stock';
                    $anyOut = true;
                } elseif ($variantData['enable_stock_alert'] && $actualStock <= $variantData['min_stock']) {
                    $variantStatus = 'Running Low';
                    $anyLow = true;
                }

                ProductVariant::create([
                    'product_id' => $product->id,
                    'variant_name' => $variantData['variant_name'],
                    'variant_unit' => $variantData['variant_unit'],
                    'sku' => $variantData['sku'],
                    'initial_stock' => $variantData['initial_stock'],
                    'actual_stock' => $actualStock,
                    'expired_date' => $variantData['expired_date'] ?? null,
                    'barcode' => $variantData['barcode'],
                    'cost_price' => $variantData['cost_price'],
                    'selling_price' => $variantData['selling_price'],
                    'margin' => $variantData['margin'],
                    'min_stock' => $variantData['min_stock'],
                    'enable_stock_alert' => $variantData['enable_stock_alert'],
                ]);
            }

            // Summarize parent product health grade
            if ($anyOut) {
                $product->update(['status' => 'Out Of Stock', 'grade' => 'C']);
            } elseif ($anyLow) {
                $product->update(['status' => 'Running Low', 'grade' => 'B']);
            }

            \DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkSku(Request $request)
    {
        $sku = $request->query('sku');
        $barcode = $request->query('barcode');
        
        if ($sku) {
            $exists = \App\Models\ProductVariant::where('sku', $sku)->exists();
            return response()->json(['exists' => $exists]);
        }
        
        if ($barcode) {
            $exists = \App\Models\ProductVariant::where('barcode', $barcode)->exists();
            return response()->json(['exists' => $exists]);
        }
        
        return response()->json(['exists' => false]);
    }
}
