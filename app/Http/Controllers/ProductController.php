<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $products = Product::query()->get();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'status' => false]);
        }

        return response()->json(['results' => count($products), 'products' => $products, 'status' => true], 200);
    }

    public function create(Request $request)
    {

        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|max:20|unique:products,nombre',
                'descripcion' => 'required|max:200',
                'cantidad' => 'required|numeric|max:2147483646|',
                'valor' => 'required|numeric|max:2147483646|',
                'moneda' => 'required|max:10',
                'category_id' => [
                    'required',
                    Rule::exists('categories', 'id'),
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'La información recibida no es valida.', 'errors' => $validator->errors(), 'status' => false], 400);
            } 
                
            Product::create(array_merge($validator->validated()));


            DB::commit();

            return response()->json([
                'message' => 'El producto a sido creado correctamente.',
                'status' => true
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage(), 'status' => false]);
        }
    }

    public function modify(Request $request)
    {

        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'id' => 'exists:products',
                'nombre' => [
                    'required',
                    Rule::unique('products')->ignore($request->id)
                ],
                'descripcion' => 'required|max:200',
                'cantidad' => 'required|numeric|max:2147483646|',
                'valor' => 'required|numeric|max:2147483646|',
                'moneda' => 'required|max:10',
                'category_id' => [
                    'required',
                    Rule::exists('categories', 'id'),
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'La información recibida no es valida.', 'errors' => $validator->errors(), 'status' => false], 400);
            } 
            
            $product = Product::find($request->id);

            if (!isset($product)) {
                return response()->json(['message' => 'El registro que desea modificar ha sido eliminado.', 'status' => false], 400);
            }
            
            $product->fill($request->all());
            $product->save();


            DB::commit();

            return response()->json([
                'message' => 'El producto a sido modificado correctamente.',
                'status' => true
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage(), 'status' => false]);
        }
    }

    public function destroy($id)
    {

        try {
            $product = Product::find($id);

            if (!isset($product)) {
                return response()->json(['message' => 'El producto indicado no existe', 'status' => false], 400);
            }

            $product->delete();

            return response()->json([
                'message' => 'El producto a sido eliminado correctamente.',
                'status' => true
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage(), 'status' => false]);
        }

    }
}
