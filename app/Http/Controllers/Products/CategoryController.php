<?php

namespace App\Http\Controllers\Products;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->only(['id', 'name']);
        $isNew = !isset($data['id']);
        if ($isNew) {
            $category = Category::create($data);
            Message::success('Categoria criada com sucesso');
        } else {
            $category = Category::find($data['id']);
            $category->update($data);
            Message::success('Categoria atualizada com sucesso');
        }

        return redirect()->route('products.create');
    }

    public function delete(int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            Message::error('Não é possível deletar uma categoria que está sendo utilizada');
            return json_encode(['success' => false]);
        }
        $category->delete();
        Message::success('Categoria deletada com sucesso');
        return json_encode(['success' => true]);
    }
}
