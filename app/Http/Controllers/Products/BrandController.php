<?php

namespace App\Http\Controllers\Products;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Product\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->only(['id', 'name']);
        $isNew = !isset($data['id']);
        if ($isNew) {
            $brand = Brand::create($data);
            Message::success('Marca criada com sucesso');
        } else {
            $brand = Brand::find($data['id']);
            $brand->update($data);
            Message::success('Marca atualizada com sucesso');
        }

        return redirect()->route('products.create');
    }

    public function delete(int $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            Message::error('Não é possível deletar uma marca que está sendo utilizada');
            return json_encode(['success' => false]);
        }
        $brand->delete();
        Message::success('Marca deletada com sucesso');
        return json_encode(['success' => true]);
    }
}
