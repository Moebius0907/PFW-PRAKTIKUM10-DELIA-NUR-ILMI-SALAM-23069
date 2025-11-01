<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Browsershot\Browsershot;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        // Membuat query builder baru untuk model Product
        $query = Product::query();
        // Cek apakah ada parameter 'search' di request
        if ($request->has('search') && $request->search != '') {
            // Melakukan pencarian berdasarkan nama produk atau informasi
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('sort')) {
            $sort = $request->get('sort');
            $direction = $request->get('direction', 'asc');
            $query->orderBy($sort, $direction);
        }

        
      
        // paginate
        $data = $query->paginate(perPage: 5);
        return view("master-data.product-master.index-product", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("master-data.product-master.create-product");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',      
        ]);


        Product::create($validasi_data);


       return redirect()->back()->with('success', 'Product created successfully!');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::findOrFail($id);
        return view("master-data.product-master.detail-product", compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::findOrFail($id);
        return view('master-data.product-master.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'information' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'producer'=>'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'type' => $request->type,
            'information' => $request->information,
            'qty' => $request->qty,
            'producer'=> $request->producer
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //berdasarkan id
        $product = Product::find($id);
        if ($product){
            $product->delete();
            return redirect()->back()->with('success', 'Product berhasil dihapus.');
        }

        
        return redirect()->back()->with('error', 'Product tidak ditemukan.');
    }

    public function exportExcel () {
        return Excel::download(new ProductsExport, 'product.xlsx');
    }

    public function exportPDF(){
        $products = Product::all(); // Ambil data produk
        $pdf = PDF::loadView('template.products', compact('products'));
        return $pdf->download('products.pdf');

    }


   public function exportImage() {
    // Ambil semua data produk
    $products = Product::all();

    // Render view HTML menjadi string
    $html = view('template.products', compact('products'))->render();

    // Tentukan path untuk menyimpan file JPG
    $path = public_path('products.jpg');

    // Gunakan Browsershot untuk membuat JPG
    Browsershot::html($html)
        ->windowSize(1200, 800)
        ->save($path);

    // Download file JPG
    return response()->download($path);
}

}
