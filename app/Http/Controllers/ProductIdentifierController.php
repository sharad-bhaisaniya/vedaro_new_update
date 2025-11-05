<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductIdentifier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
    use SimpleSoftwareIO\QrCode\Facades\QrCode; // <--- Add this line




class ProductIdentifierController extends Controller
{
    /**
     * Display a list of products with their identifier mapping status.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all products and count the number of associated identifiers for each.
        $products = Product::withCount('identifiers')->get();

        return view('admin.manage_qr_mapping', compact('products'));
    }

    /**
     * Show the mapping interface for a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showMappingPage($id)
    {
        $product = Product::findOrFail($id);
        $totalQuantity = $product->total_stock;
        $mappedCount = $product->identifiers()->count();

        return view('admin.map_product_qr', compact('product', 'totalQuantity', 'mappedCount'));
    }

    /**
     * Store a new QR code and/or RFID identifier for a product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    // In your controller
        public function storeIdentifier(Request $request, $id)
        {
            $request->validate([
                'qr_code' => 'required|string',
            ]);

            $product = Product::findOrFail($id);
            $scannedQr = $request->qr_code;
            
            // Check if this QR code already exists for this product
            $existingIdentifier = ProductIdentifier::where('qr_code', $scannedQr)
                ->where('product_id', $product->id)
                ->first();

            if ($existingIdentifier) {
                return response()->json([
                    'success' => false,
                    'message' => 'This QR code has already been scanned.',
                    'mapped_count' => $product->identifiers()->count()
                ], 400);
            }

            try {
                DB::beginTransaction();

                // Create the QR code record
                ProductIdentifier::create([
                    'product_id' => $product->id,
                    'qr_code' => $scannedQr,
                    'rfid' => $request->rfid,
                ]);

                DB::commit();

                $updatedMappedCount = $product->identifiers()->count();

                return response()->json([
                    'success' => true,
                    'message' => 'Identifier mapped successfully!',
                    'mapped_count' => $updatedMappedCount
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error storing product identifier: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error mapping identifier: ' . $e->getMessage(),
                    'mapped_count' => $product->identifiers()->count()
                ], 500);
            }
        }


    public function showScanResultPage()
    {
        return view('admin.scan_qr_result');
    }

    /**
     * Look up a product based on a scanned QR code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookupIdentifier(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $identifier = ProductIdentifier::with('product')->where('qr_code', $request->qr_code)->first();

        if ($identifier) {
            return response()->json([
                'success' => true,
                'message' => 'Product found!',
                'data' => [
                    'product_name' => $identifier->product->productName,
                    'qr_code' => $identifier->qr_code,
                    'rfid' => $identifier->rfid,
                    'image' => asset('storage/' . $identifier->product->image1) // Assuming 'image1' is the correct image field
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No product found for this QR code.'
        ], 404);
    }



// In your ProductIdentifierController


        public function generateQr($id)
        {
            try {
                $product = Product::findOrFail($id);
                $totalQuantity = $product->total_stock;
                $mappedCount = $product->identifiers()->count();

                // Check if all QR codes have already been generated
                if ($mappedCount >= $totalQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'All QR codes for this product have already been generated.'
                    ]);
                }
                
                // Calculate how many QR codes to generate
                $codesToGenerate = $totalQuantity - $mappedCount;
                $generatedCodes = [];
                
                // Generate multiple QR codes for the remaining quantity
                for ($i = 0; $i < $codesToGenerate; $i++) {
                    do {
                        $qrCodeString = 'PROD'. Str::random(6);
                    } while (ProductIdentifier::where('qr_code', $qrCodeString)->exists());

                    // Create record for each QR code
                    ProductIdentifier::create([
                        'product_id' => $product->id,
                        'qr_code' => $qrCodeString,
                    ]);
                    
                    $generatedCodes[] = $qrCodeString;
                }

                return response()->json([
                    'success' => true,
                    'message' => $codesToGenerate . ' QR codes generated successfully.',
                    'generated_count' => $codesToGenerate,
                    'generated_codes' => $generatedCodes,
                    'mapped_count' => $mappedCount + $codesToGenerate
                ]);

            } catch (\Exception $e) {
                Log::error('QR Generation Error: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate QR codes: ' . $e->getMessage()
                ], 500);
            }
        }


// show Qr Code 
        public function showQRCodes($id)
        {
            $product = Product::findOrFail($id);
            $qrCodes = ProductIdentifier::where('product_id', $id)->get();
            
            return view('admin.showQr', compact('product', 'qrCodes'));
        }



            public function generateQrCode(Request $request)
            {
                $qrData = $request->input('qr_code_data');

                if (empty($qrData)) {
                    return response()->json(['error' => 'QR code data is missing.'], 400);
                }

                try {
                    // Generate the QR code as a base64 encoded string
                    $qrCode = QrCode::size(200)->generate($qrData);
                    $base64Image = 'data:image/svg+xml;base64,' . base64_encode($qrCode);

                    return response()->json([
                        'qr_code_image' => $base64Image,
                        'success' => true
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'error' => 'Failed to generate QR code: ' . $e->getMessage(),
                        'success' => false
                    ], 500);
                }
            }
}