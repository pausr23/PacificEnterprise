<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\DishesCategory;
use App\Models\RegisteredDish;
use App\Models\Subcategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminDishController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private const DISHES_FOLDER = 'dishes';
    private const DEFAULT_IMAGE = 'default.jpg';
    private const INVOICE_PATH = 'invoices/invoice_';
    private const PDF_EXTENSION = '.pdf';


    public function index(Request $request)
    {
        $searchTerm = $request->input('dish');
        $categoryId = $request->input('category');

        $query = RegisteredDish::select(
            'registered_dishes.id',
            'dishes_categories.name as category',
            'subcategories.name as subcategory',
            'registered_dishes.title',
            'registered_dishes.units',
            'registered_dishes.description',
            'registered_dishes.purchase_price',
            'registered_dishes.sale_price'
        )
            ->join('dishes_categories', 'registered_dishes.dishes_categories_id', '=', 'dishes_categories.id')
            ->join('subcategories', 'registered_dishes.subcategories_id', '=', 'subcategories.id');

        if (!empty($searchTerm)) {
            $query->where('registered_dishes.title', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($categoryId) && $categoryId != 0) {
            $query->where('dishes_categories.id', $categoryId);
        }

        $dishes = $query->get();

        $categories = DishesCategory::all();
        $subcategories = Subcategory::all();
        $total = $dishes->count();

        return view('dishes.index', compact('dishes', 'total', 'categories', 'subcategories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedCategoryId = $request->input('dishes_categories_id');

        $categories = DishesCategory::all();
        $subcategories = Subcategory::all();

        return view('dishes.create', compact('categories', 'subcategories', 'selectedCategoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'description' => 'nullable|string',
            'units' => 'required|integer',
            'dishes_categories_id' => 'required|exists:dishes_categories,id',
            'subcategories_id' => 'required|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imageUrl = self::DEFAULT_IMAGE;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file->isValid()) {
                try {
                    $uploadResult = Cloudinary::upload($file->getPathname(), [
                        'folder' => self::DISHES_FOLDER,
                    ]);
                    
                    logger('Imagen cargada: ', [
                        'url' => $uploadResult->getSecurePath(),
                        'public_id' => $uploadResult->getPublicId(),
                    ]);
                    
                    $imageUrl = $uploadResult->getSecurePath();
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->withErrors([
                        'image' => 'Error al subir la imagen a Cloudinary: ' . $e->getMessage()
                    ]);
                }
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'image' => 'El archivo de imagen no es válido.'
                ]);
            }
        }

        try {
            RegisteredDish::create([
                'dishes_categories_id' => $request->dishes_categories_id,
                'subcategories_id' => $request->subcategories_id,
                'title' => $request->title,
                'description' => $request->description,
                'units' => $request->units,
                'image' => $imageUrl,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'general' => 'Error al registrar el platillo: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('dishes.index')->with('success', 'Item registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dish = RegisteredDish::select(
            'dishes_categories.name as category',
            'registered_dishes.title as title',
            'registered_dishes.description',
            'registered_dishes.image',
            'registered_dishes.purchase_price',
            'registered_dishes.sale_price',
            'registered_dishes.units',
            'subcategories.name as subcategory'
        )
            ->join('dishes_categories', 'registered_dishes.dishes_categories_id', '=', 'dishes_categories.id')
            ->join('subcategories', 'registered_dishes.subcategories_id', '=', 'subcategories.id')
            ->where('registered_dishes.id', $id)
            ->first();

        return view('dishes.show', compact('dish'));
    }

    public function showInvoices(string $id)
    {
        $order = DB::table('invoices')
            ->join('payment_methods', 'invoices.payment_method_id', '=', 'payment_methods.id')
            ->select('invoices.*', 'payment_methods.name as payment_method_name')
            ->where('invoices.id', $id)
            ->first();
    
        $orderDetails = DB::table('transactions')->where('id', $order->invoice_number)->get();
    
        return view('factures.show', compact('order', 'orderDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dish = RegisteredDish::find($id);
        $categories = DishesCategory::all();
        $subcategories = Subcategory::all();
        
        $currentImage = $dish->image;

        return view('dishes.edit', compact('dish', 'categories', 'subcategories', 'currentImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'description' => 'nullable|string',
            'units' => 'required|integer',
            'dishes_categories_id' => 'required|exists:dishes_categories,id',
            'subcategories_id' => 'required|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $dish = RegisteredDish::find($id);
        $imagePath = $dish->image;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                $publicId = str_replace('https://res.cloudinary.com/your-cloud-name/image/upload/', '', $imagePath);
                $publicId = str_replace('.jpg', '', $publicId);
                Cloudinary::destroy($publicId);
            }

            $image = $request->file('image');
            try {
                $uploadResult = Cloudinary::upload($image->getPathname(), [
                    'folder' => 'dishes'
                ]);
                $imagePath = $uploadResult->getSecurePath();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['image' => 'Error al subir la imagen: ' . $e->getMessage()]);
            }
        }

        $dish->update([
            'dishes_categories_id' => $request->dishes_categories_id,
            'subcategories_id' => $request->subcategories_id,
            'title' => $request->title,
            'description' => $request->description,
            'units' => $request->units,
            'image' => $imagePath,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
        ]);

        return redirect()->route('dishes.index')->with('success', 'Item actualizado correctamente.');
    }


    public function order(Request $request)
    {
        $searchTerm = $request->input('dish');
        $categoryId = $request->input('category');
        $subcategoryId = $request->input('subcategory');
        $paymentMethodId = $request->input('payment_method', 0);

        $query = RegisteredDish::with('category', 'subcategory');

        if (!empty($searchTerm)) {
            $query->where('registered_dishes.title', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($categoryId) && $categoryId != 0) {
            $query->where('dishes_categories.id', $categoryId);
        }

        if (!empty($subcategoryId) && $subcategoryId != 0) {
            $query->where('subcategories.id', $subcategoryId);
        }

        if ($paymentMethodId != 0) {
            $query->where('payment_method_id', $paymentMethodId);
        }

        $dishes = $query->get();

        $categories = DishesCategory::with('subcategories')->get();

        $subcategories = !empty($categoryId) ?
            Subcategory::where('dishes_categories_id', $categoryId)->get() :
            Subcategory::all();

        $addedItems = $request->input('addedItems');
        $total = 0;

        if ($addedItems) {
            foreach ($addedItems as $item) {
                $dishId = $item['id'];
                $quantity = $item['quantity'];
                $dish = RegisteredDish::find($dishId);

                if ($dish) {
                    $total += $dish->sale_price * $quantity;
                }
            }
        }

        return view('factures.ordering', compact('dishes', 'total', 'categories', 'subcategories', 'addedItems'));
    }

    public function storeOrder(Request $request)
    {

        $addedItems = json_decode($request->input('addedItems'), true);
        $paymentMethodId = $request->input('payment_method_id');
        $note = $request->input('note', '');
        $voucherNumber = $request->input('voucher_number', null);

        $total = 0;

        $addedItemsWithDetails = [

        ];

        foreach ($addedItems as $item) {
            $dish = RegisteredDish::find($item['id']);
            if ($dish) {
                $total += $dish->sale_price * $item['quantity'];

                $addedItemsWithDetails[] = [
                    'id' => $item['id'],
                    'title' => $dish->title,
                    'quantity' => $item['quantity'],
                    'price' => $dish->sale_price
                ];

                $dish->units -= $item['quantity'];
                $dish->save();
            }
        }

        $lastInvoice = DB::table('invoices')->orderBy('invoice_number', 'desc')->first();
        $invoiceNumber = $lastInvoice ? $lastInvoice->invoice_number + 1 : 1;

        $invoiceId = DB::table('invoices')->insertGetId([
            'invoice_number' => $invoiceNumber,
            'payment_method_id' => $paymentMethodId,
            'total' => $total,
            'note' => $note,
            'voucher_number' => $voucherNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('transactions')->insert([
            'id' => $invoiceNumber,
            'transaction_Date' => now(),
            'total_amount' => $dish->sale_price * $item['quantity'],
            'payment_method_id' => $paymentMethodId,
            'is_ready' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($addedItems as $item) {
            $dish = RegisteredDish::find($item['id']);

            if ($dish) {
                DB::table('details_transaction_rest')->insert([
                    'invoice_number' => $invoiceNumber,
                    'dishes_categories_id' => $dish->dishes_categories_id,
                    'registered_dishes_id' => $item['id'],
                    'payment_method_id' => $paymentMethodId,
                    'registered_sale_price' => $dish->sale_price,
                    'quantity' => $item['quantity'],
                    'total' => $dish->sale_price * $item['quantity'],
                    'note' => $note,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $pdf = new Dompdf();
        $pdf->loadHtml(view('factures.invoice', compact('addedItemsWithDetails', 'paymentMethodId', 'total'))->render());
        $pdf->setPaper('legal', 'portrait'); // Formato legal (8.5 x 14 pulgadas)
        $pdf->render();
        $output = $pdf->output();
        $filePath = self::INVOICE_PATH . $invoiceNumber . self::PDF_EXTENSION;
        file_put_contents(public_path($filePath), $output);

        return view('factures.invoice', compact('addedItemsWithDetails', 'paymentMethodId', 'total', 'filePath', 'invoiceNumber'));
    }

    public function showOrderInKitchen()
    {
        $transactionIds = DB::table('invoices')
            ->where('is_ready', 1)
            ->pluck('invoice_number')
            ->toArray();

        $details = DB::table('details_transaction_rest')
            ->whereIn('invoice_number', $transactionIds)
            ->select('invoice_number', 'registered_dishes_id', 'dishes_categories_id', 'quantity')
            ->get()
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();

        $registeredDishes = DB::table('registered_dishes')
            ->whereIn('id', array_column($details, 'registered_dishes_id'))
            ->pluck('title', 'id')
            ->toArray();

        foreach ($details as &$detail) {
            $detail['title'] = $registeredDishes[$detail['registered_dishes_id']] ?? 'Unknown';
        }

        $transactions = [];
        foreach ($transactionIds as $id) {
            $transactions[$id] = [
                'items' => array_filter($details, function ($detail) use ($id) {
                    return $detail['invoice_number'] == $id;
                })
            ];
        }

        return view('factures.order', ['transactions' => $transactions]);
    }

    public function markOrderAsReady(Request $request)
    {
        $invoiceNumber = $request->input('invoice_number');

        DB::table('invoices')
            ->where('invoice_number', $invoiceNumber)
            ->update(['is_ready' => 0]);

        return redirect()->back()->with('success', 'Orden marcada como lista.');
    }

    public function history(Request $request)
    {
        $paymentMethodId = $request->input('payment_method');

        $query = DB::table('invoices')
            ->join('payment_methods', 'invoices.payment_method_id', '=', 'payment_methods.id')
            ->select('invoices.*', 'payment_methods.name as payment_method_name')
            ->orderBy('invoices.created_at', 'desc');

        if (!empty($paymentMethodId) && $paymentMethodId != 0) {
            $query->where('invoices.payment_method_id', $paymentMethodId);
        }

        $orders = $query->get();
        $paymentMethods = DB::table('payment_methods')->get();

        return view('factures.history', compact('orders', 'paymentMethods'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dish = RegisteredDish::find($id);
        if ($dish) {
            if (File::exists(public_path('storage/images/' . $dish->image)) && $dish->image != 'default.jpg') {
                File::delete(public_path('storage/images/' . $dish->image));
            }
            $dish->delete();
        }

        return redirect()->route('dishes.index')->with('success', 'Item eliminado correctamente.');
    }


    public function inventory(Request $request)
    {

        $searchTerm = $request->input('dish');
        $categoryId = $request->input('category');

        $query = RegisteredDish::select(
            'registered_dishes.id',
            'dishes_categories.name as category',
            'subcategories.name as subcategory',
            'registered_dishes.title',
            'registered_dishes.units',
            'registered_dishes.purchase_price',
            'registered_dishes.sale_price'
        )
            ->join('dishes_categories', 'registered_dishes.dishes_categories_id', '=', 'dishes_categories.id')
            ->join('subcategories', 'registered_dishes.subcategories_id', '=', 'subcategories.id');

        if (!empty($searchTerm)) {
            $query->where('registered_dishes.title', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($categoryId) && $categoryId != 0) {
            $query->where('dishes_categories.id', $categoryId);
        }

        $dishes = $query->get();

        $categories = DishesCategory::all();
        $subcategories = Subcategory::all();
        $total = $dishes->count();

        return view('dishes.inventory', compact('dishes', 'total', 'categories', 'subcategories'));
    }

}
