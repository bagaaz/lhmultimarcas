<?php

namespace App\Http\Controllers\Products;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Product\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->only(['id', 'name']);
        $isNew = !isset($data['id']);
        if ($isNew) {
            $size = Size::create($data);
            Message::success('Tamanho criado com sucesso');
        } else {
            $size = Size::find($data['id']);
            $size->update($data);
            Message::success('Tamanho atualizado com sucesso');
        }

        return redirect()->route('products.create');
    }

    public function delete(int $id)
    {
        $size = Size::find($id);
        if (!$size) {
            Message::error('Não é possível deletar um tamanho que está sendo usado');
            return json_encode(['success' => false]);
        }
        $size->delete();
        Message::success('Tamanho deletado com sucesso');
        return json_encode(['success' => true]);
    }
}
